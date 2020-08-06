<?php
    require_once './php/DBHandler.php';
?>
<!-- Topbar -->
<div id="topbar">
    <svg width="2.5em" height="2.5em" viewBox="0 0 16 16" class="bi bi-list clickable" fill="currentColor" xmlns="http://www.w3.org/2000/svg" onclick="openSlideMenu()">
      <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
    </svg>
    <div>
        <h1 id="title">Browse Events</h1>
        <?php
            if(!isMobile()){
                echo "<p>Browse all events nearby you!</p>";
            }
        ?>
    </div>
    
    <!-- Search Bar -->
    <div id="searchbar">
        <h3>Search</h3>
    </div>
    <?php
        if(isMobile()){
            //echo "<link rel=\"stylesheet\" href=\"css/style-mobile.css\">";
        } else {
            //echo "<link rel=\"stylesheet\" href=\"css/style-dekstop.css\">";
        }
    ?>
    <svg width="2.5em" height="2.5em" viewBox="0 0 16 16" class="bi bi-cart4" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
    </svg>

</div>



<!-- Main content -->
<div id="maincontent">
    
</div>

<!-- Footbar -->
<div id="footbar"></div>

<!-- Slide Menu -->
<div id="slidemenu" style="display: none;">
    <ol>
        <li class="subslidemenu">
            <h4>Categories</h4>
            <ol>
                <li id="concerts" class="clickable clickableSizes">Concerts</li>
                <li id="exhibitions" class="clickable clickableSizes">Exhibitions</li>
                <li id="festivals" class="clickable clickableSizes">Festivals</li>
            </ol>
        </li>
        <li id="my_account" class="clickable clickableSizes" onclick="clickMyAccount()">My account</li>
        <?php
            if($type_account == 1 || $type_account == 2){
                echo '<li id="new_event" class="clickable clickableSizes" onclick="clickNewEvent()">Create new event</li>
                <li id="manage_events" class="clickable clickableSizes" onclick="clickManageEvents()">Manage events</li>';
            }
        ?>
        <li id="my_orders" class="clickable clickableSizes" onclick="clickMyOrders()">My orders</li>
        <li id="notifications" class="clickable clickableSizes" onclick="clickNotifications()">Notifications</li>
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

    <?php
        if($type_account == 1 || $type_account == 2){
            echo 'function clickNewEvent(){
                includeMainContent("newevent.php");
            }

            function clickManageEvents(){
                includeMainContent("myevents.php");
            }';
        }
    ?>

    function clickMyOrders(){
        includeMainContent("myorders.php");
    }

    function clickNotifications(){
        includeMainContent("notifications.php");
    }

    function openSlideMenu(){
        var displayValue = "none";
        if(document.getElementById("slidemenu").style.display === displayValue){
            document.getElementById("slidemenu").style.display = "inline";
        }
        else{
            document.getElementById("slidemenu").style.display = displayValue;
        }
        
    }
</script>