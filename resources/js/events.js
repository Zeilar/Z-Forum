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
			console.log($(this).parent());
			$(this).parent().siblings('label').append(`
				<p class="color-red" id="passwords-no-match">Passwords don't match</p>
			`);
		} else {
			$(this).removeClass('is-invalid');
			$('#passwords-no-match').remove();
		}
	});
	
	// Open modals depending on which error element has been spawned
	if ($('#registerModal .is-invalid').length) {
		$('#registerModal').modal('show');
	} else if ($('#loginModal .is-invalid').length) {
		$('#loginModal').modal('show');
	} else if ($('#errorModal #error-any').length) {
		$('#errorModal').modal('show');
	}


	// Bootstrap modal autofocus
	$('.modal').on('shown.bs.modal', function() {
		$(this).find('[autofocus]').focus();
	  });
	
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
});