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
		'password' => array(
			'class' => 'auth.actions.PasswordAction',
		),
	);

	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules() {
		$guestActions = array_unique(array_merge(array_keys($this->actions()), array('login', 'register', 'restore')));
		$userActions = array_unique(array_merge(array_keys($this->actions()), array('logout', 'password')));
		return array(
			array('allow',
				'actions' => $guestActions,
				'roles' => array('guest'),
			),
			array('allow',
				'actions' => $userActions,
				'roles' => array('user'),
			),
			array('allow',
				'actions' => array('logout'),
				'roles' => array('user'),
			),
			array('deny',
				'deniedCallback' => function () {
					Yii::app()->controller->redirect(array('auth/login', 'returnTo' => Yii::app()->request->requestUri));
				}
			),
		);
	}

	public function actions() {
		return CMap::mergeArray($this->defaultActions, $this->getModule()->actions);
	}

	public function actionLogout($returnTo = false)
	{
		Yii::app()->user->logout();
		$this->back($returnTo);
	}
} 