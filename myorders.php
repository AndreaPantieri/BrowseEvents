<div class="container-fluid w-75">
    <!-- This is the row for all the acquired events loaded dinamically -->
    <div class="row">
        <div class="col-md-9">
            <div class="mt-3">
                <h2>My Orders</h2>
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