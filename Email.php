<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Email
 *
 * @author Aale
 */
class Email {

    public $to;
    public $from;
    public $date;

    public function getFrom() {
        return $this->from[0]->mailbox . "@" . $this->from[0]->host;
    }
    public function getTo() {
        return $this->to[0]->mailbox . "@" . $this->to[0]->host;
    }
    
    public function printEmail() {
        echo "to=" . $this->to . " from=" . $this->from . " date=" .$this->date."<br>";
    }

}

?>
