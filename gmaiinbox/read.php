<?php

/* connect to gmail with your credentials */
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'roundwrapbackup@gmail.com'; # e.g helloworld@gmail.com
$password = 'akzpuukbfebqqelf'; # your gmail password
//Connection using Gmail’s IMAP
$inbox = imap_open($hostname, $username, $password, NULL, 1) or die('Cannot connect to Gmail: ' . print_r(imap_errors()));

set_time_limit(4000);

// Connect to gmail
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'roundwrapbackup@gmail.com';
$password = 'akzpuukbfebqqelf';

// try to connect
$inbox = imap_open($hostname, $username, $password, NULL, 1) or die('Cannot connect to Gmail: ' . print_r(imap_errors()));

/* ALL - return all messages matching the rest of the criteria
  ANSWERED - match messages with the \\ANSWERED flag set
  BCC "string" - match messages with "string" in the Bcc: field
  BEFORE "date" - match messages with Date: before "date"
  BODY "string" - match messages with "string" in the body of the message
  CC "string" - match messages with "string" in the Cc: field
  DELETED - match deleted messages
  FLAGGED - match messages with the \\FLAGGED (sometimes referred to as Important or Urgent) flag set
  FROM "string" - match messages with "string" in the From: field
  KEYWORD "string" - match messages with "string" as a keyword
  NEW - match new messages
  OLD - match old messages
  ON "date" - match messages with Date: matching "date"
  RECENT - match messages with the \\RECENT flag set
  SEEN - match messages that have been read (the \\SEEN flag is set)
  SINCE "date" - match messages with Date: after "date"
  SUBJECT "string" - match messages with "string" in the Subject:
  TEXT "string" - match messages with text "string"
  TO "string" - match messages with "string" in the To:
  UNANSWERED - match messages that have not been answered
  UNDELETED - match messages that are not deleted
  UNFLAGGED - match messages that are not flagged
  UNKEYWORD "string" - match messages that do not have the keyword "string"
  UNSEEN - match messages which have not been read yet */

// search and get unseen emails, function will return email ids
$emails = imap_search($inbox, 'ANSWERED');

$output = '';
rsort($emails);

foreach ($emails as $mail) {

    $headerInfo = imap_headerinfo($inbox, $mail);
    $overview = imap_fetch_overview($inbox, $mail, 0);
    $message = imap_fetchbody($inbox, $mail, 2);
    $output .= "over view :".($overview[0]->seen ? 'read' : 'unread') . '';
    $output .= "subject :".$headerInfo->subject . '<br/>';
    $output .= "toaddress".$headerInfo->toaddress . '<br/>';
    $output .= "date :".$headerInfo->date . '<br/>';
    $output .= "reply to :".$headerInfo->reply_to[0]->mailbox . '@' . $headerInfo->reply_to[0]->host . '<br/>';
    $output .= "reply address :".$headerInfo->reply_toaddress . '<br/>';
    $output .= 'message' . $message . '<br/>';

    //$emailStructure = imap_fetchstructure($inbox, $mail);

//    if (!isset($emailStructure->parts)) {
//        //$output .= imap_body($inbox, $mail, FT_PEEK);
//    } else {
//        
//    }
    echo $output;
    $output = '<br/><br/><br/>';
}

// colse the connection
imap_expunge($inbox);
imap_close($inbox);
