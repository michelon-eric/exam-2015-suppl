$('#toggle-sidebar').click(function () {
	setTimeout(() => {
		$('#sidebar-backdrop').unbind('click')
		$('#sidebar-backdrop').on('click', function () {
			$('#sidebar').toggleClass('hidden')
			$('#sidebar-backdrop').remove()
		})
	}, 10)
})
