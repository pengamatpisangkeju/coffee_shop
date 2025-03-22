<li class="nav-header">Master Data</li>
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