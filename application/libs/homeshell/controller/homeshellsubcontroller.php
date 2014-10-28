<?php

class HomeShellSubController extends SessionController {

    public function setAnswer($answer) {
        $this->answer = $answer;
    }

    public function setLocalizedAnswers($localizedAnswers) {
        $this->localizedAnswers = $localizedAnswers;
    }

}
