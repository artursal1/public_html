<?php

class Contr extends Model {

    public function changeAnswer($qid, $answer) {
        
        $this->setAnswer($qid, $answer);
        // $this-setAction($_SESSION['uid'], $qid, "submit", $answer);
        $this->setAction($_SESSION['uid'], $qid, "submit", $answer, date("Y-m-d H:i:s"));

    }

    public function login($uid, $pwd) {

        $user = $this->getUser($uid);
        if($user['pwd'] == $pwd) {
            return true;
        }

    }

}