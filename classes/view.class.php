<?php

class View extends Model {

    public function showQuestions($pageNum) {

        $results = $this->getQuestions($pageNum);
        foreach($results as $result) {

            // imgs
            $imgs = explode("https://demo-exam.fa.ru/pluginfile.php/128/question/questiontext/", $result['contentHTML']);
            foreach($imgs as $i) {
                if(strpos($i, '/'.$result['qid'].'/') !== false) {
                    $ii = explode('/'.$result['qid'].'/', $i)[0];
                    $result['contentHTML'] = str_replace("https://demo-exam.fa.ru/pluginfile.php/128/question/questiontext/".$ii, "photos", $result['contentHTML']);
                    $result['contentHTML'] = str_replace("https://demo-exam.fa.ru/pluginfile.php/128/question/answer/".$ii, "photos", $result['contentHTML']);
                }
            }

            //make inputs accesible
            $result['contentHTML'] = str_replace('disabled="disabled"', '', $result['contentHTML']);
            $result['contentHTML'] = str_replace('readonly="readonly"', '', $result['contentHTML']);

            //change the NO img for text
            $result['contentHTML'] = str_replace('<img class="icon emoticon" alt="Нет" title="Нет" src="https://demo-exam.fa.ru/theme/image.php/fordson/core/1655374543/s/no">', ' НЕТ', $result['contentHTML']);
            
            //remove text "Ответ: "
            $result['contentHTML'] = str_replace('Ответ: ', '', $result['contentHTML']);

            //change attempt id for qid
            $attemptId = explode(':sequencecheck', $result['contentHTML'])[0];
            $attemptId = end(explode('name="', $attemptId));
            $result['contentHTML'] = str_replace($attemptId, 'qid'.$result['qid'].'_', $result['contentHTML']);

            $info_style = "";
            if($result['answer'] !== "") {
                $info_style = "background: #afffc8;";
                //insert answer to input
                $result['contentHTML'] = str_replace('id="qid'.$result['qid'].'_answer"', 'id="qid'.$result['qid'].'_answer" value="'.$result['answer'].'"', $result['contentHTML']);
            
                //get multianswers if there are any
                $multiAnswers = "";
                if(strpos($result['answer'], ";;;") !== false) {
                    $multiAnswers = explode(";;;", $result['answer']);
                } else if(strpos($result['contentHTML'], "prompt") !== false) {
                    $multiAnswers = "0";
                }
            }

            //inputs
            $inputs = explode("<input", $result['contentHTML']);
            foreach($inputs as $inp) {

                //get input id
                $inpId = explode('id="', $inp)[1];
                $inpId = explode('"', $inpId)[0];

                //click on label selects input
                $result['contentHTML'] = str_replace('id="'.$inpId.'_label"', 'id="'.$inpId.'_label" onclick="$(`#'.$inpId.'`).prop(`checked`, true);"', $result['contentHTML']);

                //check correct checkboxes
                if($result['answer'] !== "") {
                    if($multiAnswers == "0") {
                        if(strpos($inp, $result['answer']) !== false) {
                            $result['contentHTML'] = str_replace($inpId.'"', $inpId.'" checked="true"', $result['contentHTML']);
                        }
                    } else {
                        foreach($multiAnswers as $m) {
                            if(strpos($inp, $m) !== false) {
                                $result['contentHTML'] = str_replace($inpId.'"', $inpId.'" checked="true"', $result['contentHTML']);
                            }
                        }
                    }
                }
            }
            

            ?>
            <div class='que multichoice' style="<?php echo $info_style; ?>" id='que_<?php echo $result['qid']; ?>'>
                <div class='content'>
                    <div class='info'>  
                        <div>QID: <?php echo $result['qid']; ?></div>
                        <div><?php echo mb_strtoupper($result['subject']); ?></div>  
                        <div>#<?php echo $result['qNum']; ?></div>
                    </div>
                    <?php echo $result["contentHTML"]; ?>
                    <div class="btns">
                        <button onclick='changeAnswer(<?php echo $result["qid"]; ?>)'>Submit Answer</button>
                        <button onclick='resetAnswer(<?php echo $result["qid"]; ?>)'>Clear Answer</button>
                    </div>
                </div>
            </div>
            <?php
        }

    }

    public function showPercentage() {
        $count = $this->getPercentage();
        echo $count." completed = " . round($count/650*100,2)."%";
    }    

}