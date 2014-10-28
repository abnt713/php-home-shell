<?php

class Home extends HomeShellController {

    public function onDelete($args) {
        $this->setStatus(0);
        $this->addLocalizedMessage('invalid-request');
        $this->addLiteralMessage('Home request cannot answer to DELETE method');
        $this->end();
    }

    public function onGet($args) {
        $this->simpleLogin();
        
        $this->setStatus(1);
        $this->addLocalizedMessage('homeshell-welcome');
        $this->addContent('version', HOMESHELL_VERSION);
        $this->addContent('default-language', HOMESHELL_LOCALE);
        
        $actualLocale = is_null(StrRes::getLocale()) ? HOMESHELL_LOCALE : StrRes::getLocale();
        $this->addContent('actual-language', $actualLocale);
        
        $this->end();
    }

    public function onPost($args) {
        $this->setStatus(0);
        $this->addLocalizedMessage('invalid-request');
        $this->addLiteralMessage('Home request cannot answer to POST method');
        $this->end();
    }

}
