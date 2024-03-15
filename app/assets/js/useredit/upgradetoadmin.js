window.upgradeToAdminCallback = (htmx, elt, event) => {
	console.log(event.detail.xhr.responseText)
	try {
		const data = JSON.parse(event.detail.xhr.responseText)

		$('#centre-name-error').addClass('hidden')
		$('#centre-city-error').addClass('hidden')
		$('#centre-address-error').addClass('hidden')
		$('#centre-phone-error').addClass('hidden')
		$('#centre-zip-error').addClass('hidden')

		$(`#centre-${data.fail}-error`).removeClass('hidden')
	} catch (error) {}
}
