<?php

class HomeShellApplication {

    /**
     * The given arguments to the server by URL
     * @var Array
     */
    private $arguments;
    
    /**
     * Holds the request information for the controllers and it's children
     * @var HomeShellRequest
     */
    private $request;

    public function runApp() {
        $this->initRequest();
        
        if($this->request->isValid()){
            $this->splitUrl();
            $this->runUrl();
        }else{
            $this->onInvalidRequest();
        }
    }

    private function initRequest() {
        $this->request = new HomeShellRequest();
    }

    private function splitUrl() {
        if (isset($_GET['url'])) {
            $pureUrl = rtrim($_GET['url'], '/');
            $sanitizedUrl = filter_var($pureUrl, FILTER_SANITIZE_URL);
            $this->arguments = explode('/', $sanitizedUrl);
        }
    }

    private function runUrl() {
        $controller = null;
        if (is_null($this->arguments)) {
            require './application/controller/home.php';
            $controller = new Home($this->request);
        } else if (file_exists('./application/controller/' . $this->arguments[REQUEST_CONTROLLER] . '.php')) {
            require './application/controller/' . $this->arguments[REQUEST_CONTROLLER] . '.php';
            $controller = new $this->arguments[REQUEST_CONTROLLER]($this->request);
        } else {
            $controller = null;
        }
        
        if(!is_null($controller)){
            $this->callMethod($controller);
        }else{
            $this->onInvalidRequest();
        }
    }
    
    private function onInvalidRequest(){
        $answer = new DefaultAnswer(0, StrRes::get('invalid-request'));
        $parser = new ArrayAnswerParser();
        
        echo json_encode($parser->parse($answer));
    }
    
    private function callMethod($controller){
        switch($this->request->getMethod()){
            case METHOD_GET:
                $controller->onGet($this->arguments);
                break;
            case METHOD_POST:
                $controller->onPost($this->arguments);
                break;
            case METHOD_DELETE:
                $controller->onDelete($this->arguments);
                break;
            default:
                die('Incorrect method');
        }
    }
    
}
