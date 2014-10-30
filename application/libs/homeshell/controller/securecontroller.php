<?php

require_once dirname(__FILE__) . '/answercontroller.php';

class SecureController extends AnswerController {

    protected function forceHttps() {
    
        if (filter_input(INPUT_SERVER, 'HTTPS') != "on" && HOMESHELL_HTTPS_ENABLED) {
            
            if(HOMESHELL_REDIRECT_ON_HTTPS){
                $this->redirectToHttps();
            }else{
                $this->endHttpRequest();
            }
        }
    }

    private function redirectToHttps() {
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit();
    }
    
    private function endHttpRequest(){
        $this->setStatus(0);
        $this->addLocalizedMessage('https-required');
        $this->end();
    }

}
