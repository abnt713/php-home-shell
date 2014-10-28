<?php

class DefaultAnswer {

    private $status;
    private $messages;
    private $contents;

    public function __construct($status = 0, $messages = array(), $contents = array()) {
        $this->status = $status;
        $this->messages = $messages;
        $this->contents = $contents;
    }

    function getStatus() {
        return $this->status;
    }

    function getMessages() {
        return $this->messages;
    }

    function getContents() {
        return $this->contents;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setMessages($messages) {
        $this->messages = $messages;
    }

    function setContents($contents) {
        $this->contents = $contents;
    }

    function addMessage($message) {
        $this->messages[] = $message;
    }

    function addContent($key, $content) {
        $this->contents[$key] = $content;
    }

}
