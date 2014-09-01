<?php

class AuthController extends RController
{
	public $ajaxValidate = true;
	public $defaultAction = 'login';
	public $defaultActions = array(
		'login' => array(
			'class' => 'auth.actions.SiteLoginAction',
		),
		'register' => array(
			'class' => 'auth.actions.SiteRegisterAction',
		),
		'restore' => array(
			'class' => 'auth.actions.SiteRestoreAction',
		),
	);

	public function actions() {
		return CMap::mergeArray($this->defaultActions, $this->getModule()->actions);
	}

	public function actionLogout($returnTo = false)
	{
		Yii::app()->user->logout();
		$this->back($returnTo);
	}
} 