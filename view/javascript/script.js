$('.menu-toggle').click(function() {
  $(this).toggleClass('active');
  $('nav ul').toggleClass('active');
  if ($('.logo').is(':hidden')) {
    $('.logo').css('display', 'block');
  } else {
    $('.logo').css('display', 'none');
  }
});

$(document).click(function(e) {
  var container = $('header');
  if (!container.is(e.target) && container.has(e.target).length === 0) {
    $('.logo').css('display', 'block');
    $('.menu-toggle').removeClass('active');
    $('nav ul').removeClass('active');
  }
});