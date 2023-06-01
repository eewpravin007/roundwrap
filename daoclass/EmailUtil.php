<?php


class EmailUtil {

    static function sendEmail($targetemail, $attachment, $subject, $bodymatter, $title, $config = array()) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        //$mail->SMTPDebug = 2;
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->SMTPAutoTLS = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587; //587
        $mail->SMTPAuth = true;
        $mail->Username = 'roundwrapbackup@gmail.com';
        $mail->Password = 'akzpuukbfebqqelf';

        $reply_to = $config["reply_to"];
        if ($reply_to == "PVC") {
            $mail->setFrom("roundwrapbackup@gmail.com", $title);
            //$mail->addAddress("info@roundwrap.com", $title);
        } else {
            $mail->setFrom("roundwrapbackup@gmail.com", $title);
            //$mail->addAddress("orders@roundwrap.com", $title);
        }
        $mail->addAddress($targetemail, $title);
        if ($config["carban_copy"] != "") {
            $mail->addCC($config["carban_copy"], 'Copy - ' . $subject);
        }
        $mail->Subject = $subject;
        $mail->msgHTML($bodymatter);

        if (is_array($attachment)) {
            foreach ($attachment as $value) {
                $mail->addAttachment($value);
            }
        } else {
            $mail->addAttachment($attachment);
        }
        if (!$mail->send()) {
            $status = "Failed";
        } else {
            $status = "Sent";
        }
    }

    static function sendEmailCode($targetemail, $subject, $bodymatter, $title) {
        $mail = new PHPMailer;
        $mail->isSMTP();
        //$mail->SMTPDebug = 2;
        $mail->SMTPAuth = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->SMTPAutoTLS = true;
        $mail->Host = 'smtp.gmail.com'; //smtpout.secureserver.net
        $mail->Port = 587; //587
        $mail->SMTPAuth = true;
        $mail->Username = 'roundwrapbackup@gmail.com';  //info@roundwrap.com
        $mail->Password = 'akzpuukbfebqqelf'; //#######
        $mail->setFrom("roundwrapbackup@gmail.com", "RoundWrap Secure Code");

        $mail->addAddress($targetemail, $title);
        $mail->Subject = $subject;
        $mail->msgHTML($bodymatter);
        if (!$mail->send()) {
            $status = "Failed";
        } else {
            $status = "Sent";
        }
    }

}
