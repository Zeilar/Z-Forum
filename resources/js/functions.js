class Functions {
	// Plays fade animatin on first visit
	static fadeTable() {
		let rows = $('.table-row');
		if (localStorage.getItem('fadeTable') !== 'true') {
			let delay = 0;
			rows.each(function() {
				setTimeout(() => {
					$(this).addClass('show');
				}, delay);
				delay += 50;
			});
			localStorage.setItem('fadeTable', 'true');
		} else {
			rows.addClass('show');
		}
	}

	// Navbar slide animation when hovering on items
	static navSlide() {
		$('.nav-link').not('#login-button, #register-button').mouseenter(function() {
			let linkActive = $('.nav-link.slide-active');
			let link = $(this);

			// Spawn nav ruler if it doesn't exist
			if (!$('.nav-ruler').length) link.parent().append('<div class="nav-ruler"></div>');

			// Remove any colored nav link and color the latest hovered one
			linkActive.removeClass('slide-active');
			link.addClass('slide-active');

			// Get index of currently hovered item and the index of the item with the ruler
			let index = link.parent().index();
			let ruler = $('.nav-ruler');
			let rulerIndex = ruler.parents('.nav-item').index();

			// The magic
			let distance = 0;		
			if (rulerIndex - index < 0) {
				for (let i = index; i > rulerIndex; i--) {
					distance += $(`.nav-item:nth-child(${i})`).outerWidth(true);
				}
				ruler.css('transform', `translateX(-${distance}px)`);
			} else {
				for (let i = index; i < rulerIndex; i++) {
					if (index === 0) {
						distance += $(`.nav-item:first-child`).outerWidth(true);
					} else {
						distance += $(`.nav-item:nth-child(${i})`).outerWidth(true);
					}
				}
				ruler.css('transform', `translateX(${distance}px)`);
			}

			// Remove ruler when leaving navbar
			link.parents('.nav-items').mouseleave(function() {
				linkActive.removeClass('slide-active');
				ruler.remove();
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
			let link = $(this);
			link.mouseup(function(e) {
				if (e.which === 1) link.parents('.table-title').siblings('.fa-folder').removeClass('fa-folder').addClass('fa-folder-open');
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
			let rows = $(this).find('.subcategory-rows');
			if (localStorage.getItem(`hidden-${$(this).attr('id')}`)) {
				$(this).find('.category-collapse i').addClass('closed');
				rows.addClass('hidden');
			} else {
				let height = 4;
				rows.children('.table-row').each(function() {
					height += $(this).outerHeight() + 4;
				});

				$(this).find('.category-collapse i').removeClass('closed');
				rows.removeClass('hidden').css('height', `${height}px`);
			}
		});

		$('.category-collapse').click(function() {
			let id = $(this).parents('.table-group').attr('id');
			let button = $(this).children();
			if (localStorage.getItem(`hidden-${id}`)) {
				localStorage.removeItem(`hidden-${id}`);
			} else {
				localStorage.setItem(`hidden-${id}`, true);
			}

			let rows = $(this).parents('.table-group').find('.subcategory-rows');
			if (rows.hasClass('hidden')) {
				let height = 0;
				rows.children('.table-row').each(function() {
					height += $(this).outerHeight();
					height += 4;
				});

				height += 4;

				rows.removeClass('hidden').css('height', `${height}px`);
				button.removeClass('closed');
			} else {
				rows.addClass('hidden').removeAttr('style');
				button.addClass('closed');
			}
		});
	}

	// Creates preview of uploaded image
	static inputPreviewImage() {
		$('input[type=file]').change(function(e) {
			$('.file-upload-preview').remove();

			const file = this.files[0];
			const fileType = file['type'];
			const validImageTypes = ['image/gif', 'image/jpeg', 'image/png', 'image/svg+xml', 'image/bmpg', 'image/webp'];

			if (validImageTypes.includes(fileType)) {
				let src = URL.createObjectURL(e.target.files[0]);
				$(this).prev().before(`<img class="file-upload-preview" src="${src}" />`);
			}
		});
	}
}

// Important that this happens after class declaration
export default Functions;