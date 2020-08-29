<div class="mt-4">
    <div>
        <h1>My Account</h1>
    </div>
    <hr class="mb-5">
    <div class="mb-4" id="name">
        <h2>Hello <?php if (isset($_SESSION["username"])) {
                        echo $_SESSION["username"];
                    } ?>!</h2>
    </div>

    <!-- change username -->
    <label for="user"><b>Change Username:</b></label>
    <div class="form-inline mb-2">
        <input type="text" class="form-control mr-2" id="username" placeholder="Insert your new username" required />
        <button type="button" class="btn btn-primary" id="changeUsername" onclick="changeUsername()">Save changes</button>
    </div>
    <div id="usernameWarning" class="text-danger"></div>
    <div id="usernameWarning2" class="text-danger"></div>
    <!-- change password -->
    <label for="password"><b>Change Password:</b></label>
    <input type="password" class="form-control mb-1" id="oldPwd" placeholder="Insert your old password" required />
    <input type="password" class="form-control mb-2" id="newPwd" placeholder="Insert your new password" required />
    <button type="button" class="btn btn-primary" id="changePassword" onclick="changePassword()">Save changes</button>
</div>

<script>
    function changeUsername() {
        var USERMINLENGTH = 5;

        if ($("#username").val() != "" && Number($("#username").val().length) >= USERMINLENGTH) {
            var newUsername = $(username).val();
            $("#usernameWarning").html("");

            $.ajax({
                type: "POST",
                url: "php/updateUsername.php",
                data: {
                    newUsername: newUsername
                }
            }).then(function(data) {
                console.log(data);
                var tmp = JSON.parse(data);
                
                if (tmp["status"]) {
                    $("#usernameWarning2").html("This username already exists!");
                } else {
                    $("#usernameWarning2").html("");
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Your username has been updated!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        } else {
            $("#usernameWarning").html("Username must be at least " + USERMINLENGTH + " characters long!");
        }


    }

    function changePassword() {

    }
</script>