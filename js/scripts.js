jQuery(function($) {

    "use strict";

    var $window = $(window);

    /********************************************************************************

    * LAZY LOAD

    ********************************************************************************/
    if ("loading" in HTMLImageElement.prototype) {
        var images = document.querySelectorAll('img[loading="lazy"]');
        var sources = document.querySelectorAll("source[data-srcset]");
        sources.forEach(function (source) {
            source.srcset = source.dataset.srcset;
        });
        images.forEach(function (img) {
            img.src = img.dataset.src;
        });
    } else {
        //if no support, async load the lazysizes plugin
        let script = document.createElement("script");
        script.async = true;
        script.src = "https://cdnjs.cloudflare.com/ajax/libs/lazysizes/4.1.8/lazysizes.min.js";
        document.body.appendChild(script);
    }



    /********************************************************************************

    * IMG ANIMATION

    ********************************************************************************/
    var animateImages = function() {
        $('.fade-image:not(.loaded-img-wrapper):not(.progress-animation)').each(function(){
            var el = this;
            if($(el).offset().top < $window.scrollTop() + ($window.height() / 10)*8 ) {
                $(el).addClass('loaded-img-wrapper');
            }
        });
    };

    function bindImageAnimations() {
        requestAnimationFrame(animateImages);
        $window.on('scroll', function(){
            requestAnimationFrame(animateImages);
        });
    } 



    /********************************************************************************

    * TEXT ANIMATION

    ********************************************************************************/
    var animateText = function() {
        $('.fade-animation:not(.loaded-animation):not(.progress-animation)').each(function(){
            var el = this;
            if($(el).offset().top < $window.scrollTop() + ($window.height() / 10)*8 ) {
                $(el).addClass('loaded-animation');
            }
        });
    };

    function bindTextAnimations() {
        requestAnimationFrame(animateText);
        $window.on('scroll', function(){
            requestAnimationFrame(animateText);
        });
    }



    /********************************************************************************

    * MOSAIC ANIMATION

    ********************************************************************************/
    function arrayShuffle(a) {
        var j, x, i;
        for (i = a.length; i; i--) {
            j = Math.floor(Math.random() * i);
            x = a[i - 1];
            a[i - 1] = a[j];
            a[j] = x;
        }
    }

    function animateMosaic() {
        if($('.mosaic-item').length > 0) {
            var items = [];
            $('.mosaic-item').each(function(){
                items.push($(this));
            });

            arrayShuffle(items);
            $(items).each(function(i, el){
                setTimeout(function(){
                    $(el).addClass('mosaic-loaded');
                }, 100*i);
            });
        }
    }



   /********************************************************************************

    * ONLOAD ANIMATION

    ********************************************************************************/
    $window.on('load', function(){
        setTimeout(function(){  
            $('body').addClass('content-loaded');
            $(this).remove();
            animateMosaic();
            bindImageAnimations();
            bindTextAnimations();        
            $('.page-intro').addClass('intro-loaded');
        },300);
    });



    /********************************************************************************

    * MOBILE SIDE MENU

    ********************************************************************************/
    if($('.pxr-header-top-line__btn, .pxr-sticky-top-line__btn').length){

        $('.pxr-header-top-line__btn, .pxr-sticky-top-line__btn').on('click', function(){
            if($('.pxr-side-mobile').is(':visible')){
            }
            $('.pxr-side-mobile').addClass('pxr-side-menu-open');
            $('.pxr-sticky-top-line').removeClass('active');
        })

        $('.pxr-side-mobile__close').on('click', function(){
            $('.pxr-side-mobile').removeClass('pxr-side-menu-open');
        })      
    }  


    $(document).mouseup(function(e) {
        var sidemenu = $('.pxr-side-mobile');

        if (!sidemenu.is(e.target) && sidemenu.has(e.target).length === 0) {

            sidemenu.removeClass('pxr-side-menu-open');

        }
    });



    /********************************************************************************

    * STICKY NAVIGATION

    ********************************************************************************/
    $window.on('scroll', function() {

        if($(document).scrollTop() > 40) {
            $('.pxr-sticky-top-line').addClass('active');
            $('.pxr-side-mobile').removeClass('pxr-side-menu-open');
        } else {
            $('.pxr-sticky-top-line').removeClass('active');   
            $('.pxr-side-mobile').removeClass('pxr-side-menu-open');
        }
    });



} (jQuery));
