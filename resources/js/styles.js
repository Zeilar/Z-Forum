$(document).ready(() => {
	// Dashboard settings menu size animation
	$('.settings-item').mouseenter(function() {
		$(this).addClass('active-hover');

		$(this).mouseleave(function() {
			$(this).removeClass('active-hover');
		});
	});

	// Open modal if a session error is found
	if ($('#errorModal')) {
		$('#errorModal').modal('show');
	}
});