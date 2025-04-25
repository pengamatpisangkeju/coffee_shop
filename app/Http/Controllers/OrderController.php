<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Cashier;
use App\Models\OrderDetail;
use App\Models\PaymentMethod;
use Auth;
use DB;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
	public function index(Request $request)
	{
		if ($request->ajax()) {
			$orders = Order::with(['cashier', 'paymentMethod']);

			return DataTables::eloquent($orders)
				->addIndexColumn()
				->addColumn('cashier_name', function ($order) {
					return $order->cashier->name;
				})
				->addColumn('total_price', function ($order) {
					$totalPrice = $order->orderDetail->sum(function ($detail) {
						return $detail->selling_price * $detail->qty;
					});
					return $totalPrice;
				})
				->addColumn('total_items', function ($order) {
					return $order->orderDetail->sum('qty');
				})
				->addColumn('payment_method_name', function ($order) {
					return $order->paymentMethod->method;
				})
				->addColumn('action', function ($order) {
					if (Auth::user()->role != 'cashier') return '-';
					
					return '
            <a href="' . route('order.detail', ['order' => $order->id]) . '" class="btn btn-primary btn-sm">Detail</a>
            <form id="delete-form-' . $order->id . '" action="' . route('order.destroy', ['order' => $order->id]) . '" method="POST" style="display: inline-block;">
                ' . csrf_field() . '
                ' . method_field('DELETE') . '
                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $order->id . ')">Delete</button>
            </form>
          ';
				})
				->rawColumns(['action'])
				->make(true);
		}

		return view('order.index');
	}

	public function create()
	{
		$paymentMethods = PaymentMethod::all();
		return view('order.create', ['paymentMethods' => $paymentMethods]);
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'item_id' => 'required|array',
			'item_id.*' => 'exists:items,id',
			'discount' => 'required|numeric|min:0',
			'discount_type' => 'required|in:percentage,amount',
			'payment_method_id' => 'required|exists:payment_methods,id',
		]);

		DB::beginTransaction();

		try {
			$order = Order::create([
				'cashier_id' => Auth::user()->cashier->id,
				'discount' => $validated['discount'],
				'discount_type' => $validated['discount_type'],
				'date' => now(),
				'payment_method_id' => $validated['payment_method_id'],
			]);

			foreach ($validated['item_id'] as $itemId) {
				$qty = 1;
				$item = Item::find($itemId);
				if ($item) {
					OrderDetail::create([
						'order_id' => $order->id,
						'item_id' => $itemId,
						'capital_price' => $item->capital_price,
						'selling_price' => $item->selling_price,
						'qty' => $qty,
					]);

					$item->update([
						'qty' => $item->qty - $qty,
					]);
				}
			}

			DB::commit();
			return redirect()->route('order.index')->with('success', 'Order created .');
		} catch (\Exception $e) {
			DB::rollback();
			return redirect()->back()->with('error', 'Failed to create order. ' . $e->getMessage());
		}
	}

	public function show(Order $order)
	{
		$order->load(['cashier', 'paymentMethod', 'orderDetail.item']); // Eager load relations
		return view('order.detail', ['order' => $order]);
	}

	public function edit(Order $order)
	{
		$cashiers = Cashier::all();
		$paymentMethods = PaymentMethod::all();
		return view('order.edit', ['order' => $order, 'cashiers' => $cashiers, 'paymentMethods' => $paymentMethods]);
	}

	public function update(Request $request, Order $order)
	{
		$validated = $request->validate([
			'cashier_id' => ['required', 'exists:cashiers,id'],
			'order_number' => ['required', 'unique:orders,order_number,' . $order->id],
			'discount' => ['nullable', 'numeric'],
			'discount_type' => ['nullable', 'in:flat,percentage'],
			'date' => ['required', 'date'],
			'status' => ['required', 'in:pending,preparing,completed,cancelled'],
			'payment_method_id' => ['required', 'exists:payment_methods,id'],
		]);

		$order->update($validated);

		return redirect()->route('order.index')->with('success', 'Order updated.');
	}

	public function destroy(Order $order)
	{
		$order->delete();

		return redirect()->route('order.index')->with('success', 'Order deleted.');
	}
}