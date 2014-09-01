<?php

/**
 * Class FacebookLoginAction
 *
 * Guide: http://www.designaesthetic.com/2012/03/02/create-facebook-login-oauth-php-sdk/
 *
 * @property $controller AuthController
 */
class FacebookLoginAction extends CAction
{
	public $appId;
	public $secretKey;

	const OAUTH_URL = 'https://www.facebook.com/dialog/oauth';
	const API_URL = 'https://graph.facebook.com/';

	public function run($code = null)
	{
		if(is_null($code))
			$this->getFacebookCode();
		else
			$this->callback($code);
	}

	public function callback($code)
	{
		$authData = $this->getAuthData($code);
		if($authData === false)
			$this->controller->back();
		$email = $authData['email'];
		$user = User::model()->findByAttributes(array('email' => $email));
		if(is_null($user)) {
			$user = $this->registerUser($authData);
		} else {
			$user->name = $authData['name'];
			$user->apiToken = $authData['access_token'];
			$user->saveSettings();
		}
		$user->apiLogin($authData['access_token']);
		$this->controller->back();
	}

	public function registerUser($authData) {
		$user = new UserForm('register');
		$user->email = $authData['email'];
		$user->name = $authData['id'];
		$user->username = $authData['first_name'] . ' ' . $authData['last_name'];
		$user->password = $user->password_repeat = md5($authData['access_token']);
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

	public function getFacebookCode()
	{
		$url = $this->renderUrl(self::OAUTH_URL, array(
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
		return $this->controller->createAbsoluteUrl('/' . $this->controller->module->id . '/' . $this->controller->id . '/' . $this->id);
	}

	public function getUserData($facebookUserId)
	{
		$result = $this->getApiResult(self::API_URL . 'me', array(
			'user_ids' => $facebookUserId,
			'client_secret' => $this->secretKey,
			'fields' => 'screen_name',
		));
		if(isset($result['response'][0]))
			return $result['response'][0];
		return array();
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

	public function getAuthData($code)
	{
		$data = $this->getApiResult(self::API_URL . 'oauth/access_token', array(
			'client_id' => $this->appId,
			'client_secret' => $this->secretKey,
			'code' => $code,
			'redirect_uri' => $this->getRedirectUrl(),
		), false);
		if(!strlen($data))
			return false;
		$parts = explode("&", $data);
		$accessData = array();
		foreach($parts as $part) {
			list($name, $value) = explode("=", $part);
			$accessData[$name] = $value;
		}
		if(!isset($accessData['access_token']))
			return false;
		$data = $this->getApiResult(self::API_URL . 'me', array(
			'client_id' => $this->appId,
			'client_secret' => $this->secretKey,
			'access_token' => $accessData['access_token'],
		));
		return CMap::mergeArray($accessData, $data);
	}
} 