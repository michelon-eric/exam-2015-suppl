window.loginCallback = (htmx, elt, event) => {
	try {
		const data = JSON.parse(event.detail.xhr.responseText)

		$('#email-error').addClass('hidden')
		$('#password-error').addClass('hidden')

		if (data.fail === 'email') {
			$('#email-error').removeClass('hidden')
		}

		if (data.fail === 'password') {
			$('#password-error').removeClass('hidden')
		}

		if (data.success !== undefined) {
			window.location.href = data.success
		}
	} catch {}
}
