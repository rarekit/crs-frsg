;(function($, window, undefined) {
  var panelHeading = $('.panel-heading');
  
  panelHeading.on('click', function(){
    $(this).addClass('active');
  });
  $('body').click(function(e) {
    var target = $(e.target);
    if(!target.closest('.panel-heading.active').length){
      $('.panel-heading').removeClass('active');
      $('.panel-heading input').each(function() {
        var element = $(this);
        if (element.val() !== "") {
          $(element).css({'display':'inline-block'});
        }
      });
    }
  });
  // return {
  //   publicVar: 1,
  //   publicObj: {
  //     var1: 1,
  //     var2: 2
  //   },
  //   publicMethod1: privateMethod1
  // };


})(jQuery, window);

// jQuery(function (){
//   var panelHeading = $('.panel-heading');

//   panelHeading.on('click', function(){
//     alert(1);
//   });

// });
