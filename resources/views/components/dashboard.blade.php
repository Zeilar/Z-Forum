<div class="wrapper color-white d-flex flex-row" id="settings">
	<nav class="settings-nav">
		<ul class="settings-list">
			@if (is_role('superadmin'))
				<li class="settings-item <?php if (isset($superadmin)) echo 'active'; ?>">
					<a href="{{route('dashboard_superadmin')}}" class="settings-link">
						Superadmin
					</a>
				</li>
			@endif

			<li class="settings-item <?php if (isset($account)) echo 'active'; ?>">
				<a href="{{route('dashboard_account')}}" class="settings-link">
					Account details
				</a>
			</li>
			<li class="settings-item">
				<a href="#" class="settings-link">
					Settings
				</a>
			</li>
			<li class="settings-item">
				<a href="#" class="settings-link">
					Help
				</a>
			</li>
			<li class="settings-item" id="logout">
				<a href="#" class="settings-link"">
					Logout
				</a>
			</li>
		</ul>
	</nav>
	<div class="settings-display">
		@yield('dashboard-settings')
	</div>
</div>