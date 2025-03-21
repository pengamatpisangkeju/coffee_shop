<li class="nav-header">Master Data</li>
<li class="nav-item">
	<?php
$itemRoutes = ['item.index', 'item.create', 'item.edit'];
$isItemActive = in_array(Route::currentRouteName(), $itemRoutes);
															?>
	<a href="{{ route('item.index') }}" class="{{ $isItemActive ? 'active' : '' }} nav-link">
		<i class="nav-icon fas fa-boxes"></i>
		<p>
			Item
		</p>
	</a>
</li>
<li class="nav-item">
	<?php
$itemSupplyRoutes = ['item-supply.index', 'item-supply.create', 'item-supply.edit'];
$isItemSupplyActive = in_array(Route::currentRouteName(), $itemSupplyRoutes);
															?>
	<a href="{{ route('item-supply.index') }}" class="{{ $isItemSupplyActive ? 'active' : '' }} nav-link">
		<i class="nav-icon fas fa-warehouse"></i>
		<p>
			Item Supply
		</p>
	</a>
</li>
<li class="nav-item">
	<?php
$cashflowRoutes = ['cashflow.index', 'cashflow.create', 'cashflow.edit'];
$isCashflowActive = in_array(Route::currentRouteName(), $cashflowRoutes);
									?>
	<a href="{{ route('cashflow.index') }}" class="{{ $isCashflowActive ? 'active' : '' }} nav-link">
		<i class="nav-icon fas fa-money-bill-wave"></i>
		<p>
			Cashflow
		</p>
	</a>
</li>
<li class="nav-item">
	<?php
$orderRoutes = ['order.index', 'order.create', 'order.edit'];
$isOrderActive = in_array(Route::currentRouteName(), $orderRoutes);
										?>
	<a href="{{ route('order.index') }}" class="{{ $isOrderActive ? 'active' : '' }} nav-link">
		<i class="nav-icon fas fa-shopping-cart"></i>
		<p>
			Order
		</p>
	</a>
</li>
<li class="nav-item">
	<?php
$paymentMethodRoutes = ['payment-method.index', 'payment-method.create', 'payment-method.edit'];
$isPaymentMethodActive = in_array(Route::currentRouteName(), $paymentMethodRoutes);
										?>
	<a href="{{ route('payment-method.index') }}" class="{{ $isPaymentMethodActive ? 'active' : '' }} nav-link">
		<i class="nav-icon fas fa-credit-card"></i>
		<p>
			Payment Method
		</p>
	</a>
</li>
<li class="nav-header">Report</li>