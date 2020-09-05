<?php
require_once 'DBHandler.php';

class getCartElementsResponse
{
    public $total = 0;
    public $HTML = "<div class='cart-element'><h1>Your cart is empty!</h1></div>";
    public $count = 0;
    public $tmp = "";
}
$getCartElementsResponse = new getCartElementsResponse();
$DBHandler = new DBHandler();

if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];

    $sql = "SELECT cart.idCart, cart.TicketQuantity, `event`.idEvent, `event`.Name, `event`.Price, `event`.TicketNumber, `event`.Image, user.Username, image.Description FROM cart 
    INNER JOIN `event` ON cart.Event_idEvent = `event`.idEvent INNER JOIN user ON cart.User_idUsers = user.idUsers 
    INNER JOIN image ON image.Image = `event`.Image WHERE cart.User_idUsers = $userid AND isAcquired = 0";
    $result = $DBHandler->select($sql);
    $getCartElementsResponse->tmp = $sql;

    if ($result) {
        $counts = array_map('count', $result);
        if (count($counts) != 0) {
            $getCartElementsResponse->count = count($counts);
            $getCartElementsResponse->HTML = "";

            foreach ($result as $row) {
                $getCartElementsResponse->total += $row["Price"] * $row["TicketQuantity"];
                $getCartElementsResponse->HTML .= '
                <div id="' . $row["idCart"] . '" class="product border rounded">
                    <div class="bg-white">
                        <div class="row px-3">
                            <div id="product-image" class="col-md-2 py-3">
                                <img src="' . $row["Image"] . '" alt="' . $row["Description"] . '" class="img-fluid">
                            </div>
                            <div class="col-md-7 py-3">
                                <h1 class="pt-2">' . $row["Name"] . '</h1>
                                <small class="text-secondary">Organizer: ' . $row["Username"] . '</small>
                                <h2 class="pt-3"><b>Available Quantity: </b>' . $row["TicketNumber"] . '</h2>
                                <h2 class=""><b>Price: </b>' . $row["Price"] . '€</h2>
                            </div>
                            <div class="col-md-3 mt-3">
                                <h2 class="mt-1">Partial Price: ' . $row["Price"] * $row["TicketQuantity"] . '€</h2>
                                <div class="mt-3">
                                    <button type="button" style="float: left;" class="btn bg-light border rounded-circle" onClick="decreaseQuantity(this)" data-idCart="' . $row["idCart"] . '" data-maxQuantity="' . $row["TicketNumber"] . '"><i class="fas fa-minus"></i></button>
                                    <input type="text" style="min-width: 58%;" class="form-control w-25 d-inline ml-1" value="' . $row["TicketQuantity"] . '" data-idCart="' . $row["idCart"] . '" data-maxQuantity="' . $row["TicketNumber"] . '" onChange="updateQuantity(this)">
                                    <button type="button" style="float: right;" class="btn bg-light border rounded-circle" onClick="increaseQuantity(this)" data-idCart="' . $row["idCart"] . '" data-maxQuantity="' . $row["TicketNumber"] . '"><i class="fas fa-plus"></i></button>
                                </div>  
                                <div id="removebutton" class="mt-4 pb-3">
                                    <div class="ml-4">
                                        <button type="button" class="btn btn-danger" name="remove" onClick="removeProduct(this)" data-idCart="' . $row["idCart"] . '" data-idProduct="' . $row["idEvent"] . '">Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-2"></div>';
            }
        }
    }
}
echo json_encode($getCartElementsResponse);
