<?php
error_reporting(E_ALL);
session_start();
ob_start();

include '/MysqlConnection.php';
include './daoclass/Login.php';

$filter_input_array = filter_input_array(INPUT_POST);
$btnLogin = $filter_input_array["btnLogin"];
if ($btnLogin == "Login") {
    $response = Login::loginToRoundWrap($filter_input_array);
}
?>
<!DOCTYPE html>
<html
    lang="en"
    class="light-style customizer-hide"
    dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="horizontal-menu-template"
    >
    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
        <title>Login</title>

        <meta name="description" content="" />
        <link rel="icon" type="image/x-icon" href="assets/img/pages/fevicon.png" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet"/>

        <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
        <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css" />
        <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />
        <link rel="stylesheet" href="assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="assets/css/demo.css" />
        <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
        <link rel="stylesheet" href="assets/vendor/libs/typeahead-js/typeahead.css" />
        <link rel="stylesheet" href="assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />
        <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css" />
        <script src="assets/vendor/js/helpers.js"></script>
        <script src="assets/vendor/js/template-customizer.js"></script>
        <script src="assets/js/config.js"></script>
    </head>

    <body>
        <div class="authentication-wrapper authentication-cover">
            <div class="authentication-inner row m-0">
                <div class="d-none d-lg-flex col-lg-7 col-xl-8 align-items-center">
                    <div class="flex-row text-center mx-auto" style="border:solid 1px gray;box-shadow: 5px 10px #888888;">
                        <img src="assets/img/pages/login-light.jpg" alt="Auth Cover Bg color" width="900" class="img-fluid authentication-cover-img"/>
                        <div class="mx-auto">
                            <h1>Manufacturer of Cabinet Doors</h1>
                            <h4><i>Redefining Excellence in Door craftsmanship</i></h4>
                            <br/>
                        </div>
                    </div>
                </div>
                <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-5 p-4" style="border-left: solid 1px rgb(220,200,200)">
                    <div class="w-px-400 mx-auto">
                        <!-- Logo -->
                        <div class="app-brand mb-4">
                            <a href="login.php" class="app-brand-link gap-2 mb-2">
                                <span class="app-brand-logo demo">
                                    <img src="assets/img/pages/fevicon.png" style="width: 100%">
                                </span>
                                <span class="app-brand-text demo h3 mb-0 fw-bold">Welcome to RoundWrap! 👋</span>
                            </a>
                        </div>
                        <p class="mb-4">Please sign-in to your account and start the adventure</p>

                        <form id="formAuthentication" class="mb-3" method="POST">
                            <div class="mb-3">
                                <label for="securecode" class="form-label">Security Code</label>
                                <input type="text" class="form-control" id="securecode" name="securecode" placeholder="Enter security code" maxlength="8" autofocus/>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email or Username</label>
                                <input type="email" class="form-control" id="username" name="username" placeholder="Enter your username"/>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"/>
                            </div>
                            <p style="color: red"><?php echo $response["error"][0] ?></p>
                            <input type="submit" name="btnLogin" id="btnLogin" value="Login" class="btn btn-primary d-grid w-100"/>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <script src="assets/vendor/libs/jquery/jquery.js"></script>
        <script src="assets/vendor/libs/popper/popper.js"></script>
        <script src="assets/vendor/js/bootstrap.js"></script>
        <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="assets/vendor/libs/hammer/hammer.js"></script>
        <script src="assets/vendor/libs/i18n/i18n.js"></script>
        <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
        <script src="assets/vendor/js/menu.js"></script>
        <script src="assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>
        <script src="assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>
        <script src="assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/validations/login-validation.js"></script>
    </body>
</html>
