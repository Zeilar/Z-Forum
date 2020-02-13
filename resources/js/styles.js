$(document).ready(() => {
	if ($('.popup .unauthorized').length) {
		$('.popup .unauthorized').children('.close-button').click(() => {
			$('.popup').remove();
		});
	}

	$('.settings-item').mouseenter(function() {
		$(this).addClass('active-hover');

		$(this).mouseleave(function() {
			$(this).removeClass('active-hover');
		});
	});
});