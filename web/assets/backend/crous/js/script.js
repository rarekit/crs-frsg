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

(function (window, App) {

  "use strict";

  App = {};
  App.settings = {};
  App.settings.locales = {};

  window.App = App;

}(window));

/* =========
 * custom-select.js
 * ========= */

(function($, App) {

  "use strict";

  /* ============== */
  /* MODULE TRIGGER */
  /* ============== */

  var selectTrigger = '.custom-select';

  /* =============== */
  /* MODULE DEFAULTS */
  /* =============== */

  var defaults = {
    classActive: 'active'
  };

  /* ================= */
  /* MODULE DEFINITION */
  /* ================= */

  function CustomSelect(opts) {
    this.settings = $.extend({}, defaults, opts);
    return this.init();
  }

  /* ============== */
  /* MODULE METHODS */
  /* ============== */

  CustomSelect.prototype.init = function() {
    var that = this;

    $('select', selectTrigger).each(function() {
      that.getSelectVal(this);
    })
    .on('change.customSelect', function() {
      that.getSelectVal(this);
    });
  };

  CustomSelect.prototype.getSelectVal = function(el) {
    var wrapper = $(el).closest(selectTrigger);

    $('span', wrapper).html($('option:selected', el).text());
    if (el.value.length) {
      wrapper.addClass(this.settings.classActive);
    }
    else {
      wrapper.removeClass(this.settings.classActive);
    }
  };

  /* =============== */
  /* MODULE DATA-API */
  /* =============== */

  $(function() {
    App.customSelect = new CustomSelect();
  });
  
  $("input[type=file]").on('change',function(){
      $(this).closest('div').find('.file-name').html(this.files[0].name);
   });
  

}(window.jQuery, window.App));

