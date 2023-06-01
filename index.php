<?php
session_start();
ob_start();
error_reporting(0);
include './MysqlConnection.php';
foreach (glob("daoclass/*.php") as $filename) {
    include $filename;
}
$page_name = filter_input(INPUT_GET, "pagename");
$url_page_include = MysqlConnection::getPageNameFromURL($page_name);

if ($_SESSION["user"] == "") {
    header("location:logout.php");
}
if ($_SESSION["customer"]["login"] == "yes") {
    header("location:https://rmp.roundwrap.com/customer/");
}
if ($_SESSION["customerportal"] == "customerportal") {
    header("location:https://roundwrap.com");
}
?>
<!DOCTYPE html>
<html lang="en" class="light-style" dir="ltr" data-theme="theme-default" data-assets-path="assets/" data-template="horizontal-menu-template" >
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <title>RoundWrap Management Platform</title>
        <meta name="description" content="" />
        <link rel="icon" type="image/x-icon" href="assets/img/pages/fevicon.png" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Rubik:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css" />
        <link rel="stylesheet" href="assets/vendor/fonts/fontawesome.css" />
        <link rel="stylesheet" href="assets/vendor/fonts/flag-icons.css" />
        <link rel="stylesheet" href="assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
        <link rel="stylesheet" href="assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
        <link rel="stylesheet" href="assets/css/demo.css" />
        <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
        <link rel="stylesheet" href="assets/vendor/libs/typeahead-js/typeahead.css" />
        <link rel="stylesheet" href="assets/vendor/libs/apex-charts/apex-charts.css" />
        <link rel="stylesheet" href="assets/vendor/css/pages/app-invoice.css" />
        <!-- Vendors CSS -->

        <!-- Vendors CSS -->
        <link rel="stylesheet" href="assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
        <link rel="stylesheet" href="assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
        <link rel="stylesheet" href="assets/vendor/libs/datatables-select-bs5/select.bootstrap5.css" />
        <link rel="stylesheet" href="assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
        <link rel="stylesheet" href="assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css" />
        <link rel="stylesheet" href="assets/vendor/libs/datatables-fixedheader-bs5/fixedheader.bootstrap5.css" />
        <link rel="stylesheet" href="assets/vendor/css/pages/page-user-view.css" />
        <link rel="stylesheet" href="assets/vendor/libs/select2/select2.css" />


        <link rel="stylesheet" href="assets/vendor/css/pages/app-calendar.css" />
        <link rel="stylesheet" href="assets/vendor/libs/fullcalendar/fullcalendar.css" />
        <link rel="stylesheet" href="assets/vendor/libs/flatpickr/flatpickr.css" />
        <link rel="stylesheet" href="assets/vendor/libs/quill/editor.css" />
        <link rel="stylesheet" href="assets/vendor/libs/formvalidation/dist/css/formValidation.min.css" />

        <script src="assets/vendor/js/helpers.js"></script>
        <script src="assets/vendor/js/template-customizer.js"></script>
        <script src="assets/js/config.js"></script>

    </head>
    <style>
        *{
            color: black;
        }
    </style>
    <script>
        function searchinTable() {
            var input = document.getElementById("tablesearch");
            var filter = input.value.toUpperCase();
            var table = document.getElementById("mastertable");
            var trs = table.tBodies[0].getElementsByTagName("tr");
            for (var i = 0; i < trs.length; i++) {
                var tds = trs[i].getElementsByTagName("td");
                trs[i].style.display = "none";
                for (var i2 = 0; i2 < tds.length; i2++) {
                    if (tds[i2].innerHTML.toUpperCase().indexOf(filter) > -1) {
                        trs[i].style.display = "";
                        continue;

                    }
                }
            }
        }
        function searchinTableFilter2() {
            var input = document.getElementById("filter2");
            var filter = input.value.toUpperCase();
            var table = document.getElementById("mastertable");
            var trs = table.tBodies[0].getElementsByTagName("tr");
            for (var i = 0; i < trs.length; i++) {
                var tds = trs[i].getElementsByTagName("td");
                trs[i].style.display = "none";
                for (var i2 = 0; i2 < tds.length; i2++) {
                    if (tds[i2].innerHTML.toUpperCase().indexOf(filter) > -1) {
                        trs[i].style.display = "";
                        continue;

                    }
                }
            }
        }
        function chkNumericKey(event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if ((charCode >= 48 && charCode <= 57) || charCode === 46 || charCode === 45) {
                return true;
            } else {
                return false;
            }
        }
    </script>
    <body >
        <!-- Layout wrapper -->
        <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
            <div class="layout-container">
                <!-- Navbar -->

                <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="container-xxl">
                        <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
                            <a href="index.php" class="app-brand-link gap-2">
                                <img src="assets/img/pages/fevicon.png" style="width: 30px">
                                <span class="app-brand-text demo menu-text fw-bold">Roundwrap Management Platform</span>
                            </a>

                            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
                                <i class="bx bx-x bx-sm align-middle"></i>
                            </a>
                        </div>

                        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                                <i class="bx bx-menu bx-sm"></i>
                            </a>
                        </div>

                        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                            <?php include './topmenu.php'; ?>
                        </div>

                    </div>
                </nav>
                <div class="layout-page">
                    <div class="content-wrapper">
                        <!-- Menu -->
                        <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
                            <div class="container-xxl d-flex h-100">
                                <?php include './leftmenu.php'; ?>
                            </div>
                        </aside>
                        <div class="container-xxl flex-grow-1 container-p-y">
                            <?php include '' . $url_page_include . ".php"; ?>
                        </div>
                        <footer class="content-footer footer bg-footer-theme" style="background-color: white;text-align: center">
                            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                                <center>© 2020 RoundWrap Industries</center>
                            </div>
                        </footer>
                        <br/>
                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>


        <script src="assets/vendor/libs/jquery/jquery.js"></script>
        <script src="assets/vendor/libs/popper/popper.js"></script>
        <script src="assets/vendor/js/bootstrap.js"></script>
        <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="assets/vendor/libs/hammer/hammer.js"></script>
        <script src="assets/vendor/libs/i18n/i18n.js"></script>
        <script src="assets/vendor/libs/typeahead-js/typeahead.js"></script>
        <script src="assets/vendor/js/menu.js"></script>
        <script src="assets/vendor/libs/apex-charts/apexcharts.js"></script>

        <script src="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
        <script src="assets/vendor/libs/pickr/pickr.js"></script>

        <script src="assets/js/main.js"></script>

        <?php
        JavaScriptInclude::includeJsFromPage($page_name);
        ?>

        <script src="assets/vendor/libs/flatpickr/flatpickr.js"></script>
        <script src="assets/vendor/libs/pickr/pickr.js"></script>
        <script src="assets/js/forms-pickers.js"></script>
    </body>
</html>
