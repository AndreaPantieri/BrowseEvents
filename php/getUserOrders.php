<?php
require_once 'DBHandler.php';

class getUserOrdersResponse
{
    public $total = 0;
    public $HTML = "<div class='cart-element'><h1>You haven't bought anything!</h1></div>";
}
$getUserOrdersResponse = new getUserOrdersResponse();
$DBHandler = new DBHandler();

if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];

    $sql = "SELECT cart.TicketQuantity, cart.Date, event.idEvent, event.Name, event.Price, event.Image, user.Username, image.Description FROM cart 
    INNER JOIN event ON cart.Event_idEvent = event.idEvent 
    INNER JOIN user ON cart.User_idUsers = user.idUsers 
    INNER JOIN image ON image.Image = event.Image 
    WHERE cart.User_idUsers = '$userid' AND isAcquired = 1
    ORDER BY cart.Date DESC";
    $result = $DBHandler->select($sql);

    if ($result) {
        $counts = array_map('count', $result);

        if (count($counts) != 0) {
            $getUserOrdersResponse->HTML = "";

            foreach ($result as $row) {
                $getUserOrdersResponse->total += $row["Price"] * $row["TicketQuantity"];
                $getUserOrdersResponse->HTML .= '
                <div class="border rounded">
                    <div class="bg-white">
                        <div class="row px-3">
                            <div class="col-md-2 py-3">
                                <img src="' . $row["Image"] . '" alt="' . $row["Description"] . '" class="img-fluid">
                            </div>
                            <div class="col-md-7 py-3">
                                <h5 class="pt-2">' . $row["Name"] . '</h5>
                                <small class="text-secondary">Organizer: ' . $row["Username"] . '</small>
                                <h6 class="pt-2"><b>Price: </b>' . $row["Price"] . '€</h6>
                                <h6><b>Quantity: </b>' . $row["TicketQuantity"] . '</h6>
                                <h6><b>Acquired in date: </b>' . $row["Date"] . '</h6>
                                
                            </div>
                            <div class="col-md-3 py-4">
                                <h5 id="ordertotalprice">Total Price: ' . $row["Price"] * $row["TicketQuantity"] . '€</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="py-2"></div>';
            }
        }
    }
}
echo json_encode($getUserOrdersResponse);
