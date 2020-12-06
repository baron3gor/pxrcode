jQuery(function($){

    var $window = $(window);

    $.fn.pxr_load_more_gl = function() {

        var $this         = $(this),
            $getContainer = $this.find('.content-wrapper-gallery'),
            getStyle      = $getContainer.data('btn'),
            getMaxPage    = $getContainer.data('maxpage'), 
            getTabs       = $this.find('.gallery-tab-item'),
            getPage       = 2;            

        if(getMaxPage > 1) {
            $getContainer.after('<div class="loadmore-container"><div class="load-wrapper"><div class="loadmore_gallery fade-animation btn-style' + getStyle + '" id="true_loadmore"><span>' + pxrloadmore.button_text + '</span>' + '<div class="overlay"></div>' + '</div></div></div>');
        }

        getTabs.on('click', function(){
            getPage = 2;
        });

                
        $this.on('click', '.loadmore_gallery', function(){

            var $getContainer = $this.find('.content-wrapper-gallery'),
                getStyle      = $getContainer.data('btn'),                
                getPostPage   = $getContainer.data('perpage'),
                getMaxPage    = $getContainer.data('maxpage'),
                loading       = false;

            var getBtn = $this.find('.loadmore_gallery'),
                getBtnParent = getBtn.parent();

            getBtnParent.css('opacity', '0');

            if(!loading){
                loading = true;

                var getCat = $getContainer.parent().parent().find('.gallery-tab-item.current_gallery').attr('data-id'),
                    data = {
                        action: 'pxr_ajax_load_more',
                        nonce: pxrloadmore.nonce,
                        page: getPage,
                        query: pxrloadmore.query,
                        cat: getCat,
                        perpage: getPostPage,
                        style: getStyle,
                    };
            };

            $.post(pxrloadmore.url, data, function (res) {
                if (res.success) {  

                    var $content = $(res.data),
                        $grid = $getContainer.masonry({
                            // options
                            itemSelector: '.grid-gallery',
                            gutter: '.gutter-gallery',
                        });

                    $grid.append( $content ).imagesLoaded(function(){

                        $grid.masonry( 'appended', $content , true);

                        var getMaxPage = $getContainer.data('maxpage'),
                            getBtn = $this.find('.loadmore_gallery'),
                            getBtnContainer = getBtn.parent().parent();

                        //Hide the Load More button if no more posts to load
                        if (getPage == getMaxPage) {
                            getBtn.hide();
                        } else {
                            getBtnContainer.html('<div class="load-wrapper"><div class="loadmore_gallery fade-animation btn-style' + getStyle + '" id="true_loadmore"><span>' + pxrloadmore.button_text + '</span>' + '<div class="overlay"></div>' + '</div></div>');

                            if(getBtnContainer.find('.loadmore_gallery.fade-animation').offset().top < $window.scrollTop() + ($window.height() / 10)*8 ) {
                                getBtnContainer.find('.loadmore_gallery.fade-animation').addClass('loaded-animation');
                            }
                        }

                        getPage = getPage + 1;

                    });
                     
                    var getImg = $getContainer.find('.content-wrapper-img'); 
                    setTimeout(function(){
                        getImg.each(function(){
                            if($(this).offset().top < $window.scrollTop() + ($window.height() / 10)*8  ) {
                                $(this).addClass('loaded-animation');
                                $(this).find('.fade-image').addClass('loaded-img-wrapper');
                            }
                        });
                    }, 200)                   
                    
                    loading = false;
                    return false;
                } else {
                    // console.log(res);
                }
            }).fail(function (xhr, textStatus, e) {
                // console.log(xhr.responseText);
            });
        })      
    }

    if($('.projects-gallery-wrapper').length) {
        $('.projects-gallery-wrapper').each(function(){
            $(this).pxr_load_more_gl();
        });
    }
    
});