// Need to import like this instead of the whole file due to webpack wrapping files in their own scopes
import Functions from './functions';

/**
 * Register the event handler
 */

/*
-----------------------------------------------
No event handler, always runs
-----------------------------------------------
*/
Functions.fadeTable();
Functions.showTitle();

/*
-----------------------------------------------
Hover
-----------------------------------------------
*/
Functions.navSlide();

/*
-----------------------------------------------
Click
-----------------------------------------------
*/
Functions.searchAnimate();
Functions.replyButton();
Functions.openFolder();

// Password revealer button
$('.password-revealer').click(function() {
	if ($(this).siblings('input').attr('type') === 'password') {
		$(this).siblings('input').attr('type', 'text');
		$(this).children('i').attr('class', 'far fa-eye-slash');
	} else {
		$(this).siblings('input').attr('type', 'password');
		$(this).children('i').attr('class', 'far fa-eye');
	}
});

// Error visuals when password_repeat doesn't match password
$('#register_password_repeat').on('change', function() {
	if ($(this).val() !== $('#register_password').val()) {
		$(this).addClass('is-invalid');
		if (!$('#passwords-no-match').length) {
			$(this).parent().siblings('label').append('<p class="color-red" id="passwords-no-match">Passwords don\'t match</p>');
		}
	} else {
		$(this).removeClass('is-invalid');
		$('#passwords-no-match').remove();
	}
});

// Turn disabled off on modal submit button if all inputs are filled, otherwise turn it on
$('.modal input').on('input', function() {
	let modal = $(this).closest('form');
	let emptyFields = modal.find('input').not('[name=_token]').length;
	modal.find('input').not('[name=_token]').each(function() {
		if ($(this).val() !== '') emptyFields -= 1;
	});
	if (emptyFields === 0) {
		modal.find('[disabled]').removeAttr('disabled');
	} else {
		modal.find('[type=submit]').attr('disabled', true);
	}
});

$('.modal').on('shown.bs.modal', function() {
	if ($('.modal .is-invalid').length) {
		$(this).find('.is-invalid').first().focus();
	} else {
		$(this).find('[autofocus]').focus();
	}
});
if ($('.modal .is-invalid').length) {
	$('.modal .is-invalid').parents('.modal').modal('show');
}

// Put spinning wheel on submits buttons when pressed
if ($('.spin').length) {
	$('.spin').click(function() {
		if (!$(this).hasClass('loading')) {
			$(this).css('width', `${$(this).outerWidth()}px`).addClass('loading').html('<i class="fas fa-circle-notch"></i>');
			setTimeout(() => {
				$(this).attr('disabled', true);
			}, 50);
		}
	});
}

// Spawn scroll to top button
$(document).on('scroll', function() {
	if ($(window).scrollTop() > $(window).height()) {
		if (!$('#scroller').hasClass('show')) $('#scroller').addClass('show');
	} else {
		if ($('#scroller').hasClass('show')) $('#scroller').removeClass('show');
	}
});

// Scroll to top
$('#scroller').click(function() {
	window.scrollTo(0, 0);
});

// File upload button animation
$('.file-upload').mouseenter(function() {
	$(this).children('i').attr('style', `transform: translateX(${$(this).width() / 2 - $(this).children('i').width() / 2}px);`);
	$(this).addClass('slide');

	$(this).mouseleave(function() {
		$(this).children('i').removeAttr('style');
		$(this).removeClass('slide');
	});
});

// Copy link instead of opening it, and spawn a small bubble notification
$('.permalink').click(function(e) {
	e.preventDefault();

	// Remove all other currently displayed notifications before we start
	$('.copy-notification').each(function() {
		$(this).remove();
	});

	// Need some sort of text to copy
	$(this).append(`<textarea id="copy">${$(this).attr('href')}</textarea>`).attr('id', 'tooltip');

	// Copy the text and remove the dummy element
	$('#copy').select();
	document.execCommand('copy');
	$('#copy').remove();

	// Create the tooltip, and save its parent so we know which to remove automatically afterwards, in case user spawns multiple
	let tooltip = $(this).parent().append('<div class="copy-notification"><span>Copied!</span></div>');

	// Remove the targeted tooltip
	setTimeout(() => {
		tooltip.find('.copy-notification').remove();
	}, 2000);
});

// Spawn pagination input box
$('.pagination .dots').click(function() {
	// Toggle input box when clicking on the triple dots, if the box already exists
	if ($('.pagination-go').length) {
		if ($('.pagination-go').hasClass('hide')) {
			$('.pagination-go').removeClass('hide');
		} else {
			$('.pagination-go').addClass('hide');
			setTimeout(() => {
				$('.pagination-go').remove();
			}, 250);
		}
	} else {
		// Add the input box if it doesn't exist
		let page = $('.pagination').attr('data-current-page');
		$(this).parent().append(`
			<div class="pagination-go" id="pagination-go">
				<i class="fas fa-minus" id="pagination-minus"></i>
					<input min="1" autocomplete="off" type="number" id="pagination-input" value="${page}" />
				<i class="fas fa-plus" id="pagination-plus"></i>
				<a class="btn" id="pagination-submit">
					Go
				</a>
			</div>
		`);

		// Since we have no form, we "submit" manually if the input is up and Enter is pressed
		$(document).on('keydown', function(e) {
			if (e.key === 'Escape') {
				$('.pagination-go').addClass('hide');
				setTimeout(() => {
					$('.pagination-go').remove();
				}, 250);
			}
		});

		// Pagination input incrementers
		let interval = null;
		$('#pagination-minus').mousedown(function() {
			interval = setInterval(() => {
				if (Number($('#pagination-input').val()) > 1) {
					$('#pagination-input').val($('#pagination-input').val() - 1);
				} 
			}, 200);
		})
		.click(function() {
			if (Number($('#pagination-input').val()) > 1) {
				$('#pagination-input').val($('#pagination-input').val() - 1);
			}
		})
		.mouseup(function() {
			clearInterval(interval);
		});

		$('#pagination-plus').mousedown(function() {
			interval = setInterval(() => {
				if ($('#pagination-input').val() < Number($('.pagination .item-wrapper').last().prev().children('.item').html())) {
					$('#pagination-input').val(Number($('#pagination-input').val()) + 1);
				}
			}, 200);
		})
		.click(function() {
			if ($('#pagination-input').val() < Number($('.pagination .item-wrapper').last().prev().children('.item').html())) {
				$('#pagination-input').val(Number($('#pagination-input').val()) + 1);
			}
		})
		.mouseup(function() {
			clearInterval(interval);
		});

		// Autofocus when the input box spawns
		$('#pagination-input').focus();

		// Handle the submitted page dynamically and redirect to that page
		$('.pagination-go a').click(function() {
			window.location.href = `?page=${$('.pagination-go input').val()}`;
		});
	}

	// Select the text for better UX
	document.getElementById('pagination-input').select();
});

// Hide pagination input box when clicking outside of it or the triple dots
$(window).click(function(e) {
	if (
		// Only hide it if user does not click on these elements, and if .pagination-go is not already hidden
		($(e.target).attr('id') !== 'pagination-submit') && 
		($(e.target).attr('id') !== 'pagination-input') && 
		($(e.target).attr('id') !== 'pagination-minus') && 
		($(e.target).attr('id') !== 'pagination-plus') && 
		($(e.target).attr('id') !== 'pagination-dots') && 
		($(e.target).attr('id') !== 'pagination-go') && 
		!$('.pagination-go').hasClass('hide')
	) {
		$('.pagination-go').addClass('hide');
		setTimeout(() => {
			$('.pagination-go').remove();
		}, 250);
	}
});

// Automatically scroll to element if URL contains pound
if (window.location.href.includes('#')) {
	let id = window.location.href.split('#', 2)[1];
	let target = $(`#${id}`);

	// If target element exists, scroll to it, and subtract by the navbar height plus some margin since the navbar is sticky
	if (target.length) {
		setTimeout(() => {
			window.scrollTo(0, target.position().top - $('.navbar').outerHeight(true) - 15);
		}, 500);
		target.addClass('active');
	}
}