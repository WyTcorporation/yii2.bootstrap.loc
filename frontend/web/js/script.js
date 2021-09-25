$('#header_mobile_btn').on('click', function (e) {
    $('#top-links').toggle().slow();
});

$('.badge').on('click', function (e) {
    $(this).toggleClass('active').siblings('.dropdown').toggle(300, 'swing').toggleClass('active').siblings('.list-group-item').toggleClass('active');
    var val = $(this).siblings('.dropdown');
    if (val.hasClass('active')) {
        $(this).find('.fa').removeClass('fa-sort-up').addClass('fa-sort-down');
        //console.log(true);
    } else {
        $(this).find('.fa').removeClass('fa-sort-down').addClass('fa-sort-up');
        //console.log(false);
    }
});

$('.carousel-button-next').on('click', function (e) {
    $('#slider .slick-next').click();
});

$('.carousel-button-prev').on('click', function (e) {
    $('#slider .slick-prev').click();
});

$('#grid-view').on('click', function (e) {
    $('.product-layout').removeClass('product-list col-xs-12').addClass('product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
    $('#list-view').removeClass('active');
    $(this).addClass('active');
});

$('#list-view').on('click', function (e) {
    $('.product-layout').removeClass('product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12').addClass('product-list col-xs-12');
    $('#grid-view').removeClass('active');
    $(this).addClass('active');
});

$('#slider').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 6,
    slidesToScroll: 1,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
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
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1
            }
        }
    ]
});

$('#mainSlider').slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: false
            }
        },
        {
            breakpoint: 600,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: false
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                dots: false
            }
        }
    ]
});
//Добавление в корзину
$('.add-to-cart').on('click', function (e) {
    e.preventDefault();

    var id = $(this).data('id'),
        qty = $('#qty').val();
    if (qty != null) {
        qty = qty;
    } else {
        qty = 1;
    }
    $.ajax({
        url: '/cart/add',
        data: {id: id, qty: qty},
        type: 'GET',
        success: function (res) {
            if (!res) alert('Такого товара нет');
            // console.log(res);
            showCart(res)
        },
        error: function () {
            alert('Error')
        }
    });

    return false;
});

//Добавление корзины в модальное окно
function showCart(cart) {
    $('#cart .modal-body').html(cart);
    $('#cart').modal();
}

//Очистка корзины
function clearCart() {
    $.ajax({
        url: '/cart/clear',
        type: 'GET',
        success: function (res) {
            if (!res) alert('Такого товара нет');
            showCart(res)
        },
        error: function () {
            alert('Error')
        }
    });
}

//Удаление товара с корзины

$('#cart .modal-body').on('click', '.del-item', function (e) {
    var id = $(this).data('id');
    $.ajax({
        url: '/cart/del-item',
        data: {id: id},
        type: 'GET',
        success: function (res) {
            if (!res) alert('Такого товара нет');
            // console.log(res);
            showCart(res)
        },
        error: function () {
            alert('Error')
        }
    });
});

$('.cart-container').on('click', '.del-item', function (e) {
    var id = $(this).data('id');
    $.ajax({
        url: '/cart/del-item',
        data: {id: id},
        type: 'GET',
        success: function (res) {
            if (!res) alert('Такого товара нет');
            // console.log(res);
            $('#delete_'+id).remove();
            showCart(res)

        },
        error: function () {
            alert('Error')
        }
    });
});

function getCart() {
    $.ajax({
        url: '/cart/show',
        type: 'GET',
        success: function (res) {
            if (!res) alert('Такого товара нет');
            showCart(res)
        },
        error: function () {
            alert('Error')
        }
    });
}

//Добавление в Wishlist
$('.add-to-wishlist').on('click', function (e) {
    e.preventDefault();

    var id = $(this).data('id');

    $.ajax({
        url: '/wishlist/add',
        data: {id: id},
        type: 'GET',
        success: function (res) {
            if (!res) alert('Такого товара нет');
            // console.log(res);
            showWishlist(res)
        },
        error: function () {
            //alert('Error')
        }
    });

    return false;
});

//Добавление wishlist в модальное окно
function showWishlist(wishlist) {
    $('#wishlist .modal-body').html(wishlist);
    $('#wishlist').modal();
}


$('#filter_div .radio input[type="radio"], #filter_div .checkbox input[type="checkbox"]').on('click', function () {
    $('#submit-filter').submit();
});

$('#input-limit').on('change', function () {
    $('#pfi_limit').val(this.value);
    $('#submit-filter').submit();

    //alert( this.value );
});
$('#input-sort').on('change', function () {
    $('#pfi_sort').val(this.value);
    $('#submit-filter').submit();

    //alert( this.value );
});

$('#slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    asNavFor: '#slider-nav'
});
$('#slider-nav').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    asNavFor: '#slider-for',
    dots: false,
    centerMode: true,
    arrows: false,
    focusOnSelect: true
});

$('#slider-for .slick-slide').on('click', function () {
    $('#changeSrc').attr('src', $(this).find('img').attr('src'));
    $('#imgModalLong').modal('show');
    //console.log($(this).find('img').attr('src'));
});

$(document).ready(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 0) {
            $('#scroller').fadeIn();
        } else {
            $('#scroller').fadeOut();
        }
    });
    $('#scroller').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 400);
        return false;
    });
});

$('#button_by_one_click').on('click', function () {
    $('#top_zvor_dzvinok').find('#cb_product').val($(this).data('product_name'));
    $('#top_zvor_dzvinok').modal('show');
    //console.log($(this).data('product_name'));
});
$('#callback').on('click', function (e) {
    e.preventDefault();
    var product = $('#cb_product').val(),
        telephone = $('#cb_telephone').val();
    $.ajax({
        url: '/admin/api/v1/call-back',
        data: {'product': product, 'telephone': telephone},
        type: 'POST',
        success: function (res) {
            //console.log(res);
        },
        error: function () {
            alert('Error');
        }
    });
    $('#top_zvor_dzvinok').modal('hide');
    return false;
});

$('#button-review').on('click', function () {
    var name = $('#form-review #input-name').val(),
        review = $('#form-review #input-review').val(),
        product_id = $('#form-review input[name="product_id"]').val(),
        radio = $('#form-review input[name="rating"]:checked').val();
    $.ajax({
        url: '/admin/api/v1/comments',
        data: {'name': name, 'review': review, 'radio': radio, 'product_id': product_id},
        type: 'POST',
        success: function (res) {
            $('#review-message').show("slow");
        },
        error: function () {
            alert('Error');
        }
    });
    return false;
});

$('#pfi_mobile').on('click', function () {
    $('#filter_div').toggle().slow();
});

$('.decrease').on('click', function () {
    var id = $(this).data('id'),
        input = $('.qc-product-qantity_'+id),
        qc_total = $('.qc-total_'+id+' span'),
        x_total = $('#x-total span'),
        z_total = $('#z-total span'),
        calc = 0,
        qty = 0,
        qc_price = $('.qc-price_'+id+' span');
    input.val(parseFloat(input.val())-1);
    var total = parseFloat(qc_price.text()) * input.val();
    qc_total.text(total);
    $('.calc').each(function( index ) {
        calc += parseFloat($(this).find('span').text());
    });
    x_total.text(calc);
    z_total.text(calc);
    $('#order-sum').val(calc);
    $('.qc-product-qantity').each(function( index ) {
        qty += parseFloat($(this).val());
    });
    $('#order-qty').val(qty);
    // console.log(calc);
    // console.log(qc_total.text());
    // console.log(qc_price.text());
    // console.log(input.val());
});

$('.increase').on('click', function () {
    var id = $(this).data('id'),
        input = $('.qc-product-qantity_'+id),
        qc_total = $('.qc-total_'+id+' span'),
        x_total = $('#x-total span'),
        z_total = $('#z-total span'),
        calc = 0,
        qty = 0,
        qc_price = $('.qc-price_'+id+' span');
    input.val(parseFloat(input.val())+1);
    var total = parseFloat(qc_price.text()) * input.val();
    qc_total.text(total);
    $('.calc').each(function( index ) {
        calc += parseFloat($(this).find('span').text());
    });
    x_total.text(calc);
    z_total.text(calc);
    $('#order-sum').val(calc);
    $('.qc-product-qantity').each(function( index ) {
        qty += parseFloat($(this).val());
    });
    $('#order-qty').val(qty);
    // console.log(calc);
    // console.log(qc_total.text());
    // console.log(qc_price.text());
    // console.log(input.val());
});

$('.qc-product-qantity').on('input', function () {
    var id = $(this).data('id'),
        input = $('.qc-product-qantity_'+id),
        qc_total = $('.qc-total_'+id+' span'),
        x_total = $('#x-total span'),
        z_total = $('#z-total span'),
        calc = 0,
        qty = 0,
        qc_price = $('.qc-price_'+id+' span');
    var total = parseFloat(qc_price.text()) * input.val();
    qc_total.text(total);
    $('.calc').each(function( index ) {
        calc += parseFloat($(this).find('span').text());
    });
    x_total.text(calc);
    z_total.text(calc);
    $('#order-sum').val(calc);
    $('.qc-product-qantity').each(function( index ) {
        qty += parseFloat($(this).val());
    });
    $('#order-qty').val(qty);
    // console.log(calc);
    // console.log(qc_total.text());
    // console.log(qc_price.text());
    // console.log(input.val());
});

$('#npradio').on('click', function () {
    if ($(this).is(':checked')){
        $('#np').show(1000);
    }
});
$('#pickup').on('click', function () {
    if ($(this).is(':checked')){
       $('#np').hide(1000);
    }
});


$('#product-category #input-limit').on('change', function () {
    $('#pfi_limit').val(this.value);
    $('#submit-filter').submit();
    //alert( this.value );
});
$('#product-category #input-sort').on('change', function () {
    $('#pfi_sort').val(this.value);
    $('#submit-filter').submit();
});
$('#product-category #filter_div .radio input[type="radio"],#product-category #filter_div .checkbox input[type="checkbox"]').on('click', function () {
    $('#submit-filter').submit();
});
$('#product-category .reset-radio').on('click', function () {
    var id = $(this).data("id");
    $('#delete_' + id + '').removeAttr('checked');
    $('#submit-filter').submit();
});
$('#product-category .reset-checkbox').on('click', function () {
    var id = $(this).data("id");
    $('#delete_' + id + '').removeAttr('checked');
    $('#submit-filter').submit();
});
$('#product-category #reset').on('click', function () {
    $('input').removeAttr('checked');
    $('#submit-filter').submit();
});