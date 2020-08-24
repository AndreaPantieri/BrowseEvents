<?php
require_once 'DBHandler.php';

class getCartElementsResponse
{
    public $HTML = "<div class='cart-element'><h1>Your cart is empty!</h1></div>";
}

$DBHandler = new DBHandler();
$getCartElementsResponse = new getCartElementsResponse();

if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];

    $sql = "SELECT cart.TicketQuantity, event.Name, event.Price, event.Image, user.Username, cart.Description FROM cart 
    INNER JOIN event ON cart.Event_idEvent = event.idEvent 
    INNER JOIN user ON cart.User_idUsers = user.idUsers 
    INNER JOIN image ON image.Event_idEvent  = event.idEvent 
    WHERE cart.User_idUsers = '$userid' AND isAcquired = 'false'";
    $result = $DBHandler->select($sql);

    if ($result) {
        foreach ($result as $row) {
            $HTML .= '
        <form action="cart.php" method="GET" class="cart-items">
            <div class="border rounded">
                <div class="row bg-white">
                    <div class="col-md-3">
                        <img src="$row[event.Image]" alt="$row[cart.Description]" class="img-fluid">
                    </div>
                    <div class="col-md-6">
                        <h5 class="pt-2">$row[event.Name]</h5>
                        <small class="text-secondary">$row[user.Username]</small>
                        <h5 class="pt-2">$row[event.Price]</h5>
                    </div>
                    <div class="col-md-5 py-3">
                        <div>
                            <button type="button" class="btn bg-light border rounded-circle"><i class="fas fa-minus"></i></button>
                            <input type="text" value="$row[cart.TicketQuantity]" class="form-control w-25 d-inline">
                            <button type="button" class="btn bg-light border rounded-circle"><i class="fas fa-plus"></i></button>
                            <button type="submit" class="btn btn-danger mx-2" name="remove">Remove</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>';
        }
    }
}

echo json_encode($getCartElementsResponse);
