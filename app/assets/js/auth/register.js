console.log('fucking register')
$('#button-register').unbind('click')
$('#button-register').click(async function () {
	const email = $('#email').val()
	const password = $('#password').val()
	const passwordConfirm = $('#confirm-password').val()
	const firstName = $('#first-name').val()
	const lastName = $('#last-name').val()

	const formData = new FormData()
	formData.append('email', email)
	formData.append('password', password)
	formData.append('password-conf', passwordConfirm)
	formData.append('first-name', firstName)
	formData.append('last-name', lastName)

	const response = await fetch('http://localhost:80/auth/register', {
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

	if (data.fail === 'email-2') {
		$('#email-error-2').removeClass('hidden')
	} else {
		$('#email-error-2').addClass('hidden')
	}

	if (data.fail === 'password-length') {
		$('#password-error').removeClass('hidden')
	} else {
		$('#password-error').addClass('hidden')
	}

	if (data.fail === 'password-match') {
		$('#confirm-password-error').removeClass('hidden')
	} else {
		$('#confirm-password-error').addClass('hidden')
	}

	if (data.success !== undefined) {
		window.location.href = data.success
	}
})
