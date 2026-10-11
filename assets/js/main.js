(function($) {
    "use strict";
    /* Main Functions */
    var CLHotel = {
        init: function() {
            this.Basic.init();
        },

        Basic: {
            init: function() {
                this.StickyMenu();
                this.MobileMenu();
                this.elementLoader();
                this.Lightbox1();
                this.Lightbox2();
                this.Lightbox3();
                this.RangeSlider();
                this.RtGlobalSlider();
                this.RtPricingTable();
                this.CLHotelOthers();
            },
            StickyMenu: function(){
                if ($('body').scrollTop() >= $("body").offset().top + 50) {
                    $("body").addClass("mn-top");
                } else {
                    $("body").removeClass("mn-top");
                }
            },

            MobileMenu: function (){
                var a = $('.offscreen-navigation .main-menu');
                if (a.length) {
                    $(".menu-item-has-children").append("<span></span>");
                    $(".page_item_has_children").append("<span></span>");

                    a.children("li").addClass("menu-item-parent");

                    $('.menu-item-has-children > span').on('click', function () {
                        var _self = $(this),
                            sub_menu = _self.parent().find('>.sub-menu');
                        if (_self.hasClass('open')) {
                            sub_menu.slideUp();
                            _self.removeClass('open');
                        } else {
                            sub_menu.slideDown();
                            _self.addClass('open');
                        }
                    });
                    $('.page_item_has_children > span').on('click', function () {
                        var _self = $(this),
                            sub_menu = _self.parent().find('>.children');
                        if (_self.hasClass('open')) {
                            sub_menu.slideUp();
                            _self.removeClass('open');
                        } else {
                            sub_menu.slideDown();
                            _self.addClass('open');
                        }
                    });
                }
                $('.mean-bar .sidebarBtn').on('click', function (e) {
                    e.preventDefault();
                    if ($('.rt-slide-nav').is(":visible")) {
                        $('.rt-slide-nav').slideUp();
                        $('body').removeClass('slidemenuon');
                    } else {
                        $('.rt-slide-nav').slideDown();
                        $('body').addClass('slidemenuon');
                    }
                });
            },

            elementLoader: function(){
                $('body').imagesLoaded().done(function(instance) {
                    $('body').addClass('loaded');
                });
                /*-------------------------------------
                Page Preloader
                -------------------------------------*/
                if ($('#pageoverlay').length) {
                    document.getElementById('pageoverlay').className = 'pageoverlay';
                    $('#pageoverlay').delay(800).fadeOut();
                }
            },

            Lightbox1: function() {
                /*-------------------------------------
                    PhotoSwipe Lightbox
                -------------------------------------*/
                // Init empty gallery array
                var container = [];
                // $(".photo-swip-gallery-wrap .photoswip-item a").attr(
                //     {width: "1170",  height:"550"}
                // );
                // Loop over gallery items and push it to the array
                $('.photo-swip-gallery-wrap').find('.photoswip-item').each(function() {
                    var $link = $(this).find('a.listing-popup-btn'),
                    item = {
                        src: $link.attr('href'),
                        w: $link.attr('data-width'),
                        h: $link.attr('data-height')
                    };
                    container.push(item);
                });
        
                // Define click event on gallery item
                $('.photo-swip-gallery-wrap .photoswip-item a.listing-popup-btn').click(function(event) {
        
                    // Prevent location change
                    event.preventDefault();
        
                    // Define object and gallery options
                    var $pswp = $('.pswp')[0],
                    options = {
                        index: $(this).parent('.photoswip-item').index(),
                        bgOpacity: 0.85,
                        showHideOpacity: true
                    };
        
                    // Initialize PhotoSwipe
                    var gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
                    console.log(gallery);
                    gallery.init();
                });
            },

            Lightbox2: function() {
                /*-------------------------------------
                    PhotoSwipe Lightbox
                -------------------------------------*/
                // Use event delegation instead of direct .click()
                $(document).on('click', '.rtcl-archive-gallery-trigger', function(event) {
                    event.preventDefault();
 
                    let container = [];
                    $(this).parent().find('.rtcl-pswp-item').each(function() {
                        let $link = $(this).find('img'),
                            item = {
                                src: $link.attr('src'),
                                w: $link.attr('width'),
                                h: $link.attr('height')
                            };
                        container.push(item);
                    });
 
                    let $pswp = $('.pswp')[0],
                        options = {
                            index: $(this).parent('.rtcl-pswp-item').index(),
                            bgOpacity: 0.8,
                            zoomEl: true,
                            tapToClose: true,
                            fullscreenEl: true,
                            preloaderEl: true,
                            shareEl: true,
                            captionEl: false,
                        };
 
                    let gallery = new PhotoSwipe($pswp, PhotoSwipeUI_Default, container, options);
                    gallery.init();
                });
            },

            Lightbox3: function() {
                var initPhotoSwipeFromDOM = function(gallerySelector) {
                    // parse slide data (url, title, size ...) from DOM elements 
                    // (children of gallerySelector)
                    var parseThumbnailElements = function(el) {
                        var thumbElements = el.childNodes,
                            numNodes = thumbElements.length,
                            items = [],
                            figureEl,
                            linkEl,
                            size,
                            item;
                        for(var i = 0; i < numNodes; i++) {
                            
                            figureEl = thumbElements[i]; // <figure> element
        
                            // include only element nodes 
                            if(figureEl.nodeType !== 1) {
                                continue;
                            }
        
                            linkEl = figureEl.children[0]; // <a> element
                            size = linkEl.getAttribute('data-size').split('x');
        
                            // create slide object
                            item = {
                                src: linkEl.getAttribute('href'),
                                w: parseInt(size[0], 10),
                                h: parseInt(size[1], 10)
                            };
        
                            if(figureEl.children.length > 1) {
                                // <figcaption> content
                                item.title = figureEl.children[1].innerHTML; 
                            }
                            if(linkEl.children.length > 0) {
                                // <img> thumbnail element, retrieving thumbnail url
                                item.msrc = linkEl.children[0].getAttribute('src');
                            } 
                            item.el = figureEl; // save link to element for getThumbBoundsFn
                            items.push(item);
                        }
                        return items;
                    };
        
                    // find nearest parent element
                    var closest = function closest(el, fn) {
                        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
                    };
        
                    // triggers when user clicks on thumbnail
                    var onThumbnailsClick = function(e) {
                        e = e || window.event;
                        e.preventDefault ? e.preventDefault() : e.returnValue = false;
                        var eTarget = e.target || e.srcElement;
                        // find root element of slide
                        var clickedListItem = closest(eTarget, function(el) {
                            return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
                        });
                        if(!clickedListItem) {
                            return;
                        }
                        // find index of clicked item by looping through all child nodes
                        // alternatively, you may define index via data- attribute
                        var clickedGallery = clickedListItem.parentNode,
                            childNodes = clickedListItem.parentNode.childNodes,
                            numChildNodes = childNodes.length,
                            nodeIndex = 0,
                            index;
                        for (var i = 0; i < numChildNodes; i++) {
                            if(childNodes[i].nodeType !== 1) { 
                                continue; 
                            }
        
                            if(childNodes[i] === clickedListItem) {
                                index = nodeIndex;
                                break;
                            }
                            nodeIndex++;
                        }
                        if(index >= 0) {
                            // open PhotoSwipe if valid index found
                            openPhotoSwipe( index, clickedGallery );
                        }
                        return false;
                    };
        
                    // parse picture index and gallery index from URL (#&pid=1&gid=2)
                    var photoswipeParseHash = function() {
                        var hash = window.location.hash.substring(1),
                        params = {};
        
                        if(hash.length < 5) {
                            return params;
                        }
        
                        var vars = hash.split('&');
                        for (var i = 0; i < vars.length; i++) {
                            if(!vars[i]) {
                                continue;
                            }
                            var pair = vars[i].split('=');  
                            if(pair.length < 2) {
                                continue;
                            }           
                            params[pair[0]] = pair[1];
                        }
        
                        if(params.gid) {
                            params.gid = parseInt(params.gid, 10);
                        }
        
                        return params;
                    };
        
                    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
                        var pswpElement = document.querySelectorAll('.pswp')[0],
                            gallery,
                            options,
                            items;
        
                        items = parseThumbnailElements(galleryElement);
        
                        // define options (if needed)
                        options = {
                            // define gallery index (for URL)
                            galleryUID: galleryElement.getAttribute('data-pswp-uid'),
        
                            getThumbBoundsFn: function(index) {
                                // See Options -> getThumbBoundsFn section of documentation for more info
                                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                                    rect = thumbnail.getBoundingClientRect(); 
                                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                            }
        
                        };
        
                        // PhotoSwipe opened from URL
                        if(fromURL) {
                            if(options.galleryPIDs) {
                                // parse real index when custom PIDs are used 
                                for(var j = 0; j < items.length; j++) {
                                    if(items[j].pid == index) {
                                        options.index = j;
                                        break;
                                    }
                                }
                            } else {
                                // in URL indexes start from 1
                                options.index = parseInt(index, 10) - 1;
                            }
                        } else {
                            options.index = parseInt(index, 10);
                        }
        
                        // exit if index not found
                        if( isNaN(options.index) ) {
                            return;
                        }
        
                        if(disableAnimation) {
                            options.showAnimationDuration = 0;
                        }
        
                        // Pass data to PhotoSwipe and initialize it
                        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
                        gallery.init();
                    };
        
                    // loop through all gallery elements and bind events
                    var galleryElements = document.querySelectorAll( gallerySelector );
        
                    for(var i = 0, l = galleryElements.length; i < l; i++) {
                        galleryElements[i].setAttribute('data-pswp-uid', i+1);
                        galleryElements[i].onclick = onThumbnailsClick;
                    }
        
                    // Parse URL and open gallery if it contains #&pid=3&gid=1
                    var hashData = photoswipeParseHash();
                    if(hashData.pid && hashData.gid) {
                        openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
                    }
                };
        
                // execute above function
                initPhotoSwipeFromDOM('.single-listing-food-menu');
            },

            RangeSlider: function() {
                // Price Filter range slider  
                if ($.fn.ionRangeSlider) {

                    $(".ion-rangeslider").each(function () {
                        var $this = $(this);
                        var rangeType = $this.data('type');
                        $this.ionRangeSlider({
                            type: rangeType || "double",
                            drag_interval: true,
                            min_interval: null,
                            max_interval: null,
                            onChange: function (data) {
                                var $inp = data.input;
                                $inp.parent().find('.min-volumn').val(data.from);
                                $inp.parent().find('.max-volumn').val(data.to);
                            },
                        });
                    });
                    
                    $(".advance-search-form .rtcl-range-slider-input").each(function () {
                        var $this = $(this);
                        var rangeType = $this.data('type');
                        $this.ionRangeSlider({
                            drag_interval: true,
                            min_interval: null,
                            max_interval: null,
                            onChange: function (data) {
                                var $inp = data.input;
                                $inp.parent().find('.min-volumn').val(data.from);
                                $inp.parent().find('.max-volumn').val(data.to);
                            },
                        });
                    });

                }
            },

            RtGlobalSlider: function(){
                $('.rt-global-slider').each(function() {
                    var $this = $(this);
                    $this.fadeIn();
                    var settings = $this.data('slider-options');
                    var autoplayconditon= settings['auto'];
                    var $pagination = $this.find('.swiper-pagination')[0];
                    var $next = $this.find('.swiper-button-next')[0];
                    var $prev = $this.find('.swiper-button-prev')[0];

                    new Swiper( $this[0], {
                        speed:settings['speed'],
                        spaceBetween:  settings['spaceBetween'],
                        slidesPerGroup: settings['slidesPerGroup'] ? settings['slidesPerGroup']:1,
                        autoplay:autoplayconditon ? {delay:settings['autoplay']['delay']}:false,
                        pagination: {
                            el: $pagination,
                            clickable: true,
                            type: 'bullets',
                        },
                        navigation: {
                            nextEl: $next,
                            prevEl: $prev,
                        },
                        breakpoints: {
                            0: {
                                slidesPerView: settings['breakpoints']['0']['slidesPerView'],
                            },
                            576: {
                                slidesPerView: settings['breakpoints']['480']['slidesPerView'],
                            },
                            768: {
                                slidesPerView: settings['breakpoints']['768']['slidesPerView'],
                            },
                            992: {
                                slidesPerView: settings['breakpoints']['992']['slidesPerView'],
                            },
                            1600: {
                                slidesPerView: settings['breakpoints']['1600']['slidesPerView'],
                            },
                        },
                    });
        
                });
            },

            RtPricingTable: function(){
                // pricing table
                const pricingWrapper = $(".rt-pricing-tab");
                if (pricingWrapper) {
                    $(".rt-pricing-tab").each(function() {
                        $(".pricing-switch-container").on("click", function() {
                            $(".pricing-switch")
                                .parents(".price-switch-box")
                                .toggleClass("price-switch-box--active"),
                                $(".pricing-switch").toggleClass("pricing-switch-active"),
                                $(".rt-tab-content").toggleClass("rt-active");
                        });
                    });
                }
            },

            BackToTop: function(){
                // Back Top Button
                if ($(window).scrollTop() > 500) {
                    $(".scrollup").addClass("back-top");
                } else {
                    $(".scrollup").removeClass("back-top");
                }
            },

            CLHotelOthers: function(){

                /* - Tooltip
                -------------------------------------*/
                const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
                const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

                /* - Listing Archive Ordering
                --------------------------------------------*/
                $('.rtcl-ordering').each(function(){
                    $('.orderby').select2({
                        allowClear: true
                    });
                });


                $('#rtcl-ad-category-selection').each(function(){
                    $('.rtcl-select2').select2({
                        allowClear: true
                    });
                });

                if ($('.rtcl-widget-search-form select').length) {
                    $('.rtcl-widget-search-form select').select2({
                        theme: 'classic',
                        dropdownAutoWidth: true,
                        width: '100%',
                    });
                }

                $('ul.page-numbers li a').each(function() {
                    var $this = $(this);
                    if ( $this.hasClass('prev') ) $this.parent('li').addClass('prev-list-item');
                    if ( $this.hasClass('next') ) $this.parent('li').addClass('next-list-item');      
                });

                $('#toggle-listing-sidebar').on('click', function() {
                    var $main = $('.listing-archive-sidebar');
                    $main.stop(true, true).slideToggle(500);
                    return false; // Prevent default action
                });

            }
        }
    }

    $(window).on('load', function() {
        CLHotel.Basic.elementLoader();
        // wow.init();
    });
    
    /*- Add class for responsive menu          
    --------------------------------------------*/
    $(window).on("scroll", function (){
        CLHotel.Basic.StickyMenu();
        CLHotel.Basic.BackToTop();
    });

    // Window Load+Resize
    $(window).on('load resize', function (){
        // Elementor Frontend Load
        $(window).on('elementor/frontend/init', function () {
            if (elementorFrontend.isEditMode()) {
                elementorFrontend.hooks.addAction('frontend/element_ready/widget', function () {
                    CLHotel.init();
                    // new WOW().init();
                });
            }
        });
    });

    $( document ).ready( function () {
        CLHotel.init(); 
        $('#expand-parent').click(function(){
            $(this).parent().toggleClass('is-active', 1000);
        });
    });

})(jQuery);