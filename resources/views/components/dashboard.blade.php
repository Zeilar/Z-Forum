<div class="wrapper color-white d-flex flex-row" id="settings">
	<nav class="settings-nav">
		<ul class="settings-list">
			@if (is_role('superadmin'))
				<li class="settings-item <?php if (isset($superadmin)) echo 'active'; ?>">
					<h4>
						<a href="{{route('dashboard_superadmin')}}" class="settings-link">
							Superadmin
						</a>
					</h4>
				</li>
			@endif

			<li class="settings-item <?php if (isset($account)) echo 'active'; ?>">
				<h4>
					<a href="{{route('dashboard_account')}}" class="settings-link">
						Account details
					</a>
				</h4>
			</li>
			<li class="settings-item">
				<h4>
					<a href="#" class="settings-link">
						Settings
					</a>
				</h4>
			</li>
			<li class="settings-item">
				<h4>
					<a href="#" class="settings-link">
						Help
					</a>
				</h4>
			</li>
		</ul>
	</nav>
	<div class="settings-display">
		@yield('dashboard-settings')
	</div>
</div>