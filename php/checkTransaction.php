<?php
require_once 'DBHandler.php';

class checkTransactionsResponse
{
    public $status = false;
    public $status2 = false;
    public $status3 = false;
}
$checkTransactionsResponse = new checkTransactionsResponse();
$DBHandler = new DBHandler();

if (isset($_SESSION["userid"])) {
    $userid = $_SESSION["userid"];

    $sql = "SELECT Event_idEvent, TicketQuantity, event.TicketNumber FROM cart INNER JOIN event ON cart.Event_idEvent = event.idEvent WHERE cart.User_idUsers = '$userid' AND isAcquired = 'false'";
    $result = $DBHandler->select($sql);
    $counts = array_map('count', $result);

    if (count($counts) != 0) {
        if ($result) {
            foreach ($result as $row) {
                if ($row["TicketQuantity"] <= $row["TicketNumber"]) {
                    $newTickets = $row["TicketNumber"] - $row["TicketQuantity"];
                    $actualEvent = $row["Event_idEvent"];

                    $sql = "UPDATE cart SET isAcquired = 1 WHERE cart.User_idUsers = '$userid' AND cart.Event_idEvent = '$actualEvent' AND isAcquired = 'false'";
                    $result = $DBHandler->genericQuery($sql);

                    if (!$result) {
                        $checkTransactionsResponse->status2 = true;
                    }

                    $sql = "UPDATE event SET TicketNumber = '$newTickets' WHERE idEvent = '$actualEvent'";
                    $result = $DBHandler->genericQuery($sql);

                    if (!$result) {
                        $checkTransactionsResponse->status2 = true;
                    }
                } else {
                    $checkTransactionsResponse->status = true;
                }
            }
        }
    } else {
        $checkTransactionsResponse->status3 = true;
    }
}
echo json_encode($checkTransactionsResponse);
