<?php

error_reporting(0);

class Login {

    static function loginToRoundWrap($requestbody) {
        $response = array();
        Login::cleanSecureCodeTable();
        if (Login::validateCodeNumber($requestbody) == "Valid Code") {
            $username = $requestbody["username"];
            $password = md5($requestbody["password"]);
            $query = " SELECT *, "
                    . " (SELECT name FROM `generic_entry` WHERE `type` = 'usertype' AND id = um.roleName ) as user_role "
                    . " FROM user_master um "
                    . " WHERE username = '$username' "
                    . " AND password = '$password';";
            $resultset = MysqlConnection::fetchCustom($query);
            if (count($resultset) > 0) {
                $response["result"][] = $resultset[0];
                $_SESSION["user"] = $resultset[0];
                header("location:index.php");
            } else {
                $response["error"][] = "Invalid Security Code / Username / Password.";
            }
        } else {
            $response["error"][] = "Invalid Security Code / Username / Password.";
        }
        return $response;
    }

    static function validateCodeNumber($requestbody) {
        $securecode = $requestbody["securecode"];
        $query = "SELECT codenumber FROM securitycode WHERE codenumber = '$securecode' LIMIT 0,1 ";
        $resultset = MysqlConnection::fetchCustom($query);
        $codenumber = $resultset[0]["codenumber"];
        return $codenumber == "" ? "Invalid Code" : "Valid Code";
    }

    static function cleanSecureCodeTable() {
        $date_before_week_time = strtotime("-7 day");
        $date_before_week = date('Y-m-d', $date_before_week_time);
        $query = "DELETE FROM securitycode WHERE securedate <= '$date_before_week' ";
        MysqlConnection::executeQuery($query);
    }

    static function sendSecureCodeIfNotSent() {
        
    }

}

//$requestbody = array();
//$requestbody["username"] = "eew.pravin@gmail.com";
//$requestbody["password"] = md5("12345678");
//$requestbody["securecode"] = "15120142";
//$result = Login::loginToRoundWrap($requestbody);
//MysqlConnection::printResult($result);
