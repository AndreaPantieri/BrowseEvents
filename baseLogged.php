<?php
    require_once './php/DBHandler.php';
?>
<!-- Topbar -->
<div id="topbar"></div>

<!-- Search Bar -->
<div id="searchbar"></div>

<!-- Main content -->
<div id="maincontent">
    
</div>

<!-- Footbar -->
<div id="footbar"></div>

<!-- Slide Menu -->
<div id="slidemenu">
    <ol>
        <li class="subslidemenu">
            <h4>Categories</h3>
            <ol>
                <li id="concerts" class="clickable">Concerts</li>
                <li id="exhibitions" class="clickable">Exhibitions</li>
                <li id="festivals" class="clickable">Festivals</li>
            </ol>
        </li>
        <li id="my_account" class="clickable" onclick="clickMyAccount()">My account</li>
        <?php
            if($type_account == 1 || $type_account == 2){
                echo '<li id="new_event" class="clickable" onclick="clickNewEvent()">Create new event</li>
                <li id="manage_events" class="clickable" onclick="clickManageEvents()">Manage events</li>';
            }
        ?>
        <li id="my_orders" class="clickable" onclick="clickMyOrders()">My orders</li>
        <li id="notifications" class="clickable" onclick="clickNotifications()">Notifications</li>
    </ol>
</div>

<script type="text/javascript">
    function includeMainContent(filePHP){
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
               document.getElementById("maincontent").innerHTML = xhttp.responseText;
            }
        };
        xhttp.open("GET", filePHP, true);
        xhttp.send();
    }
    function clickMyAccount(){
        includeMainContent("myaccount.php");
    }

    function clickNewEvent(){
        includeMainContent("newevent.php");
    }

    function clickManageEvents(){
        includeMainContent("myevents.php");
    }

    function clickMyOrders(){
        includeMainContent("myorders.php");
    }

    function clickNotifications(){
        includeMainContent("notifications.php");
    }
</script>