
$(document).ready(function() {

    $('.size').val($('.size option:first').val());

    $('.size').change(function(){

        //console.log($(this).children('option:selected').val());
        var id = $(this).children('option:selected').data('price-id');
        var price = $(this).children('option:selected').data('price-price');

        addPrice(id, price, $(this));
        addBuyButton(id, $(this));

    });


    $('.quantity-right-plus').click(function(e){

        var quantity = 1;
        var quantity_element = $(this).closest('ul').find('#quantity');
        var size_element = $(this).closest('ul').find('.size');
        var id = $(this).closest('ul').find('#price').data('price-id');
        // Stop acting like a button
        e.preventDefault();
        /** Get the field name
         * If input with id = `quantity` not found
         * then set quantity to 1
         */

        if(quantity_element.length){
            quantity = parseInt(quantity_element.val());
        }


        // Increment if quantity is smaller than 20
        // Max 20 pizza
        if(quantity < 20) {
            quantity_element.val(quantity + 1);
            if(size_element.length) {
               id = size_element.children('option:selected').data('price-id');
            }

            addBuyButton(id,quantity_element);
        }

    });

    $('.quantity-left-minus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field
        var quantity = 1;
        var id = $(this).closest('ul').find('#price').data('price-id');
        var quantity_element = $(this).closest('.input-group').find('#quantity');
        var size_element = $(this).closest('ul').find('.size');
        console.log(quantity_element);
        /**
         * If quantity input found get his value
         * else quantity = 1
         */
        if(quantity_element.length) {
            quantity = parseInt(quantity_element.val());

        }

        // Decrement if quantity is bigger than 1
        // Need at least 1 pizza
        if(quantity>1){
            quantity_element.val(quantity - 1);
            if(size_element.length) {
                id = size_element.children('option:selected').data('price-id');
            }
            addBuyButton(id,quantity_element);
        }
    });
});

function addPrice(id, price, ele) {
    var priceHtml = '<li id="price" class="list-group-item"  data-price-id="' + id + '"><b>' + price + ' Kč</b></li>';
    /* Second Option to remove price <li>
     if($(this).parent().nextAll('#price').length) {
     $(this).parent().nextAll('#price').remove();
     }
     */
    if(ele.closest('ul').find('#price').length) {
        ele.closest('ul').find('#price').remove();
    }
    ele.parent().after(priceHtml);
}
function addBuyButton(id, ele) {
    console.log(id);
    if(ele.closest('ul').find('#addToCart').length) {
        ele.closest('ul').find('#addToCart').remove();
    }
    var addToCartLink = $('#products').data('add-to-cart-link');
    var quantity = ele.closest('ul').find('#quantity').val();
    var buyHtml = '<li id="addToCart" class="list-group-item text-center"><a class="btn btn-primary" href="' + addToCartLink + '/' + id + '/'+ quantity + '">Koupit</a></li>';
    ele.closest('ul').append(buyHtml);
}
