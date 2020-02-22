{{-- Passed variables: $active --}}
<nav class="dashboard-nav">
	<ul class="nav-list d-flex flex-row">
		<li class="nav-item @if ($active === 'account') active @endif">
			Account
		</li>
		<li class="nav-item @if ($active === 'superadmin') active @endif">
			Superadmin
		</li>
		<li class="nav-item @if ($active === 'settings') active @endif">
			Settings
		</li>
	</ul>
</nav>