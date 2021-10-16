function refresh_cart(){
    $('.shopping-list').empty();
    $count = 0
    $total = 0
    if(localStorage.getItem('cart')){
        // alert('ahihhhi');
        cart = JSON.parse(localStorage.getItem('cart'));
        cart.forEach(element => {
            $total += element['quantity']*element['price']
            $count +=1
            $('.shopping-list').append(`<li>
                                            <a data-cart-id="`+element['cart_id']+`" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                            <a class="cart-img" href="`+element['link']+`"><img src="`+element['image']+`" alt="#"></a>
                                            <h4><a class="cart-name" href="`+element['link']+`">`+element['name']+`</a></h4>
                                            <p class="cart-size">Size: `+element['size']+`</p>
                                            <p class="cart-quantity">`+element['quantity']+`x - <span class="amount">`+parseInt(element['quantity']*element['price']).toLocaleString('it-IT')+` đ</span></p>
                                        </li>`)
        });
    }   
    $('.cart-total-count').text($count)
    $('.dropdown-cart-header span').text($count+' Sản phẩm')
    $('.cart-total-amount').text(parseInt($total).toLocaleString('it-IT')+' đ')
}

function pull_cart(){
    $('.tbody-cart').empty()
    $('.ship-type').empty()
    $count = 0
    $total = 0
    if(localStorage.getItem('cart')){
        cart = JSON.parse(localStorage.getItem('cart'));
        cart.forEach(element => {
            $total += element['quantity']*element['price']
            $count +=1
            $('.tbody-cart').append(`
                    <tr>
                        <td class="image" data-title="No"><img src="`+element['image']+`" alt="#"></td>
                        <td class="product-des" data-title="Description">
                            <p class="product-name"><a href="`+element['link']+`">`+element['name']+`</a></p>
                            <p class="product-des">Size: `+element['size']+`</p>
                        </td>
                        <td class="price" data-title="Price"><span>`+parseInt(element['price']).toLocaleString('it-IT')+` đ</span></td>
                        <td class="qty" data-title="Qty"><!-- Input Order -->
                            <div class="input-group">
                                <div class="button minus">
                                    <button type="button" class="btn btn-primary btn-number"  data-type="minus" data-field="quant[`+element['id']+`]">
                                        <i class="ti-minus"></i>
                                    </button>
                                </div>
                                <input type="text" cart-id = "`+element['cart_id']+`" name="quant[`+element['id']+`]" class="input-number"  data-min="1" data-max="100" value="`+element['quantity']+`">
                                <div class="button plus">
                                    <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[`+element['id']+`]">
                                        <i class="ti-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <!--/ End Input Order -->
                        </td>
                        <td class="total-amount-one-type" data-title="Total"><span>`+(element['price']*element['quantity']).toLocaleString('it-IT')+` đ</span></td>
                        <td data-cart-id="`+element['cart_id']+`" class="action remove remove-one-type" data-title="Remove"><a href="#"><i class="ti-trash remove-icon"></i></a></td>
                    </tr>`)
        });
    }
    $('span.total-amount-all').text(parseInt($total).toLocaleString('it-IT')+' đ')
    if ($total < 500000 && $total>0){
        $total += 30000;
        $('.ship-type').append(`Giao hàng toàn quốc<span>30,000 đ</span>`)
    } else if ($total>0) {
        $('.ship-type').append(`Giao hàng toàn quốc<span>Miễn phí</span>`)
    }
    $('li.last span').text(parseInt($total).toLocaleString('it-IT')+' đ')
}

function checkout(){
    $count = 0
    $total = 0
    if(localStorage.getItem('cart')){
        cart = JSON.parse(localStorage.getItem('cart'));
        cart.forEach(element => {
            $total += element['quantity']*element['price']
            $count +=1
        });
    }   
    if ($total == 0){
        window.history.back()
    }
    $('.total-amount-checkout span').text(parseInt($total).toLocaleString('it-IT')+' đ')
    if ($total>500000 && $total>0){
        $('.type-ship-checkout').text('Freeship')
    } else if ($total>0){
        $total += 30000
        $('.type-ship-checkout').text('30,000 đ')
    }
    $('.last span').text(parseInt($total).toLocaleString('it-IT')+' đ')
}