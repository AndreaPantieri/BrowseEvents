<div class="container-fluid">
    <!-- This is the row for all the events in cart loaded dinamically -->
    <div class="row px-5">
        <div class="col-md-7">
            <div class="mycart">
                <h6>My Cart</h6>
            </div>
            <hr>
            <div id="cart-elements"></div> <!-- this is where the events are being inserted -->
        </div>
        <!-- This is the column for price details -->
        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
            <div class="pt-4">
                <h6>PRICE DETAILS</h6>
                <hr>
                <div class="row">
                    <div class="col-md-6" id="itemNumber"></div>
                </div>
                <div id="total"></div>
                <div>
                    <button type="submit" class="btn btn-success mx-2" name="remove">Buy now</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(getCartElements);

    function getCartElements() {
        $.ajax({
            type: "GET",
            url: "php/getCartElements.php"
        }).then(function(data) {
            var tmp = JSON.parse(data);
            document.getElementById("cart-elements").innerHTML = tmp["HTML"];
            document.getElementById("total").innerHTML = "Total: " + tmp["total"] + "€";
            if (tmp["count"] == 1) {
                document.getElementById("itemNumber").innerHTML = "Price (" + tmp["count"] + " item)";
            } else {
                document.getElementById("itemNumber").innerHTML = "Price (" + tmp["count"] + " items)";
            }
        });
    }

    function decreaseQuantity(elem) {
        var parent = jQuery(elem).parent(); //prima era $(elem).closest("div"), peggiore
        var input = parent.find('input');
        var product_id = jQuery(elem).parent().attr('id'); //id of the product to update in cart
        var newQuantity = parseInt(input.val()) - 1; //new ticket quantity to set
        var maxQuantity = Number(jQuery(elem).parent().attr('value'));

        if (input.val() > 1 && input.val() <= maxQuantity) {
            $.ajax({
                type: "POST",
                url: "php/updateCartQuantity.php",
                data: {
                    product_id,
                    newQuantity
                }
            }).then(getCartElements);
        } else if (input.val() >= maxQuantity) {
            Swal.fire({
                title: "You can't buy more than the available quantity!",
                icon: "error"
            });
        }
    }

    function increaseQuantity(elem) {
        var parent = jQuery(elem).parent();
        var input = parent.find('input');
        var product_id = jQuery(elem).parent().attr('id'); //id of the product to update in cart
        var newQuantity = parseInt(input.val()) + 1; //new ticket quantity to set
        var maxQuantity = Number(jQuery(elem).parent().attr('value'));

        if (input.val() < 99 && input.val() < maxQuantity) {
            $.ajax({
                type: "POST",
                url: "php/updateCartQuantity.php",
                data: {
                    product_id,
                    newQuantity
                }
            }).then(getCartElements);
        } else if (input.val() >= 99) {
            Swal.fire({
                title: "You can't buy more than 99 of the same product!",
                icon: "error"
            });
        } else if (input.val() >= maxQuantity) {
            Swal.fire({
                title: "You can't buy more than the available quantity!",
                icon: "error"
            });
        }
    }

    function updateQuantity(elem) {
        var parent = jQuery(elem).parent();
        var input = parent.find('input');
        var product_id = jQuery(elem).parent().attr('id'); //id of the product to update in cart
        var newQuantity = Number(parent.find('input').val());
        var maxQuantity = Number(jQuery(elem).parent().attr('value'));

        if (input.val() > 0 && input.val() < 100 && input.val() <= maxQuantity) {
            $.ajax({
                type: "POST",
                url: "php/updateCartQuantity.php",
                data: {
                    product_id,
                    newQuantity
                }
            }).then(getCartElements);
        } else if (input.val() < 0 || input.val() > 100) {
            Swal.fire({
                title: "Input must be greater than 0 and lower than 99!",
                icon: "error"
            });
        } else if (input.val() >= maxQuantity) {
            Swal.fire({
                title: "You can't buy more than the available quantity!",
                icon: "error"
            });
        }
    }

    function removeProduct(elem) {
        var product_id = jQuery(elem).parent().parent().parent().attr('id');

        $.ajax({
            type: "POST",
            url: "php/removeProductFromCart.php",
            data: product_id
        }).then(getCartElements);
    }
</script>