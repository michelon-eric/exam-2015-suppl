window.editCentreData = (htmx, elt, event) => {
	try {
		const data = JSON.parse(event.detail.xhr.responseText)

		$('#centre-name-error').addClass('hidden')
		$('#centre-city-error').addClass('hidden')
		$('#centre-address-error').addClass('hidden')
		$('#centre-phone-error').addClass('hidden')
		$('#centre-email-error').addClass('hidden')
		$('#centre-zip-error').addClass('hidden')

		$(`#centre-${data.fail}-error`).removeClass('hidden')

		if (data.success !== undefined) {
			$('[data-hs-overlay]').click()
		}
	} catch (error) {}
}
