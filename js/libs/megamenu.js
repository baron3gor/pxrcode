jQuery(function($) {

    "use strict";

    var $window = $(window);


    /********************************************************************************

    * DROP DOWN MENU

    ********************************************************************************/

    if( ! $.fn.pxr_drop_down ){

        $.fn.pxr_drop_down = function()
        {

            var $this = $(this);

            $this.each(function(){

                var menu_items_with_sub = $(this).find(".menu-item-has-children"),
                    max_depth = 0;

                menu_items_with_sub.each(function(){
                    max_depth = Math.max( max_depth, $(this).data("depth") );
                });

                if( ! is_rtl ){

                    var right_space = window_width - $(this).offset().left,
                    left_space = $(this).offset().left,
                    menu_total_width = left_space + ( ( max_depth + 1 ) * 240 );

                     if( right_space < left_space && window_width < menu_total_width ){
                        $(this).addClass("o-direction");
                     }

                }else{

                    var right_space = window_width - $(this).offset().left,
                    left_space = $(this).offset().left,
                    menu_total_width = right_space + ( ( max_depth + 1 ) * 240 );

                    if( left_space < right_space && window_width < menu_total_width ){
                        $(this).addClass("o-direction");
                    }
                }

                $(this).addClass("submenu-loaded");                 
            });

        };
    }

    $window.load(function(){
        $(".pxr-navigation-list > li:not(.multicolumn).menu-item-has-children").pxr_drop_down();
    })


   
    /* *******************************************************************************

    MEGA MENU

    ********************************************************************************** */

    var is_rtl = $("body").hasClass("rtl");
    var window_width = $(window).width();
    var window_height = $(window).height();

    $('.pxr-navigation-list .multicolumn > ul > li.menu-item-has-children > a').each(function(){

        if( $(this).attr("href") == "#" || $(this).attr("href") == "" ){
            var $this = $(this);
            $('<span>'+$(this).html()+'</span>').insertAfter($this);
            $this.remove();
        }

    });


    if( ! $.fn.pxr_mega_menu ){

        $.fn.pxr_mega_menu = function(action)
        {

            if( $(this).length === 0 ){
                return;
            }

            var $this = $(this),
                header = $(".pxr-megamenu-container"),
                header = $(".pxr-megamenu-container").length > 0 ? header : $(".pxr-nav-wrapper").parents(".elementor-row:eq(0)"),
                header_width = header[0].getBoundingClientRect().width - 40,
                new_col = "",
                ew_line;

            $this.each(function(){

                var $this = $(this),
                      menu = $this.find("> ul"),
                      col_size = $this.data("col-size");
                      
                if(header.hasClass('pxr-sidear-template-container')) {
                    var menu_width = Math.min( col_size * 310 );
                } else {
                    var menu_width = Math.min( col_size * 310, header_width );
                }

                if( ! menu.hasClass("multicolumn-holder") ){
                    $("<ul class='sub-menu multicolumn-holder' />").appendTo($(this));

                    var  group;
                    var lists_length = Math.ceil( menu.find('> li').length / col_size );

                    while( ( group = menu.find('> li:lt('+ lists_length  +')').remove() ).length){
                        $('<li/>').append($("<ul class='sub-menu'/>").append(group)).appendTo($(this).find("> .multicolumn-holder"));
                    }
                    menu.remove();
                    menu = $this.find("> ul");//menu updated
                }

                $(this).addClass("submenu-loaded");
                
                if( ! is_rtl ){

                    var leftPos  = $this.offset().left,
                         leftMargin = Math.ceil( header_width + header.offset().left ) - ( leftPos + menu_width) + 20;

                    //set width
                    menu.css({
                        "width" : menu_width
                    });

                    if( leftMargin > 0 ){
                        return;
                    }

                    if(header.hasClass('pxr-sidear-template-container')) {
                        menu.css({
                            "margin-left" : 0
                        });
                    } else {
                        menu.css({
                            "margin-left" : parseFloat(leftMargin)
                        });
                    }

                }else{
                    var item_width = $this.outerWidth(),
                        leftPos  = $this.offset().left + item_width,
                        leftMargin  = Math.min(0, - 1 * (  header.offset().left - (leftPos - menu_width)) - 20 );

                    //set width
                    menu.css({
                        "width" : menu_width
                    });

                    if( leftMargin == 0 ){
                        return;
                    }

                    menu.css({
                        "margin-right" : leftMargin
                    });
                } 
            });
        };
    }

    var pxr_mega_menu = $(".pxr-navigation-list > li.multicolumn.menu-item-has-children");

    $window.load(function(){
        pxr_mega_menu.pxr_mega_menu();
    });

});


