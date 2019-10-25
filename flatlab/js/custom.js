/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(function($) {
    $.fn.hasScrollBar = function() {
        return this.get(0).scrollHeight > this.height();
    }
})(jQuery);

$(function(){
    $('.icon-reorder').click(function () {
        if ($('#sidebar > ul').is(":visible") === true) {
//            console.log($("#container").width()-210);
            $("#main-content .container").css("width",($(window).width()-240)+"px");
            $("#main-content .container").css("margin-left","210px");
//            console.log('buka'+$("#main-content .container").width());
        } else {
//            $("#main-content .container").css("width",($("#main-content .container").width()+210)+"px");
            $("#main-content .container").css("width",($(window).width()-30)+"px");
            $("#main-content .container").css("margin-left","0px");
//            console.log('tutup'+$("#main-content .container").width());
        }
    }); 
            $("#main-content .container").css("width",($(window).width()-240)+"px");
    
});

$(window).on('resize', function(){
    if ($('#sidebar > ul').is(":visible") === true) {
            $("#main-content .container").css("width",($(window).width()-240)+"px");
    } else {
            $("#main-content .container").css("width",($(window).width()-30)+"px");
    }
});