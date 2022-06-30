$(document).ready(function () {
    $('.main-page-slider').slick({
        prevArrow: '<button class="main-page-slider-prev-button"><i class="fa-solid fa-chevron-left"></i></button>',
        nextArrow: '<button class="main-page-slider-next-button"><i class="fa-solid fa-chevron-right"></i></button>',
    });
});

$(document).ready(function () {
    $('.product-card-image-container-slick').slick({
        prevArrow: '<button class="product-card-image-container-slick-prev-button"><i class="fa-solid fa-chevron-left"></i></button>',
        nextArrow: '<button class="product-card-image-container-slick-next-button"><i class="fa-solid fa-chevron-right"></i></button>',
    });
});

$(document).ready(function () {
    $('.popular-products-slider').slick({
        prevArrow: '<button class="popular-products-slider-prev-button"><i class="fa-solid fa-chevron-left"></i></button>',
        nextArrow: '<button class="popular-products-slider-next-button"><i class="fa-solid fa-chevron-right"></i></button>',
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 400,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });
    $('.new-products-slider').slick({
        prevArrow: '<button class="new-products-slider-prev-button"><i class="fa-solid fa-chevron-left"></i></button>',
        nextArrow: '<button class="new-products-slider-next-button"><i class="fa-solid fa-chevron-right"></i></button>',
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 400,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    $('.product-detail-slick').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: false,
        draggable: false,
        asNavFor: '.product-detail-nav-slick',
    });
    $('.product-detail-nav-slick').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.product-detail-slick',
        centerMode: true,
        focusOnSelect: true
    });
});
