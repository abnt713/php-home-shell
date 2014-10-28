<?php

require_once dirname(__FILE__) . '/answerparser.php';

class ArrayAnswerParser implements AnswerParser {

    public function parse(\DefaultAnswer $answer) {
        $status = $answer->getStatus();
        $messages = $answer->getMessages();
        $contents = $answer->getContents();

        $jsonArray = array(
            'status' => $status,
            'messages' => $messages,
            'contents' => $contents
        );

        return $jsonArray;
    }

}
