<div class="container-fluid">
    <!-- This is the row for all the acquired events loaded dinamically -->
    <div class="row px-5">
        <div class="col-md-7">
            <div class="myorders mt-3">
                <h6>My Orders</h6>
            </div>
            <hr>
            <div id="order-elements"></div> <!-- this is where user orders are being inserted -->
        </div>
    </div>
</div>

<script>
    $(document).ready(getUserOrders);

    function getUserOrders() {
        $.ajax({
            type: "GET",
            url: "php/getUserOrders.php"
        }).then(function(data) {
            var tmp = JSON.parse(data);
            document.getElementById("order-elements").innerHTML = tmp["HTML"];
        });
    }
</script>