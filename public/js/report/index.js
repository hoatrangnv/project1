if(type == 1){
  $('.new-user').addClass(animationName).one(animationend, function() {
    $(this).removeClass(animationName);
  })
  $(function() {
    setInterval(function() {
      animationName = 'animated bounce'
      $('.new-user').addClass(animationName).one(animationend, function() {
        $(this).removeClass(animationName);
      });
    }, 1000);
  });
} else if (type == 2){
  $('.total-package').addClass(animationName).one(animationend, function() {
    $(this).removeClass(animationName);
  })
  $(function() {
    setInterval(function() {
      animationName = 'animated bounce'
      $('.total-package').addClass(animationName).one(animationend, function() {
        $(this).removeClass(animationName);
      });
    }, 1000);
  });
}
