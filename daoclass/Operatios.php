<?php

class Operatios {
    /*     * ***email operation *** */

    static function createEmailTemplate($data, $templateid) {
        if ($templateid == "") {
            return MysqlConnection::insert("tbl_email_template", $data);
        } else {
            return MysqlConnection::edit("tbl_email_template", $data, " id = '$templateid' ");
        }
    }

    static function listEmailTemplate($templateid = "") {
        if ($templateid != "") {
            return MysqlConnection::fetchCustomSingle("SELECT * FROM `tbl_email_template` WHERE id = '$templateid' ");
        } else {
            return MysqlConnection::fetchCustom("SELECT * FROM `tbl_email_template`");
        }
    }

    /*     * ***email operation *** */

    static function listReminderTemplate($templateid = "") {
        if ($templateid != "") {
            return MysqlConnection::fetchCustomSingle("SELECT * FROM `tbl_reminder_template` WHERE id = '$templateid' ");
        } else {
            return MysqlConnection::fetchCustom("SELECT * FROM `tbl_reminder_template`");
        }
    }

    static function createReminderTemplate($templateid, $data) {
        if ($templateid == "") {
            return MysqlConnection::insert("tbl_reminder_template", $data);
        } else {
            return MysqlConnection::edit("tbl_reminder_template", $data, " id = '$templateid' ");
        }
    }

    static function listEmployeeNoteTemplate($templateid = "") {
        if ($templateid != "") {
            return MysqlConnection::fetchCustomSingle("SELECT * FROM `tbl_empnote_template` WHERE id = '$templateid' ");
        } else {
            return MysqlConnection::fetchCustom("SELECT * FROM `tbl_empnote_template`");
        }
    }

    static function listEmployeeNoteTemplateSession($userid = "") {
        return MysqlConnection::fetchCustom("SELECT * FROM `tbl_empnote_template` WHERE empid = '$userid' ");
    }

    static function createEmployeeNoteTemplate($templateid, $data) {
        if ($templateid == "") {
            return MysqlConnection::insert("tbl_empnote_template", $data);
        } else {
            return MysqlConnection::edit("tbl_empnote_template", $data, " id = '$templateid' ");
        }
    }

    static function listBussinessNoteTemplate($templateid = "") {
        if ($templateid != "") {
            return MysqlConnection::fetchCustomSingle("SELECT * FROM `tbl_businessnote_template` WHERE id = '$templateid' ");
        } else {
            return MysqlConnection::fetchCustom("SELECT * FROM `tbl_businessnote_template`");
        }
    }

    static function createBussinessNoteTemplate($templateid, $data) {
        if ($templateid == "") {
            return MysqlConnection::insert("tbl_businessnote_template", $data);
        } else {
            return MysqlConnection::edit("tbl_businessnote_template", $data, " id = '$templateid' ");
        }
    }

    static function listWeeklyAgendaTemplate($templateid = "") {
        if ($templateid != "") {
            return MysqlConnection::fetchCustom("SELECT * FROM `tbl_weekly_agenda` WHERE weeknumber = '$templateid' ");
        } else {
            return MysqlConnection::fetchCustom("SELECT * FROM `tbl_weekly_agenda` ORDER BY startDate DESC ");
        }
    }

    static function createWeeklyAgendaTemplate($templateid, $data) {
        if ($templateid == "") {
            return MysqlConnection::insert("tbl_weekly_agenda", $data);
        } else {
            return MysqlConnection::edit("tbl_weekly_agenda", $data, " id = '$templateid' ");
        }
    }

}
