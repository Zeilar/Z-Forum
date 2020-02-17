// Latest posts slider
$(document).ready(function() {
	// Init the slides' positions and the index value
	let slidesIndex = 0;
	$('#posts-slider .latest-post').each(function(i) {
		$(this).attr('style', `transform: translateX(${i * 100}%);`);
	});

	// Latest posts carousel slider
	function posts_slide() {
		// Put the first in lane back last in line, but don't do it the very first time to prevent teleportation
		if (slidesIndex > 0) {
			let first = $('#posts-slider .latest-post').first();
			first.remove();
			$('#posts-slider').append(first);
		}

		// Move the slides
		$('#posts-slider .latest-post').each(function(i) {
			$(this).attr('style', `transition: transform 1s linear; transform: translateX(${(i - 1) * 100}%);`);
		});

		// To make sure the first code block runs every iteration after the first
		slidesIndex++;
	}

	// Continously run the carousel
	setInterval(() => {
		posts_slide();
	}, 5000);
});