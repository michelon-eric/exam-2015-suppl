window.registerCallback = (htmx, elt, event) => {
	try {
		const data = JSON.parse(event.detail.xhr.responseText)

		$('#email-error').addClass('hidden')
		$('#email-error-2').addClass('hidden')
		$('#password-error').addClass('hidden')
		$('#confirm-password-error').addClass('hidden')

		if (data.fail === 'email') {
			$('#email-error').removeClass('hidden')
		}

		if (data.fail === 'email-2') {
			$('#email-error-2').removeClass('hidden')
		}

		if (data.fail === 'password-length') {
			$('#password-error').removeClass('hidden')
		}

		if (data.fail === 'password-match') {
			$('#confirm-password-error').removeClass('hidden')
		}

		if (data.success !== undefined) {
			window.location.href = data.success
		}
	} catch {}
}
