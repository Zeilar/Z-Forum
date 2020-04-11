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
			$('.nav-link.active').removeClass('active');
			$(this).addClass('active');

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
				$('.nav-link.active').removeClass('active');
				$('.nav-ruler').remove();
			});
		});
	}

	// Setup tooltip positions etc
	static showTitle() {
		$('[data-title]').each(function() {
			$(this).showTitle();
		});
	}

	// Animation that opens folder icons when clicking
	static openFolder() {
		$('.table-title a').mousedown(function() {
			$(this).mouseup(function() {
				$(this).parents('.table-title').siblings('.fa-folder').removeClass('fa-folder').addClass('fa-folder-open');
			});
		});
	}

	// Navbar search bar animation
	static searchAnimate() {
		$('.nav-search').click(function() {
			$(this).addClass('active');
		});

		$(document).click(function(e) {
			if (e.target !== $('#search')[0]) $('.nav-search').removeClass('active');
		});
	}

	// Collapse the categories
	static collapseCategory() {
		$('.table-group').each(function() {
			if (localStorage.getItem(`hidden-${$(this).attr('id')}`)) {
				$(this).find('.category-collapse i').addClass('fa-plus').removeClass('fa-minus');
				$(this).find('.subcategory-rows').addClass('hidden');
			} else {
				let rows = $(this).find('.subcategory-rows');

				let height = 0;
				rows.children('.table-row').each(function() {
					height += $(this).outerHeight();
					height += 4;
				});
				height += 4;

				$(this).find('.category-collapse i').addClass('fa-minus').removeClass('fa-plus');
				rows.removeClass('hidden').css('height', `${height}px`);
			}
		});

		$('.category-collapse').click(function() {
			if (localStorage.getItem(`hidden-${$(this).parents('.table-group').attr('id')}`)) {
				localStorage.removeItem(`hidden-${$(this).parents('.table-group').attr('id')}`);
			} else {
				localStorage.setItem(`hidden-${$(this).parents('.table-group').attr('id')}`, true);
			}

			let rows = $(this).parents('.table-group').find('.subcategory-rows');
			if (rows.hasClass('hidden')) {
				let height = 0;
				rows.children('.table-row').each(function() {
					height += $(this).outerHeight();
					height += 4;
				});

				height += 4;

				rows.css('height', `${height}px`);

				$(this).children().removeClass('fa-plus').addClass('fa-minus');
				rows.removeClass('hidden');
			} else {
				$(this).children().removeClass('fa-minus').addClass('fa-plus');
				rows.addClass('hidden').removeAttr('style');
			}
		});
	}
}

// Important that this happens after class declaration
export default Functions;