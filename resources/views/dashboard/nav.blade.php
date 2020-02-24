{{-- Passed variables: $active --}}
<?php $active = $active ?? ''; ?>
<nav class="dashboard-nav">
	<ul class="nav-list d-flex flex-row">
		<li class="nav-item @if ($active === 'account') active @endif">
			<a href="#" class="nav-link">
				Account
			</a>
		</li>
		<li class="nav-item @if ($active === 'superadmin') active @endif">
			<a href="#" class="nav-link">
				Superadmin
			</a>
		</li>
		<li class="nav-item @if ($active === 'settings') active @endif">
			<a href="#" class="nav-link">
				Settings
			</a>
		</li>
	</ul>
</nav>