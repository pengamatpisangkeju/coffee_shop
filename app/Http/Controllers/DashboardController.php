<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cashflow;

class DashboardController extends Controller
{
	public function __invoke()
	{
		$user = Auth::user();

		if (!$user) {
			return redirect()->to('login');
		}

		// Ambil data berdasarkan role
		switch ($user->role) {
			case 'owner':
				$data = $this->getOwnerDashboardData();
				break;

			case 'manager':
				$data = $this->getManagerDashboardData();
				break;

			case 'cashier':
				$data = $this->getCashierDashboardData();
				break;

			default:
				$data = [];
				break;
		}

		return view('dashboard.' . $user->role, $data);
	}

	private function getOwnerDashboardData()
	{
		// Hitung total order bulan ini
		$totalOrdersThisMonth = Order::whereMonth('date', Carbon::now()->month)
			->whereYear('date', Carbon::now()->year)
			->count();

		// Hitung total items yang terjual bulan ini
		$totalItemsSoldThisMonth = OrderDetail::whereHas('order', function ($query) {
			$query->whereMonth('date', Carbon::now()->month)
				->whereYear('date', Carbon::now()->year);
		})->sum('qty');

		// Hitung total revenue dari orders bulan ini (qty * selling_price)
		$totalRevenueThisMonth = OrderDetail::whereHas('order', function ($query) {
			$query->whereMonth('date', Carbon::now()->month)
				->whereYear('date', Carbon::now()->year);
		})->sum(column: DB::raw('qty * selling_price'));

		// Hitung total expenses dari orders bulan ini (qty * capital_price)
		$totalExpensesThisMonth = OrderDetail::whereHas('order', function ($query) {
			$query->whereMonth('date', Carbon::now()->month)
				->whereYear('date', Carbon::now()->year);
		})->sum(DB::raw('qty * capital_price'));

		// Hitung total revenue dari cashflow (tipe = 'income')
		$cashflowRevenueThisMonth = Cashflow::where('type', 'income')
			->whereMonth('date', Carbon::now()->month)
			->whereYear('date', Carbon::now()->year)
			->sum('nominal');

		// Hitung total expenses dari cashflow (tipe = 'expense')
		$cashflowExpensesThisMonth = Cashflow::where('type', 'expense')
			->whereMonth('date', Carbon::now()->month)
			->whereYear('date', Carbon::now()->year)
			->sum('nominal');

		return [
			'totalOrdersThisMonth' => $totalOrdersThisMonth,
			'totalItemsSoldThisMonth' => $totalItemsSoldThisMonth,
			'totalRevenueThisMonth' => $totalRevenueThisMonth,
			'totalExpensesThisMonth' => $totalExpensesThisMonth,
			'cashflowRevenueThisMonth' => $cashflowRevenueThisMonth,
			'cashflowExpensesThisMonth' => $cashflowExpensesThisMonth,
		];
	}

	private function getManagerDashboardData()
	{
		// Hitung total order bulan ini
		$totalOrdersThisMonth = Order::whereMonth('date', Carbon::now()->month)
			->whereYear('date', Carbon::now()->year)
			->count();

		// Hitung total revenue dari orders bulan ini (qty * selling_price)
		$totalRevenueThisMonth = OrderDetail::whereHas('order', function ($query) {
			$query->whereMonth('date', Carbon::now()->month)
				->whereYear('date', Carbon::now()->year);
		})->sum(DB::raw('qty * selling_price'));

		// Hitung total revenue dari cashflow (tipe = 'income')
		$cashflowRevenueThisMonth = Cashflow::where('type', 'income')
			->whereMonth('date', Carbon::now()->month)
			->whereYear('date', Carbon::now()->year)
			->sum('nominal');

		// Hitung total expenses dari cashflow (tipe = 'expense')
		$cashflowExpensesThisMonth = Cashflow::where('type', 'expense')
			->whereMonth('date', Carbon::now()->month)
			->whereYear('date', Carbon::now()->year)
			->sum('nominal');

		return [
			'totalOrdersThisMonth' => $totalOrdersThisMonth,
			'totalRevenueThisMonth' => $totalRevenueThisMonth,
			'cashflowRevenueThisMonth' => $cashflowRevenueThisMonth,
			'cashflowExpensesThisMonth' => $cashflowExpensesThisMonth,
		];
	}

	private function getCashierDashboardData()
	{
		// Hitung total order hari ini
		$totalOrdersToday = Order::whereDate('date', Carbon::today())->count();

		// Hitung total revenue hari ini (qty * selling_price)
		$totalRevenueToday = OrderDetail::whereHas('order', function ($query) {
			$query->whereDate('date', Carbon::today());
		})->sum(DB::raw('qty * selling_price'));

		return [
			'totalOrdersToday' => $totalOrdersToday,
			'totalRevenueToday' => $totalRevenueToday,
		];
	}
}