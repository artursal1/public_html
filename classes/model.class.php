<?php

class Model extends Dbh {

    protected function getQuestions($pageNum=0) {
        $offset = (int)$pageNum * 50;
        $sql = "SELECT * FROM qs ORDER BY qid LIMIT 50 OFFSET ".$offset;
        $stmt = $this->connect()->query($sql);

        $results = $stmt->fetchAll();
        return $results;
    }

    protected function setAnswer($qid, $answer) {
        $sql = "UPDATE qs SET answer = ? WHERE qid = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$answer, $qid]);
    }

    protected function setAction($uid, $qid, $action, $value, $datetime) {
        $sql = "INSERT INTO user_actions(uid, qid, action, value, datetime) VALUES (?, ?, ?, ? ,?)";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$uid, $qid, $action, $value, $datetime]);
    }

    protected function getPercentage() {
        $sql = "SELECT COUNT(answer) FROM qs WHERE answer != ''";
        $stmt = $this->connect()->query($sql);

        $results = $stmt->fetch();
        return $results['COUNT(answer)'];
    }

    protected function getUser($uid) {
        $sql = "SELECT * FROM users WHERE uid = ?";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute([$uid]);

        $results = $stmt->fetch();
        return $results;
    }


    #not being used right now
    protected function findBlanks() {
        $range = range(6767, 7435);
        foreach ($range as $r) {
            $sql1 = "SELECT * FROM qs WHERE qid = ".$r;
            $stmt1 = $this->connect()->query($sql1);
            $results1 = $stmt1->fetchAll();
            if($results1[0]['qid'] == "") {
                echo $r."<br>";
            }
        }
    }

    protected function populate() {
        $sql = "SELECT DISTINCT qid FROM questions ORDER BY qid";
        $stmt = $this->connect()->query($sql);

        $results = $stmt->fetchAll();
        foreach ($results as $r) {
            $sql = "INSERT INTO qs SELECT * FROM copy_questions WHERE qid = ".$r['qid']." LIMIT 1";
            $stmt = $this->connect()->query($sql);
        }
    }



}