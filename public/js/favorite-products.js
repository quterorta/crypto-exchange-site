$(document).ready(function (){
    if (!localStorage.getItem('favorite-products')) {
        localStorage.setItem('favorite-products', []);
    }

    $('.add-to-favorite').each(function() {
        let allProducts = [];
        if (localStorage.getItem('favorite-products')) {
            allProducts = JSON.parse(localStorage.getItem('favorite-products'));
        }
        let productId = $(this).data('product');

        if (allProducts.includes(productId)) {
            $(this).html('Eliminați din favorite');
        }
    });

    $('.add-to-favorite-min').each(function() {
        let allProducts = [];
        if (localStorage.getItem('favorite-products')) {
            allProducts = JSON.parse(localStorage.getItem('favorite-products'));
        }
        let productId = $(this).data('product');

        if (!allProducts.includes(productId)) {
            if ($(this).hasClass('favorite-product')) {
                $(this).removeClass('favorite-product');
            }
            $(this).addClass('non-favorite-product');
            $(this).html('<i class="fa-solid fa-heart-circle-plus"></i>');
        } else {
            if ($(this).hasClass('non-favorite-product')) {
                $(this).removeClass('non-favorite-product');
            }
            $(this).addClass('favorite-product');
            $(this).html('<i class="fa-solid fa-heart-circle-minus"></i>');
        }
    });

    $('.add-to-favorite').click(function() {
        let allProducts = [];
        let productId = $(this).data('product');
        if (localStorage.getItem('favorite-products')) {
            allProducts = JSON.parse(localStorage.getItem('favorite-products'));
        }
        if (allProducts.includes(productId)) {
            allProducts.splice($.inArray(productId, allProducts),1);
            $(this).html('Adaugă la favorite <i class="fa-solid fa-heart"></i>');
        } else {
            allProducts.push(productId);
            $(this).html('Eliminați din favorite');
        }
        localStorage.setItem('favorite-products', JSON.stringify(allProducts));
    });

    $('.add-to-favorite-min').click(function() {
        let allProducts = [];
        let productId = $(this).data('product');
        if (localStorage.getItem('favorite-products')) {
            allProducts = JSON.parse(localStorage.getItem('favorite-products'));
        }
        if (allProducts.includes(productId)) {
            allProducts.splice($.inArray(productId, allProducts),1);
            if ($(this).hasClass('favorite-product')) {
                $(this).removeClass('favorite-product');
            }
            $(this).addClass('non-favorite-product');
            $(this).html('<i class="fa-solid fa-heart-circle-plus"></i>');
        } else {
            allProducts.push(productId);
            if ($(this).hasClass('non-favorite-product')) {
                $(this).removeClass('non-favorite-product');
            }
            $(this).addClass('favorite-product');
            $(this).html('<i class="fa-solid fa-heart-circle-minus"></i>');
        }
        localStorage.setItem('favorite-products', JSON.stringify(allProducts));
    });
});
