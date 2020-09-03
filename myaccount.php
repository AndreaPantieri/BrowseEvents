<div id="myaccount" class="mt-4">
    <div>
        <h1>My Account</h1>
    </div>
    <hr class="mb-5">
    <div class="mb-3" id="name" data-name="<?php if (isset($_SESSION["username"])) {
                                                echo $_SESSION["username"];
                                            } ?>">
        <h2>Hello <?php if (isset($_SESSION["username"])) {
                        echo $_SESSION["username"];
                    } ?>!</h2>
    </div>

    <div id="myaccountform" class="transparent-layout-white rounded border pl-3 pr-3 pt-3 pb-2">
        <!-- Admin approval organizer requests -->
        <div id="approveorganizerlabel"></div>
        <div id="adminorganizerform" class="form-inline mb-2 ">
            <div id="adminrequests" data-usertype="<?php echo $_SESSION["idUserType"]; ?>"></div>
            <div id="acceptrequestbutton"></div>
        </div>
        <!-- user form for becoming an organizer -->
        <div class="form-inline mb-2 ">
            <div id="becomeorganizerlabel"></div>
            <div id="becomeorganizerbutton" data-usertype="<?php echo $_SESSION["idUserType"]; ?>"></div>
        </div>
        <!-- change username -->
        <label><b>Change Username:</b></label>
        <div class="form-inline mb-2">
            <input type="text" class="form-control mr-2" id="username" placeholder="Insert your new username" required />
            <button type="button" class="btn btn-primary" onclick="changeUsername()">Save changes</button>
        </div>
        <div id="usernameWarning" class="text-danger"></div>
        <div id="usernameWarning2" class="text-danger"></div>
        <!-- change email address -->
        <label><b>Change e-mail address:</b></label>
        <div class="form-inline mb-2">
            <input type="email" class="form-control mr-2" id="email" placeholder="Insert your new email address" required />
            <button type="button" class="btn btn-primary" onclick="changeEmailAddress()">Save changes</button>
        </div>
        <div id="emailWarning" class="text-danger"></div>
        <!-- change password -->
        <label for="password"><b>Change Password:</b></label>
        <input type="password" class="form-control mb-1" id="oldPwd" placeholder="Insert your old password" required />
        <input type="password" class="form-control mb-2" id="newPwd" placeholder="Insert your new password" required />
        <button type="button" class="btn btn-primary" onclick="changePassword()">Save changes</button>
        <div id="passwordWarning" class="text-danger mt-2"></div>
        <div id="passwordWarning2" class="text-danger mt-2"></div>
    </div>
</div>

<script>
    if ($("#adminrequests").attr('data-usertype') == 1) {
        getOrganizerRequests();
    }
    if ($("#becomeorganizerbutton").attr('data-usertype') == 3) {
        getOrganizerFormRequest();
    }

    function getOrganizerRequests() {
        $("#approveorganizerlabel").append('<label><b>Approve organizer requests:</b></label>');
        $("#adminrequests").append('<select id="requests" class="form-control"></select>');
        $("#adminorganizerform").append('<button type="button" class="btn btn-primary ml-2" onclick="approveSelectedUser()">Approve</button>');

        $.ajax({
            type: "GET",
            url: "php/getOrganizerRequests.php"
        }).then(function(data) {
            $("#requests").append(data);
        });
    }

    function getOrganizerFormRequest() {
        $("#becomeorganizerlabel").append('<label><b>Apply to become an organizer:<b></label>');
        $("#becomeorganizerbutton").append('<button type="button" class="btn btn-success ml-3" onclick="sendOrganizerRequest()">Send request</button>');

    }

    function changeUsername() {
        var USERMINLENGTH = 5;

        if ($("#username").val() != "" && Number($("#username").val().length) >= USERMINLENGTH) {
            var newUsername = $("#username").val();
            $("#usernameWarning").html("");

            $.ajax({
                type: "POST",
                url: "php/updateUsername.php",
                data: {
                    newUsername: newUsername
                }
            }).then(function(data) {
                if (data) {
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

    function changeEmailAddress() {
        var username = $("#name").attr('data-name');
        var newEmail = $("#email").val();

        if ($("#email").val() != "") {
            $.ajax({
                type: "POST",
                url: "php/checkEmailAddress.php",
                data: {
                    newEmail: newEmail
                }
            }).then(function(data) {
                if (data) {
                    $("#emailWarning").html("This email address already exists!");
                } else {
                    $("#emailWarning").html("");
                    checkVerificationCode(username);
                }
            })
        } else {
            Swal.fire({
                icon: 'error',
                title: 'This field can\'t be empty!',
            })
        }

    }

    function changePassword() {
        var PASSMINLENGTH = 8;

        if ($("#oldPwd").val() != "" && $("#newPwd").val() != "" && Number($("#oldPwd").val().length) >= PASSMINLENGTH && Number($("#newPwd").val().length) >= PASSMINLENGTH) {
            var oldPwd = $("#oldPwd").val();
            var newPwd = $("#newPwd").val();
            $("#passwordWarning").html("");

            $.ajax({
                type: "POST",
                url: "php/updatePassword.php",
                data: {
                    oldPwd,
                    newPwd
                }
            }).then(function(data) {
                if (data) {
                    $("#passwordWarning2").html("The old password is wrong!");
                } else {
                    $("#passwordWarning2").html("");

                    let timerInterval
                    Swal.fire({
                        position: 'top-end',
                        title: 'Your password has been updated!',
                        icon: 'success',
                        html: 'You will be redirected to login page in <b></b> milliseconds.',
                        timer: 5000,
                        timerProgressBar: true,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {
                                const content = Swal.getContent()
                                if (content) {
                                    const b = content.querySelector('b')
                                    if (b) {
                                        b.textContent = Swal.getTimerLeft()
                                    }
                                }
                            }, 100)
                        },
                        onClose: () => {
                            clearInterval(timerInterval)
                        }
                    }).then((result) => {
                        includeMainContent("logout.php");
                    })
                }
            })
        } else {
            $("#passwordWarning").html("Password must be at least " + PASSMINLENGTH + " characters long!");
        }
    }

    function checkVerificationCode(username) {
        var newEmail = $("#email").val();

        Swal.fire({
            title: "Insert the confermation code we sent you via-mail",
            showCloseButton: true,
            input: "text",
        }).then((result) => {
            $.ajax({
                type: "POST",
                url: "php/getUserVerificationCode.php",
                data: {
                    username: username,
                    code: md5(result.value)
                },
                success: function(r) {
                    var tmp = JSON.parse(r);

                    if (tmp["result"]) {
                        $.ajax({
                            type: "POST",
                            url: "php/updateEmailAddress.php",
                            data: {
                                newEmail: newEmail
                            }
                        })
                        let timerInterval
                        Swal.fire({
                            position: 'top-end',
                            title: 'Your email has been updated!',
                            text: "Codes match! Now you can login in to the website",
                            icon: 'success',
                            html: 'You will be redirected to login page in <b></b> milliseconds.',
                            timer: 5000,
                            timerProgressBar: true,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                    const content = Swal.getContent()
                                    if (content) {
                                        const b = content.querySelector('b')
                                        if (b) {
                                            b.textContent = Swal.getTimerLeft()
                                        }
                                    }
                                }, 100)
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            includeMainContent("logout.php");
                        })
                    } else {
                        Swal.fire({
                            title: "Codes don't match, repeat the procedure please!",
                            icon: "error",
                        }).then(() => checkVerificationCode(username));
                    }
                },
                error: function(r) {
                    Swal.fire({
                        title: "Error!",
                        text: "Something went wrong when comunicating with our server"
                    });
                }
            });
        });
    }

    function approveSelectedUser() {
        var label = document.getElementById("approveorganizerlabel");
        var combobox = document.getElementById("requests");
        var button = document.getElementById("acceptrequestbutton");
        var userid = combobox.options[combobox.selectedIndex].getAttribute('data-userid');

        if ($("#requests").has('option').length > 0 && $("#requests").val() != "No requests to show") {
            $.ajax({
                type: "POST",
                url: "php/updateSelectedUserApproval.php",
                data: {
                    userid: userid
                }
            }).then(function(data) {
                if (data) {
                    //combobox.empty().append("<option>No requests to show</option>");
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Selected user has been approved!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    label.removeChild(label);
                    combobox.parentNode.removeChild(combobox);
                    button.parentNode.removeChild(button);
                    getOrganizerRequests();
                }
            });
        }
        /*else {
            Swal.fire({
                title: "There is nothing to approve!",
                icon: "error"
            });
        }*/
    }

    function sendOrganizerRequest() {
        Swal.fire({
            title: 'Are you sure you want to become an organizer?',
            text: 'This is not reversible. Organizers can still buy tickets and have all the functionalities of a normal user, but your account will be temporary disabled until an administrator doesn\'t approve your request.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, I want to become an organizer!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "GET",
                    url: "php/sendOrganizerRequest.php",
                }).then(function(data) {
                    if (data) {
                        let timerInterval
                        Swal.fire({
                            position: 'top-end',
                            title: 'Your request has been sent successfully!',
                            icon: 'success',
                            html: 'You will be redirected to login page in <b></b> milliseconds.',
                            timer: 5000,
                            timerProgressBar: true,
                            onBeforeOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {
                                    const content = Swal.getContent()
                                    if (content) {
                                        const b = content.querySelector('b')
                                        if (b) {
                                            b.textContent = Swal.getTimerLeft()
                                        }
                                    }
                                }, 100)
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((result) => {
                            includeMainContent("logout.php");
                        })
                    } else {
                        Swal.fire({
                            title: 'There was a problem with your request, please try again later!',
                            icon: 'error'
                        })
                    }
                })
            }
        })
    }
</script>