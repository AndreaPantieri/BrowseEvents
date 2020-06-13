<!-- login -->
<div>
    <form>
        <fieldset>
            <legend>Login</legend>
            <!-- username -->
            <label for="user">Username:</label>
            <input type="text" id="user" name="user" placeholder="Username" />

            <!-- password -->
            <label for="password">Password:</label>
            <input type="password" id="pwd" name="pwd" placeholder="Password" />

            <!-- reminder check-->
            <input type="checkbox" id="reminder" name="reminder" value="remind">
            <label for="reminder">Keep me signed in</label>

            <button type="submit" id="login">Login</button>
        </fieldset>
    </form>
</div>

<!-- registration -->
<p>Don't have an account yet?</p>
<div>
    <form id="signupForm" action="php/addUser.php" method="POST" enctype="multipart/form-data">
        <fieldset>
            <legend>Sign in</legend>
            <!-- first name -->
            <label>First name:</label>
            <input type="text" id="firstname" name="firstname" placeholder="First name" />

            <!-- last name -->
            <label>Last name:</label>
            <input type="text" id="lastname" name="lastname" placeholder="Last name" />

            <!-- username -->
            <label>Username:</label>
            <input type="text" id="username" name="username" placeholder="Username" />

            <!-- email -->
            <label>Email address:</label>
            <input type="email" id="email" name="email" placeholder="Email address" />

            <!-- password -->
            <label>Password:</label>
            <input type="password" id="password" name="password" placeholder="Password" />

            <!-- password confirmation -->
            <label>Repeat your password:</label>
            <input type="password" id="passwordrepeat" name="passwordrepeat" placeholder="Password" />

            <!-- organizer check -->
            <input type="checkbox" id="organizer" name="organizer" value="1">
            <label for="organizer">I'm an organizer</label>

            <button type="submit" id="register" onclick="checkRegistration();">Register</button>
        </fieldset>
    </form>
</div>

<!-- errors definition -->
<div id="missingFields" class="hidden text-danger">
    <p>Not every field has been compiled correctly, username must be at least 5 characters, password must be at least 8
        characters</p>
</div>
<div id="userAlreadyExist" class="hidden text-danger">
    <p>Username already exist</p>
</div>
<div id="emailAlreadyExist" class="hidden text-danger">
    <p>Email address is already in use</p>
</div>

<!-- login/registration scripts -->
<script>

    function checkRegistration() {
        const USERMINLENGTH = 5;
        const PASSMINLENGTH = 8;

        var ok = true;
        var email = true;
        var user = true;

        if ($("#username").val().length < USERMINLENGTH) {
            ok = false;
        }
        if ($("#password").val().length < PASSMINLENGTH) {
            ok = false;
        }
        if (!ok) {
            $("#missingFields").removeClass("hidden");
        } else {
            $("#error").addClass("hidden");

            //TODO: CONTROLLA SE USER e EMAIL esistono già nel DB e se organizer è checkato, se non ci sono problemi invia il form per creare un nuovo utente

            if (user && email) {
                $("#signupForm").submit();
            }
        }

        function checkLogin() {
            //TODO
        }
    }
</script>