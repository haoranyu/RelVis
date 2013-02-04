<?php

require_once 'Email.php';

class MailUtil {

    public static function getDateMap($emailList, $field = 'to') {
        $map = array();
        foreach ($emailList as $email) {
            if (!isset($map[$email->date]))
                $map[$email->date] = 0;
            $map[$email->date]++;
        }
        return $map;
    }

    public static function getContactMap($emailList, $field = 'to') {
        $map = array();
        foreach ($emailList as $email) {
            if (!isset($map[$email->$field][$email->date]))
                $map[$email->$field][$email->date] = 0;
            $map[$email->$field][$email->date]++;
        }
        return $map;
    }

    public static function getSentMails($username, $password, $base){
        //$folder = 'Drafts';
        $folder = 'All Mail';
        $filter = 'FROM "'.$username.'"';
        return MailUtil::getMails($username, $password, $folder, $filter, $base);
    }
    
    
    public static function getReceivedMails($username, $password, $base){
        //$folder = 'Drafts';
        $folder = 'All Mail';
        $filter = 'TO "'.$username.'"';
        return MailUtil::getMails($username, $password, $folder, $filter, $base);
    }
    
    private static function getMails($username, $password, $folder, $filter, $base) {

        /* connect to gmail */
        $hostname = '{imap.gmail.com:993/imap/ssl}[Gmail]/' . $folder;

        /* try to connect */
        $inbox = imap_open($hostname, $username, $password) or die(header('Location: index.php'));

        /* grab emails */
        $filter .= ' SINCE "1 January '.$base.'"';
        $emails = imap_search($inbox, $filter);

        /* if emails are returned, cycle through each... */
        if ($emails) {
            /* put the newest emails on top */
            sort($emails);

            $emailArray = array();
            /* for every email... */
            foreach ($emails as $email_number) {
                /* get information specific to this email */
                $header = imap_headerinfo($inbox, $email_number, 0);
                //$message = imap_fetchbody($inbox, $email_number, 2);

                /* output the email header information */
                $email = new Email();
                // $output.= ($overview[0]->seen ;
                // $output.=  $overview[0]->subject ;
                if (isset($header->from[0]->mailbox) && isset($header->from[0]->host))
                    $email->from = $header->from[0]->mailbox . '@' . $header->from[0]->host;
                if (isset($header->to[0]->mailbox) && isset($header->to[0]->host))
                    $email->to = $header->to[0]->mailbox . '@' . $header->to[0]->host;
                if (isset($header->Date))
                    $email->date = (intval(date('Y', strtotime($header->Date)))-$base)*365 + intval(date('z', strtotime($header->Date)));
                //array_push($emailArray, $email);
                $emailArray[] = $email;
            }
        }
        /* close the connection */
        imap_close($inbox);
        return $emailArray;
    }

}
?>
