$(document).ready(function () {

    function MobMenuInit(){
        if ($(".mobile-menu").length){
            $( ".header__burger-button" ).on( "click", function() {
                $('body').addClass('locked');
                $('.mobile-menu').addClass('active');
            } );

            $( ".mobile-menu-close" ).on( "click", function() {
                $('body').removeClass('locked');
                $('.mobile-menu').removeClass('active');
            } );
        }
    }
    MobMenuInit();
    function AosStart(){
        if (typeof AOS === 'undefined') {
            return;
        }
        AOS.init({
            // Global settings:
            disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
            startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
            initClassName: 'aos-init', // class applied after initialization
            animatedClassName: 'aos-animate', // class applied on animation
            useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
            disableMutationObserver: false, // disables automatic mutations' detections (advanced)
            debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
            throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)
            // Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
            offset: 120, // offset (in px) from the original trigger point
            delay: 0, // values from 0 to 3000, with step 50ms
            duration: 1000, // values from 0 to 3000, with step 50ms
            easing: 'ease', // default easing for AOS animations
            once: true, // whether animation should happen only once - while scrolling down
            mirror: false, // whether elements should animate out while scrolling past them
            anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

        });
    }
    AosStart()
    function HeaderMove(){
        if ($("header").length){
            let $menu = $("header");
            $(window).scroll(function() {
                let winScrollTop = $(this).scrollTop();
                if ( winScrollTop > 100 && $menu.hasClass("default")){
                    $menu.removeClass("default").addClass("moved");
                    $('.start__decoration-top').addClass("moved");
                } else if(winScrollTop <= 100 && $menu.hasClass("moved")) {
                    $menu.removeClass("moved").addClass("default");
                } else if(winScrollTop <= 80 && $('.start__decoration-top').hasClass("moved")) {
                    $('.start__decoration-top').removeClass("moved");
                }
            });
        }
    }
    HeaderMove();



    function PopupInit(){
        if ($(".popup").length){
            document.addEventListener( 'wpcf7mailsent', function( event ) {
                $('.popup').fadeIn(300);
                setTimeout(function (){
                    $('.popup').fadeOut(300);
                }, 2000);
            }, false );
        };
    }
    PopupInit();

    function FeaturedContainer(){
        var swiper = new Swiper(".featured .swiper", {
            slidesPerView: 4,
            spaceBetween: 24,
            pagination: {
                el: ".featured .swiper-pagination",
                clickable: true,
            },
            breakpoints: {
                '320': {
                    slidesPerView: 1.5,
                    spaceBetween: 10,
                },
                '500': {
                    slidesPerView: 2,
                    spaceBetween: 10,
                },
                '768': {
                    slidesPerView: 2.5,
                    spaceBetween: 10,
                },
                '1024': {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                '1400': {
                    slidesPerView: 4,
                    spaceBetween: 24,
                },
            },
        });
    }
    if ($('.featured').length && typeof Swiper !== 'undefined') {
        FeaturedContainer();
    }


    function TabInit(){
        if($('.tabs-elements').length){
            $(".tabs-elements .tabs-nav-item").click(function() {
                $(".tabs-elements .tabs-nav-item").removeClass("active").eq($(this).index()).addClass("active");
                $(".tabs-elements .tabs-content-item").hide().eq($(this).index()) .css("display", "block")
                    .hide()
                    .fadeIn();
            }).eq(0).addClass("active");
            $(".tabs-elements .tabs-content-item").eq(0).addClass("active");
        }
    }
    TabInit();

    function SelectricInit($context) {
        if (typeof $.fn.selectric !== 'function') {
            return;
        }

        $context.find('select').each(function() {
            var $select = $(this);
            var $wrapper = $select.closest('.selectric-wrapper');

            if ($select.data('selectric')) {
                $select.selectric('refresh');
            } else {
                // Search & Filter can replace only the native select and leave
                // Selectric's old wrapper in place. Remove that orphan before
                // initializing the replacement control.
                if ($wrapper.length) {
                    $select.insertBefore($wrapper);
                    $wrapper.remove();
                }
                $select.selectric();
            }
        });
    }

    function FilterAvailabilityInit($context) {
        $context.find('.searchandfilter li[data-sf-count]').each(function() {
            var $item = $(this);
            var $input = $item.children('input[type="checkbox"], input[type="radio"]').first();
            var isUnavailable = String($item.attr('data-sf-count')) === '0' && !$input.prop('checked');

            if (!$input.length) {
                return;
            }

            $item.toggleClass('ftc-filter-option-unavailable', isUnavailable);
            if ($input.prop('disabled') !== isUnavailable) {
                $input.prop('disabled', isUnavailable);
            }

            if (isUnavailable) {
                $input.attr('aria-disabled', 'true');
            } else {
                $input.removeAttr('aria-disabled');
            }
        });

        $context.find('.searchandfilter select option[data-sf-count]').each(function() {
            var $option = $(this);
            var isResetOption = String($option.val()) === '';
            var isUnavailable = !isResetOption
                && String($option.attr('data-sf-count')) === '0'
                && !$option.prop('selected');

            $option.toggleClass('ftc-filter-option-unavailable', isUnavailable);
            if ($option.prop('disabled') !== isUnavailable) {
                $option.prop('disabled', isUnavailable);
            }
        });
    }

    var taxonomyAvailabilityRequest = null;

    function ApplyTaxonomyAvailability(availability) {
        var taxonomySelectors = {
            equipment_type: $('#truck-types-select'),
            truck_brands: $('#truck-brands-select')
        };

        Object.keys(taxonomySelectors).forEach(function(taxonomy) {
            var $select = taxonomySelectors[taxonomy];
            var counts = availability[taxonomy] || {};

            if (!$select.length) {
                return;
            }

            $select.find('option[data-term-slug]').each(function() {
                var $option = $(this);
                var slug = String($option.attr('data-term-slug'));
                var count = Number(counts[slug] || 0);
                var isUnavailable = count === 0 && !$option.prop('selected');

                $option.attr('data-available-count', count);
                $option.toggleClass('ftc-filter-option-unavailable', isUnavailable);
                $option.prop('disabled', isUnavailable);
            });

            SelectricInit($select.parent());
        });
    }

    function RefreshTaxonomyAvailability() {
        if (
            !$('.truck-types__select').length
            || typeof ftcTruckCatalog === 'undefined'
            || !ftcTruckCatalog.ajaxUrl
            || typeof window.fetch !== 'function'
        ) {
            return;
        }

        if (taxonomyAvailabilityRequest) {
            taxonomyAvailabilityRequest.abort();
        }

        taxonomyAvailabilityRequest = typeof AbortController === 'function'
            ? new AbortController()
            : null;

        var requestUrl = new URL(ftcTruckCatalog.ajaxUrl, window.location.href);
        var currentUrl = new URL(window.location.href);

        requestUrl.searchParams.set('action', 'ftc_catalog_taxonomy_availability');
        currentUrl.searchParams.forEach(function(value, key) {
            if (/^_(?:sft|sfm)/.test(key)) {
                requestUrl.searchParams.append(key, value);
            }
        });

        if (document.body.classList.contains('tax-equipment_type')) {
            var equipmentTypeSlug = String($('#truck-types-select option:selected').attr('data-term-slug') || '');
            var selectedBrandSlug = String($('#truck-brands-select option:selected').attr('data-term-slug') || '');

            if (equipmentTypeSlug) {
                requestUrl.searchParams.set('ftc_equipment_type', equipmentTypeSlug);
            }
            if (selectedBrandSlug) {
                requestUrl.searchParams.set('_sft_truck_brands', selectedBrandSlug);
            } else {
                requestUrl.searchParams.delete('_sft_truck_brands');
            }
        }

        if (document.body.classList.contains('tax-truck_brands')) {
            var truckBrandSlug = String($('#truck-brands-select option:selected').attr('data-term-slug') || '');
            var selectedTypeSlug = String($('#truck-types-select option:selected').attr('data-term-slug') || '');

            if (truckBrandSlug) {
                requestUrl.searchParams.set('ftc_truck_brands', truckBrandSlug);
            }
            if (selectedTypeSlug) {
                requestUrl.searchParams.set('_sft_equipment_type', selectedTypeSlug);
            } else {
                requestUrl.searchParams.delete('_sft_equipment_type');
            }
        }

        var requestOptions = taxonomyAvailabilityRequest
            ? { signal: taxonomyAvailabilityRequest.signal }
            : {};

        window.fetch(requestUrl.toString(), requestOptions)
            .then(function(response) {
                if (!response.ok) {
                    throw new Error('Unable to refresh taxonomy availability.');
                }
                return response.json();
            })
            .then(function(response) {
                if (response && response.success && response.data) {
                    ApplyTaxonomyAvailability(response.data);
                }
            })
            .catch(function(error) {
                if (error.name !== 'AbortError') {
                    window.console.warn(error);
                }
            });
    }

    FilterAvailabilityInit($(document));
    SelectricInit($(document));

    // Selectric and Search & Filter can be initialized with different jQuery
    // instances. Forward Selectric's custom event as a native change event so
    // Search & Filter receives it and refreshes the results and option counts.
    $(document).on('selectric-change.ftcSearchFilter', '.searchandfilter select', function() {
        this.dispatchEvent(new Event('change', { bubbles: true }));
    });

    // Search & Filter enables every control when an AJAX request finishes.
    // Restore the facet-specific disabled state after that final plugin step.
    var filterAjaxEvents = 'sf:ajaxfinish.ftcFilterAvailability sf:ajaxformfinish.ftcFilterAvailability';
    var refreshFilterAvailability = function() {
        var refreshFilterUi = function() {
            var $forms = $('.searchandfilter');

            FilterAvailabilityInit($forms);
            SelectricInit($forms);
            RefreshTaxonomyAvailability();
        };

        window.requestAnimationFrame(function() {
            window.requestAnimationFrame(refreshFilterUi);
        });

        // Search & Filter removes Selectric wrappers after dispatching some
        // lifecycle events. Run once more after that cleanup has completed.
        window.setTimeout(refreshFilterUi, 120);
    };

    $(document).on(filterAjaxEvents, refreshFilterAvailability);

    // The theme bundle and WordPress can expose different jQuery instances.
    // Search & Filter dispatches its lifecycle events through the WP instance.
    if (window.jQuery && window.jQuery !== $) {
        window.jQuery(document).on(filterAjaxEvents, refreshFilterAvailability);
    }

    // Keep unavailable checkbox rows inert even if another script temporarily
    // changes the native disabled property between AJAX lifecycle events.
    document.addEventListener('click', function(event) {
        var unavailableItem = event.target.closest('.searchandfilter .ftc-filter-option-unavailable');

        if (!unavailableItem) {
            return;
        }

        event.preventDefault();
        event.stopImmediatePropagation();
    }, true);

    if (document.body && $('.searchandfilter').length) {
        var filterRefreshQueued = false;
        var selectricRefreshNeeded = false;
        var filterObserver = new MutationObserver(function(mutations) {
            var mustRefreshAvailability = mutations.some(function(mutation) {
                if (
                    mutation.type === 'attributes'
                    && mutation.target.closest('.searchandfilter')
                ) {
                    return true;
                }

                var removedSelectric = Array.prototype.some.call(mutation.removedNodes, function(node) {
                    return node.nodeType === 1 && (
                        node.matches('.selectric-wrapper')
                        || node.querySelector('.selectric-wrapper')
                    );
                });

                if (removedSelectric && mutation.target.closest('.searchandfilter')) {
                    selectricRefreshNeeded = true;
                    return true;
                }

                return Array.prototype.some.call(mutation.addedNodes, function(node) {
                    if (node.nodeType !== 1) {
                        return false;
                    }

                    if (
                        node.matches('.searchandfilter, select')
                        || node.querySelector('.searchandfilter, select')
                    ) {
                        selectricRefreshNeeded = true;
                    }

                    return Boolean(
                        node.closest('.searchandfilter')
                        || node.querySelector('.searchandfilter')
                    );
                });
            });

            if (!mustRefreshAvailability || filterRefreshQueued) {
                return;
            }

            filterRefreshQueued = true;
            window.requestAnimationFrame(function() {
                var $forms = $('.searchandfilter');
                FilterAvailabilityInit($forms);
                if (selectricRefreshNeeded) {
                    SelectricInit($forms);
                }
                RefreshTaxonomyAvailability();
                selectricRefreshNeeded = false;
                filterRefreshQueued = false;
            });
        });

        filterObserver.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['disabled']
        });
    }

    $(document).on('change.ftcTruckType', '.truck-types__select', function() {
        var $taxonomySelect = $(this);
        var taxonomy = String($taxonomySelect.attr('data-taxonomy') || '');
        var useAjaxFilter = (
            taxonomy === 'truck_brands'
            && document.body.classList.contains('tax-equipment_type')
        ) || (
            taxonomy === 'equipment_type'
            && document.body.classList.contains('tax-truck_brands')
        );

        if (useAjaxFilter) {
            var selectedSlug = String($taxonomySelect.find('option:selected').attr('data-term-slug') || '');
            var filterFieldName = '_sft_' + taxonomy;
            var $filterControls = $('.searchandfilter select, .searchandfilter input').filter(function() {
                return String($(this).attr('name') || '').replace(/\[\]$/, '') === filterFieldName;
            });

            if ($filterControls.is('select')) {
                var $filterSelect = $filterControls.filter('select').first();
                $filterSelect.val(selectedSlug);
                SelectricInit($filterSelect.parent());
                $filterSelect.get(0).dispatchEvent(new Event('change', { bubbles: true }));
                return;
            }

            if ($filterControls.length) {
                var changedControl = null;

                $filterControls.each(function() {
                    var shouldBeChecked = Boolean(selectedSlug) && String(this.value) === selectedSlug;

                    if (this.checked !== shouldBeChecked) {
                        this.checked = shouldBeChecked;
                        if (!changedControl || shouldBeChecked) {
                            changedControl = this;
                        }
                    }
                });

                if (changedControl) {
                    changedControl.dispatchEvent(new Event('change', { bubbles: true }));
                }
                return;
            }
        }

        var termUrl = $(this).val();
        if (!termUrl) {
            return;
        }

        var targetUrl = new URL(termUrl, window.location.href);
        var currentUrl = new URL(window.location.href);
        var taxonomyKeys = [
            '_sft_equipment_type',
            '_sft_truck_brands',
            'ftc_equipment_type',
            'ftc_truck_brands'
        ];
        var filterKeyPattern = /^_(?:sft|sfm|sf_sort_order)/;

        Array.from(targetUrl.searchParams.keys()).forEach(function(key) {
            if (filterKeyPattern.test(key) || taxonomyKeys.indexOf(key) !== -1) {
                targetUrl.searchParams.delete(key);
            }
        });

        currentUrl.searchParams.forEach(function(value, key) {
            if (filterKeyPattern.test(key) && taxonomyKeys.indexOf(key) === -1) {
                targetUrl.searchParams.append(key, value);
            }
        });

        window.location.assign(targetUrl.toString());
    });

    function CatalogControlsInit(){
        if (!$('.sale__result').length) {
            return;
        }

        $(".popup-truck__close").on("click", function() {
            $('.popup-truck').fadeOut(300);
            setTimeout(function() {
                $('.popup-truck__wrapper').empty();
            }, 300);
        });

        $(".sale__main-header .filter").on("click", function() {
            $('.sale__sidebar').addClass('active');
            $(this).attr('aria-expanded', 'true');
        });

        $(".sale__sidebar-close").on("click", function() {
            $('.sale__sidebar').removeClass('active');
            $('.sale__main-header .filter').attr('aria-expanded', 'false');
        });
    }
    CatalogControlsInit();

    function SwiperThumb() {
        var SmallSwiper = new Swiper(".truck-single__img .small", {
            spaceBetween: 17,
            slidesPerView: 5,
            autoHeight: true,
            freeMode: true,
            watchSlidesProgress: true,
        });

        new Swiper(".truck-single__img .big", {
            spaceBetween: 10,
            autoHeight: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: SmallSwiper,
            },
        });
    }

    if ($('.truck-single__img').length && typeof Swiper !== 'undefined') {
        SwiperThumb();
    }

    if ($('.phone').length && typeof IMask !== 'undefined') {
        IMask(document.getElementsByClassName('phone')[0], {
            mask: '+{1} (000) 000-0000'
        });
    }

});

