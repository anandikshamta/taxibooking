function autocollapse() {
  var navbar = $('.navbar-autocollapse');
  navbar.removeClass('collapsed');
  if(navbar.innerHeight() > 113)
    navbar.addClass('collapsed');
}
jQuery(document).on('ready', autocollapse);
jQuery(window).on('resize', autocollapse);