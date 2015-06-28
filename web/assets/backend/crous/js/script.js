;(function($, window, undefined) {
  var panelHeading = $('.panel-heading');
  
  panelHeading.on('click', function(){
    $(this).toggleClass('active');
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
