$(document).ready(() => {
	if ($('.popup .unauthorized').length) {
		$('.popup .unauthorized').children('.close-button').click(() => {
			$('.popup').remove();
		});
	}
});