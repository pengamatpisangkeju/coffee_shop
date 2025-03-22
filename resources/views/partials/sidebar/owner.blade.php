<li class="nav-header">Master Data</li>
<li class="nav-item">
	<?php
$userRoutes = ['user.index', 'user.edit', 'user.create']; // Daftar route untuk User
$isUserActive = in_array(Route::currentRouteName(), $userRoutes);
    ?>
	<a href="{{ route('user.index') }}" class="{{ $isUserActive ? 'active' : '' }} nav-link">
		<i class="nav-icon fas fa-users"></i>
		<p>
			User
		</p>
	</a>
</li>
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
<!-- Tambahkan Member -->
<li class="nav-item">
	<?php
$memberRoutes = ['member.index', 'member.create', 'member.edit'];
$isMemberActive = in_array(Route::currentRouteName(), $memberRoutes);
    ?>
	<a href="{{ route('member.index') }}" class="{{ $isMemberActive ? 'active' : '' }} nav-link">
		<i class="nav-icon fas fa-id-card"></i>
		<p>
			Member
		</p>
	</a>
</li>
<!-- Tambahkan Pengajuan -->
<li class="nav-item">
	<?php
$pengajuanRoutes = ['pengajuan.index', 'pengajuan.create', 'pengajuan.edit'];
$isPengajuanActive = in_array(Route::currentRouteName(), $pengajuanRoutes);
    ?>
	<a href="{{ route('pengajuan.index') }}" class="{{ $isPengajuanActive ? 'active' : '' }} nav-link">
		<i class="nav-icon fas fa-file-alt"></i>
		<p>
			Pengajuan
		</p>
	</a>
</li>

<li class="nav-header">Report</li>
<li class="nav-item">
	<?php
$transactionReportRoutes = ['report.transaction'];
$isTransactionReportActive = in_array(Route::currentRouteName(), $transactionReportRoutes);
    ?>
	<a href="{{ route('report.transaction') }}" class="{{ $isTransactionReportActive ? 'active' : '' }} nav-link">
		<i class="nav-icon fas fa-file-invoice-dollar"></i>
		<p>
			Transaction
		</p>
	</a>
</li>
<li class="nav-item">
	<?php
$cashflowReportRoutes = ['report.cashflow'];
$isCashflowReportActive = in_array(Route::currentRouteName(), $cashflowReportRoutes);
    ?>
	<a href="{{ route('report.cashflow') }}" class="{{ $isCashflowReportActive ? 'active' : '' }} nav-link">
		<i class="nav-icon fas fa-chart-line"></i>
		<p>
			Cashflow
		</p>
	</a>
</li>