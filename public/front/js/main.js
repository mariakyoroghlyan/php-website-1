// start::logo fade out
$(window).scroll(function () {
    let windowWidth = $(window).width();
    if ($(this).scrollTop() > 80) {
        if (windowWidth > 1024) {
            $(".logo").addClass("fade_out");
        }
    } else {
        $(".logo").removeClass("fade_out");
    }
});
// end::logo fade out


// start::hero title decrease
$(window).scroll(function () {
    let heroTitle = $('.hero_title'); // Use jQuery to select the element
    let maxFontSizeVW = 8.854; // Maximum font size in vw
    let minFontSizeVW = 3.125; // Minimum font size in vw
    let scrollThreshold = 80; // Scroll threshold in pixels
    let windowWidth = $(window).width();
    let scrollTop = $(this).scrollTop(); // Get the current scroll position

    if(windowWidth > 1024) {
        if (scrollTop > scrollThreshold) {
            // Calculate the new font size based on scroll position
            const newFontSizeVW = Math.max(minFontSizeVW, maxFontSizeVW - (scrollTop - scrollThreshold) / 25);
            heroTitle.css('font-size', newFontSizeVW + 'vw'); // Set the new font size in vw
        } else {
            // Reset to the maximum font size when scrolled above the threshold
            heroTitle.css('font-size', maxFontSizeVW + 'vw');
        }
    }
});

// end::hero title decrease


// start::text pop up in fund
$(window).scroll(function () {
    var $advantagesSection = $('.advantages_section');
    var $heroHiddenText = $('.hero_hidden_text');

    if ($advantagesSection.length) {
        var scrollPos = $(window).scrollTop();
        var sectionOffset = $advantagesSection.offset().top - 300;

        if (scrollPos >= sectionOffset) {
            $heroHiddenText.css('top', '0');
        }
    }
});

$(window).scroll(function () {
    var $pageTitleSection = $('.page_title_section');
    var $heroHiddenText2 = $('.hero_hidden_text2');

    if ($pageTitleSection.length) {
        var scrollPos = $(window).scrollTop();
        var sectionOffset = $pageTitleSection.offset().top - 200;

        if (scrollPos >= sectionOffset) {
            $heroHiddenText2.css('top', '0');
        }
    }
});
// end::text pop up in fund


// start:: open get in touch modal
$(".get_intouch,.footer_get_intouch").click(function () {
    $('.get_intouch_modal').toggleClass('hide')
    $('body').css('overflow', 'hidden')
});

$(".get_intouch_close").click(function (e) {
    e.stopPropagation()
    $('.get_intouch_modal').toggleClass('hide')
    $('body').css('overflow', 'auto')
});


$(".get_intouch_modal").click(function () {
    $('.get_intouch_modal').toggleClass('hide')
    $('body').css('overflow', 'auto')
});
// end:: open get in touch modal


// start:: team modal
$(".see_more").click(function () {
    $('.team_modal ').toggleClass('hide')
    $('body').css('overflow', 'hidden')
});

$(".team_modal_close").click(function (e) {
    e.stopPropagation()
    $('.team_modal ').toggleClass('hide')
    $('body').css('overflow', 'auto')
});

$(".team_modal").click(function () {
    $('.team_modal ').toggleClass('hide')
    $('body').css('overflow', 'auto')
});
// end:: team modal

// start:: portfolio modal
$(".see_more_investment").click(function () {
    $('.portfolio_modal').toggleClass('hide')
    $('body').css('overflow', 'hidden')
});

$(".portfolio_modal_close").click(function (e) {
    e.stopPropagation(); // Prevents event from bubbling up
    $('.portfolio_modal').toggleClass('hide');
    $('body').css('overflow', 'auto');
});

$(".portfolio_modal").click(function () {
    $('.portfolio_modal').toggleClass('hide');
    $('body').css('overflow', 'auto');
});

$(".team_modal_box").click(function (e) {
    e.stopPropagation(); // Stops click from propagating to the modal background
});

$(".get_intouch_modal_box").click(function (e) {
    e.stopPropagation(); // Stops click from propagating to the modal background
});

$(".portfolio_modal_box ").click(function (e) {
    e.stopPropagation(); // Stops click from propagating to the modal background
});
// end:: portfolio modal

// start::carousel
var swiper = new Swiper('.swiper', {
    slidesPerView: 'auto',
    direction: 'horizontal',
    loopFillGroupWithBlank: true,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    loop: false,
});


// Function to adjust transform for the last slide right!
function adjustTransform() {
    var totalSlides = swiper.slides.length;
    var slidesPerView = swiper.params.slidesPerView;

    if (totalSlides % slidesPerView !== 0) {
        var totalWidth = totalSlides * (100 / slidesPerView);
        var lastSlideWidth = (totalSlides % slidesPerView) * (100 / totalSlides);
        swiper.setTranslate(-totalWidth + lastSlideWidth);
    }
}

// end::carousel

// start::tablet menu
$('.tablet_menu_opener').click(function () {
    const isMenuOpen = $('.tablet_menu').height() > 0;
    const screenWidth = window.innerWidth;


    if (isMenuOpen) {
        $('.tablet_menu').animate({
            height: '0',
            paddingBottom: '0',
        }, 100);
        setTimeout(function () {
            $('.tablet_menu').css('padding-top', 0)
        }, 1000)

        $('.logo_and_open_container').css('--before-width', '0');
        $('.logo_and_open_container').css('--before-border', '0');
        $('.menu_open').animate({top: '0'}, 400);
        $('.menu_close').animate({top: '30px'}, 400);
        if (screenWidth <= 1024) {
            $('body').css('overflow', 'auto');
        }
    } else {
        if (screenWidth <= 500) {
            var calculatedHeight = window.innerHeight - (window.innerHeight * 6.3 / 100);
            $('.tablet_menu').animate({
                height: calculatedHeight + 'px',
                paddingBottom: '9.708vw'
            }, 100);
        } else {
            $('.tablet_menu').animate({
                height: '100vh',
                paddingTop: '6.097vw'
            }, 100);
        }
        if (screenWidth <= 500) {
            $('.logo_and_open_container').css('--before-width', '90%');
        } else {
            $('.logo_and_open_container').css('--before-width', '95%');
        }

        $('.logo_and_open_container').css('--before-border', '1px');
        $('.menu_open').animate({top: '-30px'}, 400);
        $('.menu_close').animate({top: '0'}, 400);

        if (screenWidth <= 1024) {
            $('body').css('overflow', 'hidden');
        }
    }
});
// end::tablet menu