$(document).ready(() => {
	// Dashboard settings menu size animation
	$('.settings-item').mouseenter(function() {
		$(this).addClass('active-hover');
	
		$(this).mouseleave(function() {
			$(this).removeClass('active-hover');
		});
	});
	
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
				$(this).parent().siblings('label').append(`
					<p class="color-red" id="passwords-no-match">Passwords don't match</p>
				`);
			}
		} else {
			$(this).removeClass('is-invalid');
			$('#passwords-no-match').remove();
		}
	});

	$('.modal-auth input').change(function() {
		let modal = $(this).closest('form');
		let emptyFields = modal.find('input').not('[name=_token]').length;
		modal.find('input').not('[name=_token]').each(function() {
			if ($(this).val() !== '') emptyFields -= 1;
		});
		if (emptyFields === 0) modal.find('[disabled]').removeAttr('disabled');
	});
	
	// Open modals depending on which error element has been spawned
	if ($('#registerModal .is-invalid').length) {
		$('#registerModal').modal('show');
		$('.modal').on('shown.bs.modal', function() {
			$('#registerModal .is-invalid').first().focus();
		});
	} else if ($('#loginModal .is-invalid').length) {
		$('#loginModal').modal('show');
		$('.modal').on('shown.bs.modal', function() {
			$('#loginModal .is-invalid').first().focus();
		});
	} else if ($('#errorModal #error-any').length) {
		$('#errorModal').modal('show');
	} else {
		$('.modal').on('shown.bs.modal', function() {
			$(this).find('[autofocus]').focus();
		});
	}
	
	// Put spinning wheel on submits buttons when pressed
	if ($('.spin')) {
		$('.spin').click(function() {
			if (!$(this).hasClass('loading')) {
				$(this)
					.css('width', `${$(this).outerWidth()}px`) // Do this first to preserve original button width
					.addClass('loading')
					.html('<i class="fas fa-circle-notch"></i>');
			}
		});
	}

	// Spawn scroll to top button
	$(document).on('scroll', function() {
		if ($(window).scrollTop() > $(window).height()) {
			if (!$('#scroller').hasClass('show')) {
				$('#scroller').addClass('show');
			}
		} else {
			if ($('#scroller').hasClass('show')) {
				$('#scroller').removeClass('show');
			}
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

	$('.navbar-toggle').click(function() {
		
	});
});