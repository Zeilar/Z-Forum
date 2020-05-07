<script>
	// Spawn alert element on top of the site with message
	function ajax_alert(response) {
		if ($('.alert').length) {
			$('.alert').remove();
		}
        
		let alertIcon = '';

		switch (response.type) {
			case 'success':
				alertIcon = '<i class="fas fa-check"></i>';
				break;
			case 'error':
				alertIcon = '<i class="fas fa-exclamation"></i>';
				break;
			case 'warning':
				alertIcon = '<i class="fas fa-exclamation-triangle"></i>';
				break;
			case 'none':
				return;
			default:
				return;
		}

		let alertContent = `
			<div class="alert ${response.type}">
				${alertIcon}
				<span>${response.message}</span>
				<div>
					<i class="fas close fa-times"></i>
				</div>
			</div>
		`;

		$('#main').prepend(alertContent);

		// Remove alert after a while regardless
		setTimeout(() => {
			// Do a fade animatin before removing
			$('.alert').addClass('fade-out');

			// Remove element after animation is finished, it needs to be the same amount as the animation duration on the element
			setTimeout(() => {
				$('.alert').remove();
			}, 500);
		}, 5000);

		// Remove alert when the X button is clicked
		$('.alert div').click(function() {
			$(this).parents('.alert').remove();
		});
	}
</script>