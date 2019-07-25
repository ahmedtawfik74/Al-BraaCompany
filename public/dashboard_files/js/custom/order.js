$(document).ready(function () {
    //add product to list
    $('.add-product-btn').on('click',function (e) {
       e.preventDefault();
       var product_id=$(this).data('id');
       var product_name=$(this).data('name');
       var product_price=$.number($(this).data('price'),2);
        $(this).removeClass('btn-success').addClass('btn-default disabled');

        var html=
            `<tr>
                <td>${product_name}</td>
                <td><input class="form-control input-sm product-quantity" data-price="${product_price}" name="products[${product_id}][quantity]" type="number" value="1" min="1"></td>
                <td class="product-price">${product_price}</td>
                <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${product_id}"><span class="fa fa-trash"></span></button></td>
            </tr>`
        ;
        $('.order-list').append(html);
        calculateTotal();
    });//add product to list
    //disabled body to prevent default
    $('body').on('click','.disabled',function(e){
        e.preventDefault();
    });//end of disabled body to prevent reload page
    //remove from order
    $('body').on('click','.remove-product-btn',function(e){
        e.preventDefault();
        var id=$(this).data('id');
        $(this).closest('tr').remove();
        $('#product-' + id).removeClass('btn-default disabled').addClass('btn-success');
        calculateTotal();
    });
    //increase quantity
    $('body').on('keyup change','.product-quantity',function(){
        var quantity=parseFloat($(this).val().replace(/,/g,''));
        var unitPrice=parseFloat($(this).data('price').replace(/,/g,''));
        $(this).closest('tr').find('.product-price').html($.number(quantity * unitPrice,2));
        calculateTotal();

    });
    //list all order products
    $('.order-products').on('click', function(e) {
        e.preventDefault();
        $('#loading').css('display', 'flex');
        var url = $(this).data('url');
        var method = $(this).data('method');
        $.ajax({
            url: url,
            method: method,
            success: function(data) {
                $('#loading').css('display', 'none');
                $('#order-product-list').empty();
                $('#order-product-list').append(data);
            }
        })
    });//end of order products click
    $(document).on('click','.print-btn',function(){
        $('#print-area').printThis();
    });
});//end of ready function
function calculateTotal(){
    var price=0;
    $('.order-list .product-price').each(function(index){
        price +=parseFloat($(this).html().replace(/,/g,''));
    })
    $('.total-price').html($.number(price,2));
    if(price > 0 ){
        $('#add-order-form-btn').removeClass('disabled');
    }else{
        $('#add-order-form-btn').addClass('disabled');

    }
}//end of function calc total