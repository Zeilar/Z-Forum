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
})