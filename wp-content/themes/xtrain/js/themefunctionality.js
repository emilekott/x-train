jQuery(document).ready(function(){

    //tuition menu
    $tuition = jQuery('#menu-item-50');
    $tuition.children('a').replaceWith('<span id="tuition-mnu-title"><img src="'+siteBaseUrl+'/wp-content/themes/xtrain/images/tuition-mnu.png" /></span>');

    //tuition sub-menus
    jQuery('#menu-tuition-menu > li').hover(function(){
        jQuery(this).addClass('menuhover');
        jQuery(this).children('a').addClass('topcurrent');
    },function(){
        jQuery(this).removeClass('menuhover');
        jQuery(this).children('a').removeClass('topcurrent');
    });


    //sort the dropdowns correctly
    jQuery('#menu-tuition-menu > li').each(function(index,element){
        var submnu = jQuery(element).children('.sub-menu');
        if(submnu.length>0){
            var liElements = submnu.children('li');
            var breakPoint = Math.ceil(liElements.length/2);
           liElements.css('float','none');
            var licount = 0;
            var toAppend = new Array();
            liElements.each(function(lii,lie){ licount++;
                if(licount>breakPoint){
                   toAppend[licount] = jQuery(lie).css('float','right').css('clear','right');
                } 
            });
            toAppend.reverse();
            for(var i in toAppend){
                toAppend[i].prependTo(submnu);
            }
        }
    });
    

    //Cufon.refresh();

});