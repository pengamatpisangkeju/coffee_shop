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
		$totalOrdersThisMonth = Order::whereMonth('date', Carbon::now()->month)
			->whereYear('date', Carbon::now()->year)
			->count();

		$totalItemsSoldThisMonth = OrderDetail::whereHas('order', function ($query) {
			$query->whereMonth('date', Carbon::now()->month)
				->whereYear('date', Carbon::now()->year);
		})->sum('qty');

		$totalRevenueThisMonth = OrderDetail::whereHas('order', function ($query) {
			$query->whereMonth('date', Carbon::now()->month)
				->whereYear('date', Carbon::now()->year);
		})->sum(column: DB::raw('qty * selling_price'));

		$totalExpensesThisMonth = OrderDetail::whereHas('order', function ($query) {
			$query->whereMonth('date', Carbon::now()->month)
				->whereYear('date', Carbon::now()->year);
		})->sum(DB::raw('qty * capital_price'));

		$cashflowRevenueThisMonth = Cashflow::where('type', 'income')
			->whereMonth('date', Carbon::now()->month)
			->whereYear('date', Carbon::now()->year)
			->sum('nominal');

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
		$totalOrdersThisMonth = Order::whereMonth('date', Carbon::now()->month)
			->whereYear('date', Carbon::now()->year)
			->count();

		$totalRevenueThisMonth = OrderDetail::whereHas('order', function ($query) {
			$query->whereMonth('date', Carbon::now()->month)
				->whereYear('date', Carbon::now()->year);
		})->sum(DB::raw('qty * selling_price'));

		$cashflowRevenueThisMonth = Cashflow::where('type', 'income')
			->whereMonth('date', Carbon::now()->month)
			->whereYear('date', Carbon::now()->year)
			->sum('nominal');

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
		$totalOrdersToday = Order::whereDate('date', Carbon::today())->count();

		$totalRevenueToday = OrderDetail::whereHas('order', function ($query) {
			$query->whereDate('date', Carbon::today());
		})->sum(DB::raw('qty * selling_price'));

		return [
			'totalOrdersToday' => $totalOrdersToday,
			'totalRevenueToday' => $totalRevenueToday,
		];
	}
}