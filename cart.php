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
                    <div class="col-md-6" id="itemNumber">
                        <h6></h6>;
                    </div>
                </div>
                <div id="total">
                </div>
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
            if(tmp["count"] == 1) {
                document.getElementById("itemNumber").innerHTML = "Price (" + tmp["count"] + " item)";
            } else {
                document.getElementById("itemNumber").innerHTML = "Price (" + tmp["count"] + " items)";
            }     
        });
    </script>