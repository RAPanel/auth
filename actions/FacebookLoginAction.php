<?php

/**
 * Class FacebookLoginAction
 *
 * Docs: https://developers.facebook.com/docs/facebook-login/manually-build-a-login-flow/v2.1
 *
 * @property AuthController $controller
 */
class FacebookLoginAction extends CAction
{
	public $appId;
	public $secretKey;

	const OAUTH_URL = 'https://www.facebook.com/dialog/oauth';
	const API_URL = 'https://graph.facebook.com/';

	public function run($returnTo = null, $code = null, $state = null)
	{
		if($returnTo !== null)
			Yii::app()->user->setState('facebookRedirect', $returnTo);
		if($code === null)
			$this->getAuthCode();
		else
			$this->callback($code, $state);
	}

	public function callback($authCode, $state)
	{
		if(Yii::app()->user->getState('facebookLoginState') != $state)
			die("XSS");
		Yii::app()->user->setState('facebookLoginState', false);
		$accessToken = $this->getAccessToken($authCode);
		$userData = $this->getUserData($accessToken);
		$redirect = Yii::app()->user->getState('facebookRedirect');
		if($userData === false)
			$this->controller->back($redirect);
		$email = $userData['email'];
		if($email) $user = User::model()->findByAttributes(array('email' => $email));
		if(!isset($user) || is_null($user)) {
			$user = $this->registerUser($accessToken, $userData);
		} else {
            if(!$user->name) $user->name = $userData['first_name'];
            if(!$user->surname) $user->surname = $userData['last_name'];
            if(empty($user->photo->id)){
                $photo = new Photo();
                $photo->setAttributes($photo::savePhoto('http://graph.facebook.com/'.$userData['id'].'/picture?height=1000&type=normal&width=1000'));
                $photo->save();
            }
//			$user->name = $userData['name'];
            if(!$user->email && $email) $user->email = $email;
			$user->apiToken = md5($accessToken);
			if(!$user->role)
				$user->role = 'user';
			$user->saveSettings();
		}
		$user->apiLogin(md5($accessToken));
		Yii::app()->user->setState('facebookRedirect', false);
        Yii::app()->user->setFlash('login', true);
		$this->controller->back($redirect);
	}

	public function getAccessToken($authCode) {
		$data = $this->getApiResult(self::API_URL . 'oauth/access_token', array(
			'client_id' => $this->appId,
			'redirect_uri' => $this->getRedirectUrl(),
			'client_secret' => $this->secretKey,
			'code' => $authCode,
		), false);
		$vars = explode("&", $data);
		$data = array();
		foreach($vars as $var) {
			list($name, $value) = explode("=", $var);
			$data[$name] = $value;
		}
		return $data['access_token'];
	}

	public function registerUser($accessToken, $userData) {
        $user = new UserForm('register');
        $user->email = $userData['email'];
        $user->fb = $userData['url'];
        $user->name = $userData['first_name'];
        $user->surname = $userData['last_name'];
        $user->username = $userData['first_name'] . ' ' . $userData['last_name'];
		$user->password = $user->password_repeat = md5($accessToken);
        if($photo = 'http://graph.facebook.com/'.$userData['id'].'/picture?height=1000&type=normal&width=1000'){
            $photo = new Photo();
            $photo->setAttributes($photo::savePhoto($photo));
            $photo->save();
        }
		$user->apiToken = $accessToken;
		$user->role = 'user';
		$user->save(false);
		$user->saveSettings();
		return $user;
	}

	public function renderUrl($url, $params = array())
	{
		$parts = array();
		foreach ($params as $name => $value) {
			$parts[] = urlencode($name) . '=' . urlencode($value);
		}
		return $url . (count($params) ? '?' . implode('&', $parts) : '');
	}

	public function getAuthCode()
	{
		$state = uniqid();
		Yii::app()->user->setState('facebookLoginState', $state);
		$url = $this->renderUrl(self::OAUTH_URL, array(
			'client_id' => $this->appId,
			'redirect_uri' => $this->getRedirectUrl(),
			'scope' => 'email',
			'response_type' => 'code',
			'state' => $state,
		));
		$this->controller->redirect($url);
	}

	public function getRedirectUrl()
	{
		$urlParams = array();
		if(isset($_GET['window']))
			$urlParams['window'] = 1;
		return $this->controller->createAbsoluteUrl('/' . $this->controller->module->id . '/' . $this->controller->id . '/' . $this->id, $urlParams);
	}

	public function getApiResult($url, $params = array(), $json = true) {
		$url = $this->renderUrl($url, $params);
		$data = @file_get_contents($url);
		if (!$data) {
			return false;
		}
		if($json) {
			try {
				$jsonData = json_decode($data, true);
			} catch (Exception $e) {
				return false;
			}
		} else
			return $data;
		return $jsonData;
	}

	public function getUserData($accessToken)
	{
		$data = $this->getApiResult(self::API_URL . 'me', array(
			'client_id' => $this->appId,
			'client_secret' => $this->secretKey,
			'access_token' => $accessToken,
		));
		return $data;
	}
} 