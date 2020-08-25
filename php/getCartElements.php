<?php
require_once 'DBHandler.php';

class getCartElementsResponse{
    public $total = 0;
    public $HTML = "<div class='cart-element'><h1>Your cart is empty!</h1></div>";
    public $count = 0;
}
$getCartElementsResponse = new getCartElementsResponse();
$DBHandler = new DBHandler();

if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];

    $sql = "SELECT cart.TicketQuantity, event.Name, event.Price, event.Image, user.Username, image.Description FROM cart 
    INNER JOIN event ON cart.Event_idEvent = event.idEvent 
    INNER JOIN user ON cart.User_idUsers = user.idUsers 
    INNER JOIN image ON image.Event_idEvent = event.idEvent 
    WHERE cart.User_idUsers = '$userid' AND isAcquired = 'false'";
    $result = $DBHandler->select($sql);

    if ($result) {
        $counts = array_map('count', $result);
        if (count($counts) != 0) {
            $getCartElementsResponse->count = count($counts);
            $getCartElementsResponse->HTML = "";

            foreach ($result as $row) {
                $getCartElementsResponse->total += $row["Price"];
                $getCartElementsResponse->HTML .= '
                <div class="border rounded">
                    <div class="row bg-white">
                        <div class="col-md-3">
                            <img src="' . $row["Image"] . '" alt="' . $row["Description"] . '" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <h5 class="pt-2">' . $row["Name"] . '</h5>
                            <small class="text-secondary">Organizer: ' . $row["Username"] . '</small>
                            <h5 class="pt-2">Price: ' . $row["Price"] . '€</h5>
                        </div>
                        <div class="col-md-5 py-3">
                            <div>
                                <button type="button" class="btn bg-light border rounded-circle"><i class="fas fa-minus"></i></button>
                                <input type="text" value="' . $row["TicketQuantity"] . '" class="form-control w-25 d-inline">
                                <button type="button" class="btn bg-light border rounded-circle"><i class="fas fa-plus"></i></button>
                                <button type="submit" class="btn btn-danger mx-2" name="remove">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }
    }
}
echo json_encode($getCartElementsResponse);
