<?php

require_once dirname(__FILE__) . '/securecontroller.php';

class SessionController extends SecureController {

    protected $request;

    public function __construct(HomeShellRequest $request) {
        parent::__construct();
        $this->request = $request;
    }

    protected function getValue($index) {
        return $this->request->getValue($index);
    }

    protected function simpleLogin() {
        if ($this->checkLogin(false)) {
            $this->addLocalizedMessage('login-success');
        }
    }

    protected function forceLogin() {
        if (!$this->checkLogin(true)) {
            $this->setStatus(0);
            $this->end();
        }else{
            $this->addLocalizedMessage('login-success');
        }
    }

    private function printOnlyForced($message, $force) {
        if ($force) {
            $this->addLocalizedMessage($message);
        }
    }

    protected function checkLogin($force) {
        return true;
        $this->forceHttps();
        $authToken = $this->getValue(AUTH_TOKEN);

        if (is_null($authToken)) {
            $this->printOnlyForced('login-required', $force);
            return false;
        }

        $tokenModel = $this->loadModel('TokenModel');
        $token = $tokenModel->getToken($authToken);

        if (is_bool($token) && !$token) {
            $this->addLocalizedMessage('token-notfound');
            return false;
        }

        return $this->checkToken($token, $tokenModel);
    }

    private function checkToken($token, $tokenModel) {
        $currentTime = new DateTime();
        $tokenTime = new DateTime($token->valid);

        $currentTimestamp = $currentTime->getTimestamp();
        $tokenTimestamp = $tokenTime->getTimestamp();

        if ($tokenTimestamp < $currentTimestamp) {
            $this->addLocalizedMessage('token-timeout');
            if ($tokenModel->removeAllTimedOutTokens($currentTime->format('Y-m-d H:i:s'))) {
                $this->addLocalizedMessage('token-reset');
            }
            return false;
        }

        $newTokenTime = clone $currentTime;
        $newTokenTime->add(new DateInterval('PT' . AUTH_TIME . 'M'));
        $updated = $tokenModel->revalidateToken($token->token_id, $newTokenTime->format('Y-m-d H:i:s'));

        if (!$updated) {
            $this->addLocalizedMessage('token-update-failed');
        } else {
            $this->addLocalizedMessage('token-valid');
        }

        $userId = $token->user_id;
        $usersModel = $this->loadModel('UsersModel');
        $user = $usersModel->getUser($userId);
        $this->request->setUser($user);

        StrRes::setLocale($user->locale);

        return true;
    }

}
