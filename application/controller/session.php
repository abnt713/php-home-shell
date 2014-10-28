<?php

class Session extends HomeShellController{
    
    
    public function onDelete($args) {
        // Destruir sessão
    }

    public function onGet($args) {
        
    }

    public function onPost($args) {
        $this->forceHttps();
        $username = $this->getValue('username');
        $password = $this->getValue('password');
        
        $usersModel = $this->loadModel('UsersModel');
        $userLogin = $usersModel->doLogin($username, $password);
        
        if(is_null($userLogin)){
            $this->addLocalizedMessage('login-incorrect');
            $this->end();
        }
        
        $userId = $userLogin->user_id;
        $token = sha1(uniqid('hs', true));
        
        $currentTime = new DateTime();
        $currentDbTime = $currentTime->format('Y-m-d H:i:s');
        
        $currentTime->add(new DateInterval('PT' . AUTH_TIME . 'M'));
        $validDbTime = $currentTime->format('Y-m-d H:i:s');
        
        $tokenModel = $this->loadModel('TokenModel');
        $created = $tokenModel->createToken($userId, $token, $currentDbTime, $validDbTime);
        
        if($created){
            $this->setStatus(1);
            $this->addLocalizedMessage('login-success');
            $this->addContent('token', $token);
            $this->end();
        }else{
            $this->addLocalizedMessage('login-token-failed');
            $this->end();
        }
    }

}

