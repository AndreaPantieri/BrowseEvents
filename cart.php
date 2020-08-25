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
</script>