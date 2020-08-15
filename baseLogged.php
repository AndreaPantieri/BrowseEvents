<?php
    require_once './php/DBHandler.php';
?>

<!-- Topbar -->
<div id="topbar">
    <div class="flexColumnCenter">
        <svg width="2.5em" height="2.5em" viewBox="0 0 16 16" class="bi bi-list clickable" fill="currentColor" xmlns="http://www.w3.org/2000/svg" onclick="openSlideMenu()">
          <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/>
        </svg>
    </div>
    
    <div>
        <h1 id="title">Browse Events</h1>
        <?php
            if(!isMobile()){
                echo "<p style=\"text-align:center;\">Browse all events nearby you!</p>";
            }
        ?>
    </div>
    
    <!-- Search Bar -->
    <div id="searchbar">
        <div>
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z"/>
              <path fill-rule="evenodd" d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z"/>
            </svg>
            <input id="searchevent" type="text" name="searchevent" placeholder="Search event">
        </div>
    </div>
    
    <div id="rightIconMenu">
        <!-- My account-->
        <div id="icon_myaccount" class='flexColumnCenter'>
            <svg width="2.5em" height="2.5em" viewBox="0 0 16 16" class="bi bi-person-circle clickable" fill="currentColor" xmlns="http://www.w3.org/2000/svg" onclick="clickMyAccount()">
              <path d="M13.468 12.37C12.758 11.226 11.195 10 8 10s-4.757 1.225-5.468 2.37A6.987 6.987 0 0 0 8 15a6.987 6.987 0 0 0 5.468-2.63z"/>
              <path fill-rule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
              <path fill-rule="evenodd" d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zM0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8z"/>
            </svg>
        </div>

        <?php
            if($type_account == 1 || $type_account == 2){
                echo '<!-- Create new event-->
        <div id="icon_newevent" class=\'flexColumnCenter\'>
            <svg width="2.5em" height="2.5em" viewBox="0 0 16 16" class="bi bi-plus-circle-fill clickable" fill="currentColor" xmlns="http://www.w3.org/2000/svg" onclick="clickNewEvent()">
              <path fill-rule="evenodd" d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4a.5.5 0 0 0-1 0v3.5H4a.5.5 0 0 0 0 1h3.5V12a.5.5 0 0 0 1 0V8.5H12a.5.5 0 0 0 0-1H8.5V4z"/>
            </svg>
        </div>

        <!-- Manage events-->
        <div id="icon_manageevents" class=\'flexColumnCenter\'>
            <svg width="2.5em" height="2.5em" viewBox="0 0 16 16" class="bi bi-pencil-square clickable" fill="currentColor" xmlns="http://www.w3.org/2000/svg" onclick="clickManageEvents()">
              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
            </svg>
        </div>';
            }
        ?>

        <!-- Notifications -->
        <div class="btn-group" id="notifications" style="background-color: inherit; color: inherit;">
            
                <div id="icon_notifications" class='flexColumnCenter'>
                    <button style="background-color: inherit; color: inherit; border:0;" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="clickNotifications()">
                    <svg width="2.5em" height="2.5em" viewBox="0 0 16 16" class="bi bi-bell clickable" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                      <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2z"/>
                      <path fill-rule="evenodd" d="M8 1.918l-.797.161A4.002 4.002 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4.002 4.002 0 0 0-3.203-3.92L8 1.917zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5.002 5.002 0 0 1 13 6c0 .88.32 4.2 1.22 6z"/>
                    </svg>
                    </button>
                    <div id="dropdown-notifications" class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <button class="dropdown-item" type="button">Action</button>
                        <button class="dropdown-item" type="button">Another action</button>
                        <button class="dropdown-item" type="button">Something else here</button>
                    </div>
                </div>
            
            
        </div>
        

        <!-- Cart -->      
        <div id="icon_cart" class="flexColumnCenter">
            <svg width="2.5em" height="2.5em" viewBox="0 0 16 16" class="bi bi-cart4 clickable" fill="currentColor" xmlns="http://www.w3.org/2000/svg" onclick="clickCart()">
              <path fill-rule="evenodd" d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5zM3.14 5l.5 2H5V5H3.14zM6 5v2h2V5H6zm3 0v2h2V5H9zm3 0v2h1.36l.5-2H12zm1.11 3H12v2h.61l.5-2zM11 8H9v2h2V8zM8 8H6v2h2V8zM5 8H3.89l.5 2H5V8zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0zm9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2zm-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0z"/>
            </svg>
        </div>
    </div>
    

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

    function clickNotifications(e){
        includeMainContent("notifications.php");
    }

    function clickCart(){
        includeMainContent("cart.php");
    }

    function openSlideMenu(){
        var displayValue = "none";
        if(document.getElementById("slidemenu").style.display === displayValue){
            document.getElementById("slidemenu").style.display = "inline-block";
        }
        else{
            document.getElementById("slidemenu").style.display = displayValue;
        }
    }

    $("#dropdownMenu2").addEventListener('click', checkNotification);
</script>