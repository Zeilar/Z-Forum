<div class="wrapper color-white d-flex flex-row" id="settings">
	<nav class="settings-nav">
		<ul class="settings-list">
			@if (is_role('superadmin'))
				<li class="superadmin-item rounded bg-dark mb-2">
					<a href="{{route('dashboard_superadmin')}}" class="settings-link rounded <?php if (isset($superadmin)) echo 'active'; ?>">
						Superadmin
					</a>
				</li>
			@endif

			<li class="settings-item bg-dark rounded-top">
				<a href="{{route('dashboard_account')}}" class="settings-link rounded-top <?php if (isset($account)) echo 'active'; ?>">
					Account details
				</a>
			</li>
			<li class="settings-item bg-dark">
				<a href="#" class="settings-link">
					Settings
				</a>
			</li>
			<li class="settings-item bg-dark">
				<a href="#" class="settings-link">
					Help
				</a>
			</li>
			<li class="settings-item bg-dark rounded-bottom">
				<a href="#" class="settings-link rounded-bottom" id="logout">
					Logout
				</a>
			</li>
		</ul>
	</nav>
	<div class="settings-display">
		@yield('dashboard-settings')
	</div>
</div>