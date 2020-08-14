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
                    <button type="button" class="btn btn-primary" id="login" onclick="checkLogin()">Login</button>
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
    <form id="signupForm" action="php/addUser.php" method="POST" enctype="multipart/form-data">
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div>
                        <h1>Create an account</h1>
                    </div>
                    <hr class="mb-3">

                    <!-- first name -->
                    <label><b>First name:</b></label>
                    <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" value ="" required />

                    <!-- last name -->
                    <label><b>Last name:</b></label>
                    <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" value ="" required />

                    <!-- username -->
                    <label><b>Username:</b></label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value ="" onkeyup='checkUsername();' required />

                    <!-- email -->
                    <label><b>Email address:</b></label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value ="" required />

                    <!-- password -->
                    <label><b>Password:</b></label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" value ="" onkeyup='checkPassword();' required />

                    <!-- password confirmation -->
                    <label><b>Repeat your password:</b></label>
                    <input type="password" class="form-control" id="passwordrepeat" name="passwordrepeat" placeholder="Password" value ="" onkeyup='checkPassword();' required />

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
<script type="application/javascript">
    const USERMINLENGTH = 5;
    const PASSMINLENGTH = 8;

    $("#loginForm").submit(function(e){
        e.preventDefault();

        var form = $(this);
        var url = form.attr('action');

        if(!checkLogin()){
            Swal.fire({
                title: "Credentials length error!",
                icon: "error"
            });
            return;
        }

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize();
            success: function(data){
                location.reload();
            },
            error: function(data){
                Swal.fire({
                    title: "Credentials don't match error!",
                    icon: "error"
                });
            }
        });
    });

    $("#signupForm").submit(function(e){
        e.preventDefault();
        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize();
            success: function(data){
                checkCompletion(data);
            },
            error: function(data){
                $("#firstname").value = data["firstname"];
                $("#lastname").value = data["lastname"];
                $("#username").value = data["username"];
                $("#email").value = data["email"];
            }
        });
    });

    function checkLogin(){
        if(Number($("#user").val().length) < USERMINLENGTH ||
            Number($("#pwd").val().length) < PASSMINLENGTH){
            return true;
        }
        else{
            return false;
        }
    }

    

    function checkCompletion(data) {
        var status = data["status"];
        var userError = data["userError"];
        var mailError = data["mailError"];

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
                    if (result.value == 150) {
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