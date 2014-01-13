jQuery(document).ready(function() {
  jQuery("img.lazy").lazy();
  //$('a').smoothScroll();
  $('.menu-server').click(function() {
    var myData = $(this).attr('data-server');
    $('.server').css('display', 'none');
    $('#'+myData).css('display', 'block');
    $(window).trigger('scroll');
  });
  $('.menu-category').click(function() {
    var myData = $(this).attr('data-category');
    $('.category').css('display', 'none');
    $('#'+myData).css('display', 'block');
    $(window).trigger('scroll');
  });
});