<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/PHPClass.php to edit this template
 */

/**
 * Description of Notes
 *
 * @author inspiron 15
 */
class Notes {

    static function createNotes($primary, $data) {
        if ($primary == "") {
            MysqlConnection::insert("customer_notes", $data);
        } else {
            MysqlConnection::edit("customer_notes", $data, " id = '$primary' ");
        }
    }

    static function deleteNotes($primary) {
        MysqlConnection::delete("DELETE FROM customer_notes WHERE id = '$primary' ");
    }

    static function listOrGetNotes($type = "", $primary = "", $customer = "") {
        if ($type != "") {
            return MysqlConnection::fetchCustom("SELECT * FROM customer_notes WHERE notetype = '$type' ");
        } else if ($primary != "") {
            return MysqlConnection::fetchCustomSingle("SELECT * FROM customer_notes WHERE id = '$primary' ");
        } else {
            return MysqlConnection::fetchCustom("SELECT * FROM customer_notes WHERE cust_id = '$customer'");
        }
    }

    static function noteType($param) {
        switch ($param) {
            case "note":
                echo "Please enter detail note.";
                break;
            case "deplaynote":
                echo "Please enter detail why order get delayed ??";
                break;
            case "delete_order":
                echo "Please enter detail why you want to delete this order??";
                break;
            case "pendingprd":
                echo "Please enter detail why this order pending for production out??";
                break;
            case "pendingdel":
                echo "Please enter detail why this order pending for delivery out??";
                break;
            default:
                break;
        }
    }
    
    static function toggleButton($param) {
        switch ($param) {
            case "deplaynote":
                echo '<input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary me-2" value="CREATE NOTE">';
                echo '<input type="submit" name="btnDelete" id="btnDelete" class="btn btn-danger" value="DELETE THIS ORDER">';
                break;
            case "note":
                echo '<input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary me-2" value="CREATE NOTE">';
                break;
            case "delete_order":
                echo '<input type="submit" name="btnDelete" id="btnDelete" class="btn btn-danger" value="DELETE THIS ORDER">';
                break;
            case "pendingprd" || "pendingdel":
                echo '<input type="submit" name="btnSubmit" id="btnSubmit" class="btn btn-primary me-2" value="CREATE NOTE">';
                break;
            default:
                break;
        }
    }

}
