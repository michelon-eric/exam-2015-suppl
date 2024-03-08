console.log('fuck-2')
$('#button-login').unbind('click')
$('#button-login').click(async function () {
	const email = $('#email').val()
	const password = $('#password').val()
	const rember = $('#remember-me').prop('checked')

	const formData = new FormData()
	formData.append('email', email)
	formData.append('password', password)
	formData.append('remember-me', rember)

	const response = await fetch('http://localhost:80/auth/login', {
		method: 'POST',
		body: formData,
	})

	// return console.log(await response.text())
	const data = await response.json()

	if (data.fail === 'email') {
		$('#email-error').removeClass('hidden')
	} else {
		$('#email-error').addClass('hidden')
	}

	if (data.fail === 'password') {
		$('#password-error').removeClass('hidden')
	} else {
		$('#password-error').addClass('hidden')
	}

	if (data.success !== undefined) {
		window.location.href = data.success
	}
})
