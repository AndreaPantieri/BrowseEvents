<?php include('./php/addUser.php'); ?>

<!-- login -->
<div>
    <form id="loginForm" action="php/checkLogin.php" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div>
                        <h1>Login</h1>
                    </div>
                    <hr class="mb-3">

                    <!-- username -->
                    <label for="user"><b>Username:</b></label>
                    <input type="text" class="form-control" id="user" name="user" placeholder="Username" required />

                    <!-- password -->
                    <label for="password"><b>Password:</b></label>
                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password" required />

                    <!-- reminder check-->
                    <input type="checkbox" id="reminder" name="reminder">
                    <label for="reminder">Keep me signed in</label>

                    <hr class="mb-3">
                    <button type="submit" class="btn btn-primary" id="login" onclick="checkLogin();">Login</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="container">
    <p>Don't have an account yet?</p>
</div>

<!-- registration -->
<div>
    <form id="signupForm" action="base.php" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div>
                        <h1>Create an account</h1>
                    </div>
                    <hr class="mb-3">

                    <!-- first name -->
                    <label><b>First name:</b></label>
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" value="<?php if (isset($_POST['firstname'])) echo $firstname; ?>" required />

                    <!-- last name -->
                    <label><b>Last name:</b></label>
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" value="<?php if (isset($_POST['lastname'])) echo $lastname; ?>" required />

                    <!-- username -->
                    <label><b>Username:</b></label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php if (isset($_POST['username'])) echo $username; ?>" onkeyup='checkUsername();' required />

                    <!-- email -->
                    <label><b>Email address:</b></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?php if (isset($_POST['email'])) echo $email; ?>" required />

                    <!-- password -->
                    <label><b>Password:</b></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" onkeyup='checkPassword();' required />

                    <!-- password confirmation -->
                    <label><b>Repeat your password:</b></label>
                    <input type="password" class="form-control" id="passwordrepeat" name="passwordrepeat" placeholder="Password" onkeyup='checkPassword();' required />

                    <!-- organizer check -->
                    <input type="checkbox" id="organizer" name="organizer">
                    <label for="organizer">I'm an organizer</label>

                    <hr class="mb-3">
                    <button type="button" class="btn btn-primary" id="register" onclick="checkRegistration();">Register</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- warnings definition -->
<div id="usernameWarning" class="invisible text-danger">
    <p>Username must be at least 5 characters long!</p>
</div>

<div id="passwordWarning1" class="invisible text-danger">
    <p>Password must be at least 8 characters long!</p>
</div>

<div id="passwordWarning2" class="invisible text-danger">
    <p>Passwords don't match!</p>
</div>

<!-- login/registration scripts -->
<script>
    const USERMINLENGTH = 5;
    const PASSMINLENGTH = 8;

    function checkUsername() {
        if (Number($("#username").val().length) < USERMINLENGTH) {
            $("#usernameWarning").removeClass("invisible");
        } else {
            $("#usernameWarning").addClass("invisible");
        }
    }

    function checkPassword() {
        if (Number($("#password").val().length) < PASSMINLENGTH) {
            $("#passwordWarning1").removeClass("invisible");
        } else {
            $("#passwordWarning1").addClass("invisible");
        }

        if ($("#password").val() != $("#passwordrepeat").val()) {
            $("#passwordWarning2").removeClass("invisible");
        } else {
            $("#passwordWarning2").addClass("invisible");
        }
    }

    function checkRegistration() {
        if (Number($("#username").val().length) < USERMINLENGTH ||
            Number($("#password").val().length) < PASSMINLENGTH || $("#password").val() != $("#passwordrepeat").val()) {
            die("error with form compilation"); //doesn't send anything in POST to addUser.php
        } else {
            /*$.ajax({
            type: 'POST',
            url: 'base.php',
            data: data
        });*/
            document.getElementById("signupForm").submit();

            /*swal.fire({
                'title': 'Registration success',
                'text': 'Registration success!',
                'type': 'success'
            })*/
        }
    }

    function checkLogin() {
        $.ajax({
            type: 'POST',
            url: 'php/checkLogin.php',
            data: 'loginData'
        });
    }
</script>