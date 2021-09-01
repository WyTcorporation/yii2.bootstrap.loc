
$("document").ready(function () {

    $('.close').on('click', function () {
        var close = $(this).data('close');
        $('#' + close).removeClass('active');
    });

    $('.background').on('click', function () {
        $('.my_modal').removeClass('active');
        $('.background').removeClass('active');
    });
});


// $('.cart-container').on('click', '.del-item', function (e) {
//     var id = $(this).data('id');
//     $.ajax({
//         url: '/cart/del-item',
//         data: {id: id},
//         type: 'GET',
//         success: function (res) {
//             if (!res) alert('Такого товара нет');
//             // console.log(res);
//             showCart(res)
//         },
//         error: function () {
//             alert('Error')
//         }
//     });
// });

// $('#search-characteristics').on('change', function(e) {
//     e.preventDefault();
//     var value = $(this).val();
//     console.log('value '+ value);
//     $.ajax({
//         type: "GET",
//         url: "/search-options",
//         context: {'id': id},
//         success: function(msg){
//             console.log('success '+ msg);
//         },
//         error: function(msg){
//             console.log('error '+ msg);
//         }
//     });
// });