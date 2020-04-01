class Functions {
	// Plays fade animatin on first visit
	static fadeTable() {
		if (localStorage.getItem('fadeTable') !== 'true') {
			let delay = 0;
			$('.table-row').each(function() {
				setTimeout(() => {
					$(this).addClass('show');
				}, delay);
				delay += 50;
			});
			localStorage.setItem('fadeTable', 'true');
		} else {
			$('.table-row').addClass('show');
		}
	}

	// Navbar slide animation when hovering on items
	static navSlide() {
		$('.nav-link').not('#login-button, #register-button').mouseenter(function() {
			// Spawn nav ruler if it doesn't exist
			if (!$('.nav-ruler').length) $(this).parent().append('<div class="nav-ruler"></div>');

			// Remove any colored nav link and color the latest hovered one
			$('.nav-link.color-white').removeClass('color-white');
			$(this).addClass('color-white');

			// Get index of currently hovered item and the index of the item with the ruler
			let index = $(this).parent().index();
			let rulerIndex = $('.nav-ruler').parents('.nav-item').index();

			// The magic
			let distance = 0;		
			if (rulerIndex - index < 0) {
				for (let i = index; i > rulerIndex; i--) {
					distance += $(`.nav-item:nth-child(${i})`).outerWidth(true);
				}
				$('.nav-ruler').css('transform', `translateX(-${distance}px)`);
			} else {
				for (let i = index; i < rulerIndex; i++) {
					if (index === 0) {
						distance += $(`.nav-item:first-child`).outerWidth(true);
					} else {
						distance += $(`.nav-item:nth-child(${i})`).outerWidth(true);
					}
				}
				$('.nav-ruler').css('transform', `translateX(${distance}px)`);
			}

			// Remove ruler when leaving navbar
			$(this).parents('.nav-items').mouseleave(function() {
				$('.nav-link.color-white').removeClass('color-white');
				$('.nav-ruler').remove();
			});
		});
	}
	static showTitle() {
		// Setup tooltip positions etc
		$('[data-title]').each(function() {
			$(this).showTitle();
		});
	}
}

// Important that this happens after class declaration
export default Functions;