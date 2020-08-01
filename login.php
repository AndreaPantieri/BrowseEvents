<?php include('./php/addUser.php'); ?>

<!-- login -->
<div>
    <form id="loginForm" action="php/checkLogin.php" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div h1>Login</h1>
                        <hr class="mb-3">

                        <!-- username -->
                        <label for="user"><b>Username:</b></label>
                        <input type="text" class="form-control" id="user" name="user" placeholder="Username" required />

                        <!-- password -->
                        <label for="password"><b>Password:</b></label>
                        <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password" required />

                        <!-- reminder check-->
                        <input type="checkbox" class="form-control" id="reminder" name="reminder">
                        <label for="reminder">Keep me signed in</label>

                        <hr class="mb-3">
                        <button type="submit" class="btn btn-primary" id="login" onclick="checkLogin();">Login</button>
                    </div>
                </div>
            </div>
    </form>
</div>

<p><br>Don't have an account yet?</br></p>

<!-- registration -->
<div>
    <form id="signupForm" action="base.php" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div h1>Create an account</h1>
                        <hr class="mb-3">

                        <!-- first name -->
                        <label><b>First name:</b></label>
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" value="<?php if (isset($_POST['data'])) echo $firstname; ?>" required />

                        <!-- last name -->
                        <label><b>Last name:</b></label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" value="<?php if (isset($_POST['data'])) echo $lastname; ?>" required />

                        <!-- username -->
                        <div <?php if (isset($name_error)) : ?> class="form_error" <?php endif ?>>
                            <label><b>Username:</b></label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php if (isset($_POST['data'])) echo $username; ?>" required />
                            <?php if (isset($name_error)) : ?>
                                <span><?php echo $name_error; ?></span>
                            <?php endif ?>
                        </div>

                        <!-- email -->
                        <label><b>Email address:</b></label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?php if (isset($_POST['data'])) echo $email; ?>" required />

                        <!-- password -->
                        <label><b>Password:</b></label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />

                        <!-- password confirmation -->
                        <label><b>Repeat your password:</b></label>
                        <input type="password" class="form-control" id="passwordrepeat" name="passwordrepeat" placeholder="Password" required />

                        <!-- organizer check -->
                        <input type="checkbox" class="form-control" id="organizer" name="organizer">
                        <label for="organizer">I'm an organizer</label>

                        <hr class="mb-3">
                        <button type="submit" class="btn btn-primary" id="register" onclick="checkRegistration();">Register</button>
                    </div>
                </div>
            </div>
    </form>
</div>
</div>

<!-- warnings definition -->
<div id="missingFields" class="hidden text-danger">
    <p>Username must be at least 5 characters long, password must be at least 8 characters long. Check also if passwords correspond!</p>
</div>

<!-- login/registration scripts -->
<script>
    function checkRegistration() {

        const USERMINLENGTH = 5;
        const PASSMINLENGTH = 8;

        if ($("#username").val().length < USERMINLENGTH || $("#password").val().length < PASSMINLENGTH || $("#password").val() == $("#passwordrepeat").val()) {
            $("#missingFields").removeClass("hidden");
            die();
        } else {
            $("#missingFields").addClass("hidden");
            $.ajax({
                type: 'POST',
                url: './php/addUser.php',
                data: 'data=true'
            });
            $("#signupForm").submit();
        }
    }

    function checkLogin() { //DA MIGLIORARE
        $.ajax({
            type: 'POST',
            url: './php/checkLogin.php',
            data: 'loginData=true'
        });
    }
</script>