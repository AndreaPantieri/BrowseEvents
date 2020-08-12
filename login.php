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
        var status = "<?php echo $status; ?>";
        /* var userError = "";
        var mailError = "";

        if(userError) {
            swal.fire({
                'title': 'Registration failed!',
                'text': 'Username: ' + $("#username").val() + ' is already in use',
                'type': 'error'
            })
        }

        if(mailError) {
            swal.fire({
                'title': 'Registration failed!',
                'text': $("#email").val() + 'is already in use!',
                'type': 'error'
            })
        }*/

        if (status) {
            Swal.queue([{
                title: 'Registration success!',
                confirmButtonText: 'Ok',
                text: $("#firstname").val() + ', check the mail we sent to ' + $("#email").val() + ' to confirm your account',
                'type': 'success'
            }])

            Swal.insertQueueStep({
                title: 'Insert the confermation code we sent you via-mail',
                input: 'text'
            }).then((result) => {
                if (result.value) {
                    const answer = result.value;
                }
            })
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