$("a.dropdown-toggle").on("click", function () {
  if (!$(this).next().hasClass("show")) {
    $(this).parent().find(".dropdown-menu").removeClass("show");
  }

  const subMenu = $(this).next(".dropdown-menu");
  subMenu.toggleClass("show");
});

Waves.init();
