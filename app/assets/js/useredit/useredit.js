window.userEditCallback = (htmx, elt, event) => {
	try {
		const data = JSON.parse(event.detail.xhr.responseText)

		$('#password-error').addClass('hidden')
		$('#new-password-error').addClass('hidden')
		$('#new-password-conf-error').addClass('hidden')

		switch (data.fail) {
			case 'password1':
				$('#password-error').removeClass('hidden')
				break
			case 'new-password':
				$('#new-password-error').removeClass('hidden')
				break
			case 'new-password-conf':
				$('#new-password-conf-error').removeClass('hidden')
				break
			default:
				break
		}

		if (data.success) {
			$('#current-password').val('')
			$('#new-password').val('')
			$('#new-password-conf').val('')

			$('[data-hs-overlay]').click()
		}
	} catch (e) {}
}
