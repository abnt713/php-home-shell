<?php

require_once dirname(__FILE__) . '/../../controller.php';
require_once 'application/src/answer/defaultanswer.php';
require_once 'application/src/answer/parser/arrayanswerparser.php';

abstract class AnswerController extends Controller {

    protected $answer;
    private $localizedAnswers;

    public function __construct() {
        parent::__construct();
        $this->answer = new DefaultAnswer();
        $this->localizedAnswers = array();
    }

    protected function loadSubController($subControllerName){
        require 'application/controller/subcontroller/' . strtolower($subControllerName) . '.php';
        // return new model (and pass the database connection to the model)
        $controller = new $subControllerName($this->request);
        $controller->setAnswer($this->answer);
        $controller->setLocalizedAnswers($this->localizedAnswers);
        return $controller;
    }
    
    protected function setStatus($status) {
        $this->answer->setStatus($status);
    }

    protected function addLocalizedMessage($message) {
        $this->localizedAnswers[] = $message;
        //$this->answer->addMessage($str);
    }

    protected function addLiteralMessage($message) {
        $this->answer->addMessage($message);
    }

    protected function addContent($key, $content) {
        $this->answer->addContent($key, $content);
    }

    protected function setContents($contents){
        $this->answer->setContents($contents);
    }
    
    protected function end() {
        foreach ($this->localizedAnswers as $localized) {
            $string = StrRes::get($localized);
            $str = !is_null($string) ? $string : 'unavailable_res';
            
            $this->answer->addMessage($str);
        }

        $parser = new ArrayAnswerParser();
        $json = $parser->parse($this->answer);

        echo json_encode($json);
        exit;
    }

}
