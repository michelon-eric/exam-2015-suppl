$('.uncollapse').each(function () {
	$(this).on('click', function () {
		$(this).find('#collapse-icon').toggleClass('rotate')
		// $(this).parent().find('div').toggleClass('show')
	})
})
