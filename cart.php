<div class="container-fluid">
    <div class="row px-5">
        <div class="col-md-7">
            <div class="shopping-cart">
                <h6>My Cart</h6>
            </div>
            <hr>
            <div id="cart-elements"></div>
        </div>
    </div>
</div>

<script>
    includeContent("php/getCartElements.php", (r) => {
        var res = JSON.parse(r);
        var html = res["HTML"];
        document.getElementById("cart-elements").innerHTML = html;
    });
</script>