$(document).ready(function() {
	if ($('.popup .unauthorized').length) {
		$('.popup .unauthorized').children('.close-button').click(function() {
			$('.popup .unauthorized').remove();
			$('.popup').remove();
		});
	}
});