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
} else if (type == 3){
  $('.btc-deposit').addClass(animationName).one(animationend, function() {
    $(this).removeClass(animationName);
  })
  $(function() {
    setInterval(function() {
      animationName = 'animated bounce'
      $('.btc-deposit').addClass(animationName).one(animationend, function() {
        $(this).removeClass(animationName);
      });
    }, 1000);
  });
} else if (type == 4){
  $('.btc-withdraw').addClass(animationName).one(animationend, function() {
    $(this).removeClass(animationName);
  })
  $(function() {
    setInterval(function() {
      animationName = 'animated bounce'
      $('.btc-withdraw').addClass(animationName).one(animationend, function() {
        $(this).removeClass(animationName);
      });
    }, 1000);
  });
} else if (type == 5){
  $('.clp-deposit').addClass(animationName).one(animationend, function() {
    $(this).removeClass(animationName);
  })
  $(function() {
    setInterval(function() {
      animationName = 'animated bounce'
      $('.clp-deposit').addClass(animationName).one(animationend, function() {
        $(this).removeClass(animationName);
      });
    }, 1000);
  });
} else if (type == 6){
  $('.clp-withdraw').addClass(animationName).one(animationend, function() {
    $(this).removeClass(animationName);
  })
  $(function() {
    setInterval(function() {
      animationName = 'animated bounce'
      $('.clp-withdraw').addClass(animationName).one(animationend, function() {
        $(this).removeClass(animationName);
      });
    }, 1000);
  });
} else if (type == 7){
  $('.total-sell-clp').addClass(animationName).one(animationend, function() {
    $(this).removeClass(animationName);
  })
  $(function() {
    setInterval(function() {
      animationName = 'animated bounce'
      $('.total-sell-clp').addClass(animationName).one(animationend, function() {
        $(this).removeClass(animationName);
      });
    }, 1000);
  });
}
