<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('adminlte/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('adminlte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }} nav-link">
                        <i class="nav-icon fas fa-chart-pie"></i> <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-header">Master Data</li>
                <!-- @if(in_array(Auth::user()->role, ['owner', 'manager'])) -->
                    <li class="nav-item">
                        <?php
                        $itemRoutes = ['item.index', 'item.create', 'item.edit'];
                        $isItemActive = in_array(Route::currentRouteName(), $itemRoutes);
                        ?>
                        <a href="{{ route('item.index') }}" class="{{ $isItemActive ? 'active' : '' }} nav-link">
                            <i class="nav-icon fas fa-boxes"></i> <p>
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
                            <i class="nav-icon fas fa-warehouse"></i> <p>
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
                            <i class="nav-icon fas fa-money-bill-wave"></i> <p>
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
                            <i class="nav-icon fas fa-shopping-cart"></i> <p>
                                Order
                            </p>
                        </a>
                    </li>
                <!-- @endif -->
                <!-- @if(in_array(Auth::user()->role, ['owner', 'cashier'])) -->
                <!-- @endif -->
            </ul>
        </nav>
    </div>
</aside>