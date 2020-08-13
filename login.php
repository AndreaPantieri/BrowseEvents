<?php include('./php/addUser.php');

/* foreach($_POST as $key => $value) {
            echo "<br />" . "{$key} = {$value}";
        } */

/*if(isset($_POST['login'])) {
    echo 'ciao';
}*/

?>

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
                    <button type="submit" class="btn btn-primary" id="login">Login</button>
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
    <form id="signupForm" action="base.php" onsubmit="display()" method="POST" enctype="multipart/form-data">
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

                    <!-- warnings definition -->
                    <div id="errorMessage" class="text-danger">
                        <p></p>
                    </div>

                    <div id="usernameWarning" class="text-danger">
                        <p></p>
                    </div>

                    <div id="passwordWarning1" class="text-danger">
                        <p></p>
                    </div>

                    <div id="passwordWarning2" class="text-danger">
                        <p></p>
                    </div>

                    <div id="userAlreadyTaken" class="text-danger">
                        <p></p>
                    </div>

                    <div id="mailAlreadyTaken" class="text-danger">
                        <p></p>
                    </div>


                    <hr class="mb-3">
                    <button type="button" class="btn btn-primary" id="register" onclick="checkRegistration();">Register</button>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- login/registration scripts -->
<script>
    const USERMINLENGTH = 5;
    const PASSMINLENGTH = 8;

    document.onload = checkCompletion();

    function checkCompletion() {
        var status = "<?php if (isset($status)) echo $status; ?>";
        var userError = "<?php if (isset($userError)) echo $userError; ?>";
        var mailError = "<?php if (isset($mailError)) echo $mailError; ?>";

        if (userError) {
            document.getElementById("userAlreadyTaken").innerHTML = "This username is already taken!";
        } else {
            document.getElementById("userAlreadyTaken").innerHTML = "";
        }

        if (mailError) {
            document.getElementById("mailAlreadyTaken").innerHTML = "This email address is already in use!";
        } else {
            document.getElementById("mailAlreadyTaken").innerHTML = "";
        }

        if (status) {
            Swal.fire({
                text: $("#firstname").val() + ', check the mail we sent to ' + $("#email").val() + ' to confirm your account',
                icon: "success",
            }).then(() => {
                Swal.fire({
                    title: "Insert the confermation code we sent you via-mail",
                    input: "text",
                }).then((result) => {
                    // get DatabaseCode
                    //var input = md5(result);
                    if (result == 150) {
                        Swal.fire({
                            title: "Successfully registered to BrowseEvents.com!",
                            text: "Codes match!",
                            icon: "success",
                        });
                    } else {
                        Swal.fire({
                            title: "Codes don't match!",
                            icon: "error",
                        });
                    }
                });
            });
        }
    }

    function checkUsername() {
        if (Number($("#username").val().length) < USERMINLENGTH) {
            document.getElementById("usernameWarning").innerHTML = "Username must be at least 5 characters long!";
        } else {
            document.getElementById("usernameWarning").innerHTML = "";
        }
    }

    function checkPassword() {
        if (Number($("#password").val().length) < PASSMINLENGTH) {
            document.getElementById("passwordWarning1").innerHTML = "Password must be at least 8 characters long!";
        } else {
            document.getElementById("passwordWarning1").innerHTML = "";
        }

        if ($("#password").val() != $("#passwordrepeat").val()) {
            document.getElementById("passwordWarning2").innerHTML = "Passwords don't match!";
        } else {
            document.getElementById("passwordWarning2").innerHTML = "";
        }
    }

    function checkRegistration() {
        if (Number($("#username").val().length) < USERMINLENGTH ||
            Number($("#password").val().length) < PASSMINLENGTH ||
            $("#password").val() != $("#passwordrepeat").val() ||
            $("#firstname").val() == "" ||
            $("#lastname").val() == "" ||
            $("#email").val() == "") {
            document.getElementById("errorMessage").innerHTML = "Some informations are not filled in!";
        } else {
            document.getElementById("errorMessage").innerHTML = "";
            document.getElementById("signupForm").submit();
        }
    }
</script>