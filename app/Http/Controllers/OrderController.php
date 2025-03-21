<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cashier;
use App\Models\PaymentMethod;
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
                ->addColumn('payment_method_name', function ($order) {
                    return $order->paymentMethod->method;
                })
                ->addColumn('action', function ($order) {
                    return '
                        <a href="' . route('order.edit', ['order' => $order->id]) . '" class="btn btn-primary btn-sm">Edit</a>
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
        $cashiers = Cashier::all();
        $paymentMethods = PaymentMethod::all();
        return view('order.create', ['cashiers' => $cashiers, 'paymentMethods' => $paymentMethods]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cashier_id' => ['required', 'exists:cashiers,id'],
            'order_number' => ['required', 'unique:orders'],
            'discount' => ['nullable', 'numeric'],
            'discount_type' => ['nullable', 'in:flat,percentage'],
            'date' => ['required', 'date'],
            'status' => ['required', 'in:pending,preparing,completed,cancelled'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
        ]);

        Order::create($validated);

        return redirect()->route('order.index')->with('success', 'Order created.');
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