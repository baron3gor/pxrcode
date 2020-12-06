jQuery(function($){

    var $window = $(window);

    $.fn.pxr_gallery_tabs = function() {

        var $this         = $(this),
            $getContainer = $this.find('.content-wrapper-gallery'),
            getStyle      = $getContainer.data('btn'),
            getPage       = $getContainer.data('perpage'),
            getMaxPage    = $getContainer.data('maxpage'),
            getTab        = $this.find('.gallery-tab-item'),
            getCurrent    = $getContainer.find('.content-wrapper-img.current_gallery');
            loading       = false;

        $this.on('click', '.gallery-tab-item', function(){

            var getPostId     = $(this).data('id'),
                getBtn        = $this.find('.loadmore_gallery'),
                $getContainer = $this.find('.content-wrapper-gallery'),
                getTab        = $this.find('.gallery-tab-item'),
                getCurrent    = $getContainer.find('.content-wrapper-img.current_gallery');

            if(getCurrent.css('opacity') == 1){
                getTab.removeClass('current_gallery');
                $(this).addClass('current_gallery');
            }

            function pxr_gallery_load(callback){

                if (!loading) {
                    loading = true;
                    var data = {
                        action: 'pxr_ajax_gallery_sort',
                        nonce: pxrgallerysort.nonce,
                        post: getPostId,
                        galstyle: getStyle,
                        galpostcount: getPage,

                    };
                    $.post(pxrgallerysort.url, data, function (res) {
                        //console.log(res);

                        if (res.success) {
                            var $content    = $(res.data),
                                getHeight   = $this.find('.projects-content-wrapper-container').height(),
                                getWrapper  = $this.find('.projects-content-wrapper-container');                                
                                
                            getWrapper.css('height', getHeight).html($content).imagesLoaded(function(){

                                var getWrapper  = $this.find('.projects-content-wrapper-container'),
                                    getGallery  = $this.find('.content-wrapper-gallery')
                                    getMaxPage  = getGallery.data('maxpage');

                                $('.content-wrapper-gallery').masonry({
                                  // options
                                  itemSelector: '.grid-gallery',
                                  gutter: '.gutter-gallery',
                                });

                                getWrapper.removeAttr('style');                  

                                if(getMaxPage > 1){
                                    getGallery.after('<div class="loadmore-container"><div class="load-wrapper"><div class="loadmore_gallery fade-animation btn-style' + getStyle + '" id="true_loadmore"><span>' + pxrloadmore.button_text + '</span>' + '<div class="overlay"></div>' + '</div></div></div>');
                                    
                                }

                                loading = false; 
                                callback();
                            })

                        } else {
                             //console.log('2');
                        }
                    }).fail(function (xhr, textStatus, e) {
                         console.log(xhr.responseText);
                    });
                }
            }

            if(getCurrent.css('opacity') == 1){

                getCurrent.removeClass('loaded-animation').find('.fade-image').removeClass('loaded-img-wrapper');
                getCurrent.addClass('progress-animation');

                if(getBtn.css('opacity') == 1){
                    getBtn.removeClass('loaded-animation');
                    getBtn.addClass('progress-animation');                
                }
                
                getCurrent.find('.fade-image').addClass('progress-animation');

                pxr_gallery_load(function(){

                    var getImgWrapper = $this.find('.content-wrapper-img'),
                        getBtn = $this.find('.loadmore_gallery');

                    getImgWrapper.each(function(){
                        if($(this).offset().top < $window.scrollTop() + ($window.height() / 10)*8 ) {
                            $(this).addClass('loaded-animation');
                             $(this).find('.fade-image').addClass('loaded-img-wrapper');
                         }
                     });

                    if(getBtn.length && getBtn.offset().top < $window.scrollTop() + ($window.height() / 10)*8){
                        getBtn.addClass('loaded-animation');
                        getBtn.removeClass('progress-animation');
                    } 
                    
                    getImgWrapper.removeClass('progress-animation');
                    getImgWrapper.find('.fade-image').removeClass('progress-animation');
                });
            }      
        })
    }

    if($('.projects-gallery-wrapper').length){
        $('.projects-gallery-wrapper').each(function(){
            $(this).pxr_gallery_tabs();
        })
    }

});