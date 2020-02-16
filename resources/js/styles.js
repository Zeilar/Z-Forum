$(document).ready(() => {
	// Dashboard settings menu size animation
	$('.settings-item').mouseenter(function() {
		$(this).addClass('active-hover');

		$(this).mouseleave(function() {
			$(this).removeClass('active-hover');
		});
	});

	// Open modal if a session error/success message is found
	if ($('#errorModal')) {
		$('#errorModal').modal('show');
	} else if ($('#successModal')) {
		$('#successModal').modal('show');
	}
});