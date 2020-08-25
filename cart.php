<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="mycart">
                <h6>My Cart</h6>
            </div>
            <hr>
            <div id="cart-elements"></div>
        </div>

        <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
            <div class="pt-4">
                <h6>PRICE DETAILS</h6>
                <hr>
                <div class="row price-details">
                    <div class="col-md-6">
                        <?php
                        //if (isset($_SESSION['cart'])) {
                        //echo "<h6>Price ($_SESSION["cart"] items)</h6>";
                        //} else {
                        echo "<h6>Price (0 items)</h6>";
                        // }
                        ?>
                    </div>
                </div>
                <div id="total">
                </div>
            </div>

        </div>
    </div>

    <script>
        $.ajax({
            type: "GET",
            url: "php/getCartElements.php"
        }).then(function(data) {
            var tmp = JSON.parse(data);
            document.getElementById("cart-elements").innerHTML = tmp["HTML"];
            document.getElementById("total").innerHTML = "Total: " + tmp["total"] + "€";
        });
    </script>