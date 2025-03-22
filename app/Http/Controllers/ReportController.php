<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Cashflow;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
	public function transaction(Request $request)
	{
		$period = $request->period ?? 'monthly';
		$month = $request->month;
		$year = $request->year;

		$labels = [];
		$data = [];

		$chartQuery = Order::query();

		if ($period === 'monthly') {
			if ($year && $month) {
				$startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
				$endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
				$chartQuery->whereBetween('date', [$startDate, $endDate]);

				for ($i = 1; $i <= $startDate->daysInMonth; $i++) {
					$date = Carbon::createFromDate($year, $month, $i);
					$dayStart = $date->copy()->startOfDay();
					$dayEnd = $date->copy()->endOfDay();
					$labels[] = $date->format('d');
					$data[] = Order::whereBetween('date', [$dayStart, $dayEnd])->count();
				}
			} else {
				$startDate = Carbon::now()->startOfMonth();
				$endDate = Carbon::now()->endOfMonth();
				$chartQuery->whereBetween('date', [$startDate, $endDate]);

				for ($i = 1; $i <= Carbon::now()->daysInMonth; $i++) {
					$date = Carbon::createFromDate(Carbon::now()->year, Carbon::now()->month, $i);
					$dayStart = $date->copy()->startOfDay();
					$dayEnd = $date->copy()->endOfDay();
					$labels[] = $date->format('d');
					$data[] = Order::whereBetween('date', [$dayStart, $dayEnd])->count();
				}
			}
		} elseif ($period === 'yearly') {
			if ($year) {
				$startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
				$endDate = Carbon::createFromDate($year, 12, 31)->endOfYear();
				$chartQuery->whereBetween('date', [$startDate, $endDate]);

				for ($i = 1; $i <= 12; $i++) {
					$monthStart = Carbon::createFromDate($year, $i, 1)->startOfMonth();
					$monthEnd = Carbon::createFromDate($year, $i, 1)->endOfMonth();
					$labels[] = Carbon::createFromDate($year, $i, 1)->format('M');
					$data[] = Order::whereBetween('date', [$monthStart, $monthEnd])->count();
				}
			} else {
				$startDate = Carbon::now()->startOfYear();
				$endDate = Carbon::now()->endOfYear();
				$chartQuery->whereBetween('date', [$startDate, $endDate]);

				for ($i = 1; $i <= 12; $i++) {
					$monthStart = Carbon::createFromDate(Carbon::now()->year, $i, 1)->startOfMonth();
					$monthEnd = Carbon::createFromDate(Carbon::now()->year, $i, 1)->endOfMonth();
					$labels[] = Carbon::createFromDate(Carbon::now()->year, $i, 1)->format('M');
					$data[] = Order::whereBetween('date', [$monthStart, $monthEnd])->count();
				}
			}
		}

		$ordersQuery = Order::with(['cashier', 'paymentMethod', 'orderDetail.item']);
		if ($period === 'monthly') {
			if ($year && $month) {
				$startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
				$endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
				$ordersQuery->whereBetween('date', [$startDate, $endDate]);
			} else {
				$startDate = Carbon::now()->startOfMonth();
				$endDate = Carbon::now()->endOfMonth();
				$ordersQuery->whereBetween('date', [$startDate, $endDate]);
			}
		} elseif ($period === 'yearly') {
			if ($year) {
				$startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
				$endDate = Carbon::createFromDate($year, 12, 31)->endOfYear();
				$ordersQuery->whereBetween('date', [$startDate, $endDate]);
			} else {
				$startDate = Carbon::now()->startOfYear();
				$endDate = Carbon::now()->endOfYear();
				$ordersQuery->whereBetween('date', [$startDate, $endDate]);
			}
		}

		$orders = $ordersQuery->get();

		$totalProfit = $orders->sum(function ($order) {
			return $order->orderDetail->sum(function ($detail) {
				return ($detail->selling_price - $detail->capital_price) * $detail->qty;
			});
		});

		if ($request->ajax()) {
			$formattedOrders = $orders->map(function ($order) {
				$totalPrice = $order->orderDetail->sum(function ($detail) {
					return $detail->selling_price * $detail->qty;
				});

				$totalProfit = $order->orderDetail->sum(function ($detail) {
					return ($detail->selling_price - $detail->capital_price) * $detail->qty;
				});

				return [
					'cashier' => $order->cashier,
					'date' => $order->date,
					'payment_method' => $order->paymentMethod,
					'total_price' => number_format($totalPrice, 2, ',', '.'),
					'total_profit' => number_format($totalProfit, 2, ',', '.'),
				];
			});

			return response()->json([
				'labels' => $labels,
				'data' => $data,
				'orders' => $formattedOrders,
				'total_profit' => number_format($totalProfit, 2, ',', '.'),
			]);
		}

		return view('report.transaction', [
			'orders' => $orders,
			'labels' => $labels,
			'data' => $data,
			'total_profit' => number_format($totalProfit, 2, ',', '.'),
		]);
	}

	public function cashflow(Request $request)
	{
		$period = $request->period ?? 'monthly';
		$month = $request->month;
		$year = $request->year;

		$labels = [];
		$dataIncome = [];
		$dataExpense = [];

		$cashflowQuery = Cashflow::query();

		if ($period === 'monthly') {
			if ($year && $month) {
				$startDate = Carbon::createFromDate($year, $month, 1)->startOfMonth();
				$endDate = Carbon::createFromDate($year, $month, 1)->endOfMonth();
				$cashflowQuery->whereBetween('date', [$startDate, $endDate]);

				for ($i = 1; $i <= $startDate->daysInMonth; $i++) {
					$date = Carbon::createFromDate($year, $month, $i);
					$dayStart = $date->copy()->startOfDay();
					$dayEnd = $date->copy()->endOfDay();
					$labels[] = $date->format('d');

					$dataIncome[] = Cashflow::whereBetween('date', [$dayStart, $dayEnd])
						->where('type', 'income')
						->sum('nominal');

					$dataExpense[] = Cashflow::whereBetween('date', [$dayStart, $dayEnd])
						->where('type', 'expense')
						->sum('nominal');
				}
			} else {
				$startDate = Carbon::now()->startOfMonth();
				$endDate = Carbon::now()->endOfMonth();
				$cashflowQuery->whereBetween('date', [$startDate, $endDate]);

				for ($i = 1; $i <= Carbon::now()->daysInMonth; $i++) {
					$date = Carbon::createFromDate(Carbon::now()->year, Carbon::now()->month, $i);
					$dayStart = $date->copy()->startOfDay();
					$dayEnd = $date->copy()->endOfDay();
					$labels[] = $date->format('d');

					$dataIncome[] = Cashflow::whereBetween('date', [$dayStart, $dayEnd])
						->where('type', 'income')
						->sum('nominal');

					$dataExpense[] = Cashflow::whereBetween('date', [$dayStart, $dayEnd])
						->where('type', 'expense')
						->sum('nominal');
				}
			}
		} elseif ($period === 'yearly') {
			if ($year) {
				$startDate = Carbon::createFromDate($year, 1, 1)->startOfYear();
				$endDate = Carbon::createFromDate($year, 12, 31)->endOfYear();
				$cashflowQuery->whereBetween('date', [$startDate, $endDate]);

				for ($i = 1; $i <= 12; $i++) {
					$monthStart = Carbon::createFromDate($year, $i, 1)->startOfMonth();
					$monthEnd = Carbon::createFromDate($year, $i, 1)->endOfMonth();
					$labels[] = Carbon::createFromDate($year, $i, 1)->format('M');

					$dataIncome[] = Cashflow::whereBetween('date', [$monthStart, $monthEnd])
						->where('type', 'income')
						->sum('nominal');

					$dataExpense[] = Cashflow::whereBetween('date', [$monthStart, $monthEnd])
						->where('type', 'expense')
						->sum('nominal');
				}
			} else {
				$startDate = Carbon::now()->startOfYear();
				$endDate = Carbon::now()->endOfYear();
				$cashflowQuery->whereBetween('date', [$startDate, $endDate]);

				for ($i = 1; $i <= 12; $i++) {
					$monthStart = Carbon::createFromDate(Carbon::now()->year, $i, 1)->startOfMonth();
					$monthEnd = Carbon::createFromDate(Carbon::now()->year, $i, 1)->endOfMonth();
					$labels[] = Carbon::createFromDate(Carbon::now()->year, $i, 1)->format('M');

					$dataIncome[] = Cashflow::whereBetween('date', [$monthStart, $monthEnd])
						->where('type', 'income')
						->sum('nominal');

					$dataExpense[] = Cashflow::whereBetween('date', [$monthStart, $monthEnd])
						->where('type', 'expense')
						->sum('nominal');
				}
			}
		}

		$cashflows = $cashflowQuery->get();

		$totalIncome = $cashflows->where('type', 'income')->sum('nominal');
		$totalExpense = $cashflows->where('type', 'expense')->sum('nominal');

		if ($request->ajax()) {
			return response()->json([
				'labels' => $labels,
				'dataIncome' => $dataIncome,
				'dataExpense' => $dataExpense,
				'cashflows' => $cashflows,
				'totalIncome' => number_format($totalIncome, 2, ',', '.'),
				'totalExpense' => number_format($totalExpense, 2, ',', '.'),
			]);
		}

		return view('report.cashflow', [
			'cashflows' => $cashflows,
			'labels' => $labels,
			'dataIncome' => $dataIncome,
			'dataExpense' => $dataExpense,
			'totalIncome' => number_format($totalIncome, 2, ',', '.'),
			'totalExpense' => number_format($totalExpense, 2, ',', '.'),
		]);
	}
}

