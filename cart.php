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
        var parent = $(elem).closest("div");
        var input = parent.find('input');
        var product_id = $(elem).closest("div").attr('id'); //id of the product to update in cart
        var newQuantity = parseInt(input.val()) - 1; //new ticket quantity to set

        if (input.val() > 1) {
            $.ajax({
                type: "POST",
                url: "php/updateCartQuantity.php",
                data: {
                    product_id,
                    newQuantity
                }
            }).then(getCartElements);
        }
    }

    function inreaseQuantity(elem) {
        var parent = $(elem).closest("div");
        var input = parent.find('input');
        var product_id = $(elem).closest("div").attr('id'); //id of the product to update in cart
        var newQuantity = parseInt(input.val()) + 1; //new ticket quantity to set

        if (input.val() < 99) {
            $.ajax({
                type: "POST",
                url: "php/updateCartQuantity.php",
                data: {
                    product_id,
                    newQuantity
                }
            }).then(getCartElements);
        } else {
            Swal.fire({
                title: "You can't buy more than 99 of the same product!",
                icon: "error"
            });
        }
    }

    function updateQuantity(elem) {
        var parent = $(elem).closest("div");
        var input = parent.find('input');
        var newQuantity = parent.find('input').val();
        var product_id = $(elem).closest("div").attr('id'); //id of the product to update in cart

        if (input.val() > 0 && input.val() < 99) {
            $.ajax({
                type: "POST",
                url: "php/updateCartQuantity.php",
                data: {
                    product_id,
                    newQuantity
                }
            }).then(getCartElements);
        } else {
            Swal.fire({
                title: "Input must be greater than 0 and lower than 99!",
                icon: "error"
            });
        }
    }
</script>