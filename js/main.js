/* Mzansi Homes — main.js */
(function ($) {
    'use strict';

    /* ── MOBILE NAV ── */
    const $toggle = $('#mobile-toggle');
    const $nav    = $('#primary-nav');
    const $header = $('#site-header');

    $toggle.on('click', function () {
        const open = $(this).attr('aria-expanded') === 'true';
        $(this).attr('aria-expanded', !open).toggleClass('open');
        $nav.toggleClass('open');
        $('body').toggleClass('nav-open');
    });

    // Sticky header
    $(window).on('scroll', function () {
        $header.toggleClass('scrolled', $(window).scrollTop() > 60);
    });

    /* ── HERO SEARCH → redirect to archive ── */
    $('#hero-search-btn').on('click', function (e) {
        e.preventDefault();
        const keyword  = $('#search-keyword').val();
        const type     = $('#search-type').val();
        const beds     = $('#search-beds').val();
        const maxPrice = $('#search-max-price').val();
        const status   = $('.mh-search-tab.active').data('status') || '';

        const params = new URLSearchParams();
        if (keyword)  params.set('keyword',       keyword);
        if (type)     params.set('property_type', type);
        if (beds)     params.set('bedrooms',       beds);
        if (maxPrice) params.set('max_price',      maxPrice);
        if (status)   params.set('status',         status);

        const archive = $('body').data('property-archive') || '/properties/';
        window.location.href = archive + '?' + params.toString();
    });

    // Hero search tabs
    $(document).on('click', '.mh-search-tab', function () {
        $('.mh-search-tab').removeClass('active');
        $(this).addClass('active');
    });

    /* ── AJAX PROPERTY FILTER ── */
    let currentPage = 1;
    let isLoading   = false;

    function runSearch(page) {
        if (isLoading) return;
        isLoading = true;
        currentPage = page || 1;

        const data = {
            action:        'mh_search',
            nonce:         mh_ajax.nonce,
            page:          currentPage,
            keyword:       $('#f-keyword').val()    || '',
            property_type: $('#f-type').val()       || '',
            status:        $('#f-status').val()     || '',
            location:      $('#f-location').val()   || '',
            bedrooms:      $('#f-beds').val()        || '',
            min_price:     $('#f-min-price').val()  || '',
            max_price:     $('#f-max-price').val()  || '',
        };

        $('#listings-grid').addClass('mh-loading');

        $.post(mh_ajax.ajax_url, data)
            .done(function (res) {
                if (res.success) {
                    $('#listings-grid').html(res.data.html);
                    $('#results-count').html('<strong>' + res.data.found + '</strong> properties found');
                    renderPagination(res.data.max_pages, res.data.current);
                }
            })
            .always(function () {
                $('#listings-grid').removeClass('mh-loading');
                isLoading = false;
                $('html, body').animate({ scrollTop: $('#property-filter').offset()?.top - 100 || 0 }, 400);
            });
    }

    function renderPagination(maxPages, current) {
        if (maxPages <= 1) { $('#mh-pagination').empty(); return; }
        let html = '';
        if (current > 1)       html += '<button class="mh-page-btn" data-page="' + (current - 1) + '">← Prev</button>';
        for (let i = 1; i <= maxPages; i++) {
            html += '<button class="mh-page-btn' + (i === current ? ' active' : '') + '" data-page="' + i + '">' + i + '</button>';
        }
        if (current < maxPages) html += '<button class="mh-page-btn" data-page="' + (current + 1) + '">Next →</button>';
        $('#mh-pagination').html(html);
    }

    if ($('#filter-form').length) {
        $('#filter-form').on('submit', function (e) {
            e.preventDefault();
            runSearch(1);
        });

        $('#filter-reset').on('click', function () {
            $('#filter-form')[0].reset();
            runSearch(1);
        });

        $(document).on('click', '.mh-page-btn', function () {
            runSearch(parseInt($(this).data('page')));
        });
    }

    /* ── VIEW TOGGLE (grid / list) ── */
    $(document).on('click', '.mh-view-btn', function () {
        const view = $(this).data('view');
        $('.mh-view-btn').removeClass('active');
        $(this).addClass('active');
        $('#listings-grid').removeClass('mh-grid-view mh-list-view').addClass('mh-' + view + '-view');
    });

    /* ── CONTACT / ENQUIRY FORMS ── */
    function submitContactForm($form, propertyName) {
        const $btn = $form.find('button[type="submit"]');
        const $res = $form.find('.mh-form-response');
        $btn.prop('disabled', true).text('Sending…');
        $res.removeClass('success error').text('');

        const data = {
            action:   'mh_contact',
            nonce:    mh_ajax.nonce,
            name:     $form.find('[name="name"]').val(),
            email:    $form.find('[name="email"]').val(),
            phone:    $form.find('[name="phone"]').val(),
            message:  $form.find('[name="message"]').val(),
            property: propertyName || '',
        };

        $.post(mh_ajax.ajax_url, data)
            .done(function (res) {
                if (res.success) {
                    $res.addClass('success').text(res.data);
                    $form[0].reset();
                } else {
                    $res.addClass('error').text(res.data || 'An error occurred.');
                }
            })
            .fail(function () {
                $res.addClass('error').text('Network error. Please try again.');
            })
            .always(function () {
                $btn.prop('disabled', false).text($btn.data('original-text') || 'Send');
            });
    }

    $('#property-enquiry-form').on('submit', function (e) {
        e.preventDefault();
        submitContactForm($(this), $(this).data('property'));
    });

    $('#main-contact-form').on('submit', function (e) {
        e.preventDefault();
        submitContactForm($(this));
    });

    /* ── SAVE / FAVOURITE PROPERTY ── */
    function getSaved() {
        try { return JSON.parse(localStorage.getItem('mh_saved') || '[]'); } catch(e) { return []; }
    }
    function setSaved(arr) {
        localStorage.setItem('mh_saved', JSON.stringify(arr));
    }

    // Highlight already-saved
    const saved = getSaved();
    saved.forEach(id => $('.mh-save-btn[data-id="' + id + '"]').addClass('saved'));

    $(document).on('click', '.mh-save-btn', function (e) {
        e.preventDefault();
        e.stopPropagation();
        const id  = $(this).data('id').toString();
        let arr   = getSaved();
        const idx = arr.indexOf(id);
        if (idx > -1) {
            arr.splice(idx, 1);
            $(this).removeClass('saved');
        } else {
            arr.push(id);
            $(this).addClass('saved');
        }
        setSaved(arr);
    });

    /* ── SMOOTH SCROLL for # links ── */
    $(document).on('click', 'a[href^="#"]', function (e) {
        const target = $($(this).attr('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: target.offset().top - 80 }, 500);
        }
    });

})(jQuery);
