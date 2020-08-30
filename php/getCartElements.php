<?php
require_once 'DBHandler.php';

class getCartElementsResponse
{
    public $total = 0;
    public $HTML = "<div class='cart-element'><h1>Your cart is empty!</h1></div>";
    public $count = 0;
}
$getCartElementsResponse = new getCartElementsResponse();
$DBHandler = new DBHandler();

if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];

    $sql = "SELECT cart.idCart, cart.TicketQuantity, event.idEvent, event.Name, event.Price, event.TicketNumber, event.Image, user.Username, image.Description FROM cart 
    INNER JOIN event ON cart.Event_idEvent = event.idEvent 
    INNER JOIN user ON cart.User_idUsers = user.idUsers 
    INNER JOIN image ON image.Event_idEvent = event.idEvent 
    WHERE cart.User_idUsers = '$userid' AND isAcquired = 0";
    $result = $DBHandler->select($sql);

    if ($result) {
        $counts = array_map('count', $result);
        if (count($counts) != 0) {
            $getCartElementsResponse->count = count($counts);
            $getCartElementsResponse->HTML = "";

            foreach ($result as $row) {
                $getCartElementsResponse->total += $row["Price"] * $row["TicketQuantity"];
                $getCartElementsResponse->HTML .= '
                <div class="border rounded">
                    <div class="bg-white">
                        <div class="product row px-3">
                            <div class="col-md-2 py-3">
                                <img src="' . $row["Image"] . '" alt="' . $row["Description"] . '" class="img-fluid">
                            </div>
                            <div class="col-md-7 py-3">
                                <h5 class="pt-2">' . $row["Name"] . '</h5>
                                <small class="text-secondary">Organizer: ' . $row["Username"] . '</small>
                                <h6 class="pt-4"><b>Available Quantity: </b>' . $row["TicketNumber"] . '</h6>
                                <h6 class=""><b>Price: </b>' . $row["Price"] . '€</h6>
                            </div>
                            <div class="col-md-3 py-4">
                                <h5>Partial Price: ' . $row["Price"] * $row["TicketQuantity"] . '€</h5>
                                <div class="px-3">
                                    <button type="button" class="btn bg-light border rounded-circle" onClick="decreaseQuantity(this)" data-idCart="' . $row["idCart"] . '" data-maxQuantity="' . $row["TicketNumber"] . '"><i class="fas fa-minus"></i></button>
                                    <input type="text" class="form-control w-25 d-inline" value="' . $row["TicketQuantity"] . '" data-idCart="' . $row["idCart"] . '" data-maxQuantity="' . $row["TicketNumber"] . '" onChange="updateQuantity(this)">
                                    <button type="button" class="btn bg-light border rounded-circle" onClick="increaseQuantity(this)" data-idCart="' . $row["idCart"] . '" data-maxQuantity="' . $row["TicketNumber"] . '"><i class="fas fa-plus"></i></button>
                                    <div class="py-2">
                                        <div class="px-4">
                                            <button type="submit" class="btn btn-danger mx-2" name="remove" onClick="removeProduct(this)" data-idCart="' . $row["idCart"] . '" data-idProduct="' . $row["idEvent"] . '">Remove</button>
                                        </div>
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
