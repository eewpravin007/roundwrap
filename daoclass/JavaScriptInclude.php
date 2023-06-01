<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of JavaScriptInclude
 *
 * @author inspiron 15
 */
class JavaScriptInclude {

    //put your code here
    //<script src="assets/js/charts-chartjs.js"></script>

    static function includeJsFromPage($page_name) {
        switch ($page_name) {
            case "workstationload_dashboard":
                echo '<script src="assets/js/charts-apex-pvc.js"></script>';
                echo '<script src="assets/js/charts-apex-lmi.js"></script>';
            case "main_dashboard":
                echo '<script src="assets/js/app-user-view-account.js"></script>';
            case "searchdisplay_customermaster":
                //echo '<script src="assets/js/charts-chartjs.js"></script>';
                //echo '<script src="assets/vendor/libs/chartjs/chartjs.js"></script>';
            case "reminders-calendar_operations" || "calendar_packingslip":
//                echo '<script src="assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js"></script>';
//                echo '<script src="assets/vendor/libs/flatpickr/flatpickr.js"></script>';
//                echo '<script src="assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js"></script>';
//                echo '<script src="assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js"></script>';
//                echo '<script src="assets/vendor/libs/fullcalendar/fullcalendar.js"></script>';
//                echo '<script src="assets/vendor/libs/moment/moment.js"></script>';
//                echo '<script src="assets/js/app-calendar-events.js"></script>';
//                echo '<script src="assets/js/app-calendar.js"></script>';
            case "":
                echo '<script src="assets/js/pvc_live_order.js"></script>';
                echo '<script src="assets/js/lami_live_order.js"></script>';
        }
    }

}
