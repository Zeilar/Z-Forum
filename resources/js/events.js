$(document).ready(() => {
	// Dashboard settings menu size animation
	$('.settings-item').mouseenter(function() {
		$(this).addClass('active-hover');
	
		$(this).mouseleave(function() {
			$(this).removeClass('active-hover');
		});
	});
	
	// Open modal if a session error/success message is found
	if ($('#errorModal')) {
		$('#errorModal').modal('show');
	} else if ($('#successModal')) {
		$('#successModal').modal('show');
	}
	
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
				<p class="color-red" id="passwords-no-match">{{ __('Passwords don't match') }}</p>
			`);
		} else {
			$(this).removeClass('is-invalid');
			$('#passwords-no-match').remove();
		}
	});
	
	// Open auth modal if an error was found in either of them (after using has been redirected back)
	if ($('#registerModal .is-invalid').length) {
		$('#registerModal').modal('show');
	} else if ($('#loginModal .is-invalid').length) {
		$('#loginModal').modal('show');
	}
	
	// Put spinning wheel on submits buttons when pressed
	if ($('button[type=submit]')) {
		$('button[type=submit]').click(function() {
			if (!$(this).hasClass('loading')) {
				$(this).addClass('loading').html('<i class="fas fa-circle-notch"></i>');
			}
		});
	}
});