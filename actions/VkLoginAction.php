<?php

/**
 * Class VkLoginAction
 *
 * Docs: https://vk.com/dev/auth_sites
 *
 * @property AuthController $controller
 */
class VkLoginAction extends CAction
{
	public $appId;
	public $secretKey;

	const OAUTH_URL = 'https://oauth.vk.com/';
	const API_URL = 'https://api.vk.com/';

	public function run($code = null)
	{
		if(is_null($code))
			$this->getVkCode();
		else
			$this->callback($code);
	}

	public function callback($code)
	{
		$authData = $this->getAuthData($code);
		$email = $authData['email'];
		$user = User::model()->findByAttributes(array('email' => $email));
		if(is_null($user)) {
			$user = $this->registerUser($authData);
		} else {
			$userData = $this->getUserData($authData['user_id']);
            $user->vk = $userData['screen_name'];
            if(!$user->name) $user->name = $userData['first_name'];
            if(!$user->surname) $user->surname = $userData['last_name'];
            if(empty($user->photo->id) && $userData['photo_max_orig']){
                $photo = new Photo();
                $photo->setAttributes($photo::savePhoto($userData['photo_max_orig']));
                $photo->save();
            }
			$user->apiToken = $authData['access_token'];
			$user->saveSettings();
		}
		$user->apiLogin($authData['access_token']);
        Yii::app()->user->setFlash('login', true);
		$this->controller->back();
	}

	public function registerUser($authData) {
		$userData = $this->getUserData($authData['user_id']);
		$user = new UserForm('register');
		$user->email = $authData['email'];
		$user->vk = $userData['screen_name'];
		$user->name = $userData['first_name'];
		$user->surname = $userData['last_name'];
		$user->username = $userData['first_name'] . ' ' . $userData['last_name'];
		$user->password = $user->password_repeat = md5($authData['access_token']);
        if($userData['photo_max_orig']){
            $photo = new Photo();
            $photo->setAttributes($photo::savePhoto($userData['photo_max_orig']));
            $photo->save();
        }
		$user->apiToken = $authData['access_token'];
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

	public function getVkCode()
	{
		$url = $this->renderUrl(self::OAUTH_URL . 'authorize', array(
			'client_id' => $this->appId,
			'redirect_uri' => $this->getRedirectUrl(),
			'scope' => 'email',
			'display' => 'page',
			'response_type' => 'code',
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

	public function getUserData($vkUserId)
	{
		$result = $this->getApiResult(self::API_URL . 'method/users.get', array(
			'user_ids' => $vkUserId,
			'client_secret' => $this->secretKey,
			'fields' => 'screen_name,photo_max_orig',
		));
		if(isset($result['response'][0]))
			return $result['response'][0];
		return array();
	}

	public function getApiResult($url, $params = array()) {
		$url = $this->renderUrl($url, $params);
		$data = @file_get_contents($url);
		if (!$data)
			return false;
		try {
			$jsonData = CJSON::decode($data);
		} catch (Exception $e) {
			return false;
		}
		return $jsonData;
	}

	public function getAuthData($code)
	{
		return $this->getApiResult(self::OAUTH_URL . 'access_token', array(
			'client_id' => $this->appId,
			'client_secret' => $this->secretKey,
			'code' => $code,
			'redirect_uri' => $this->getRedirectUrl(),
		));
	}
} 