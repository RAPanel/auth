<?php
/**
 * Created by PhpStorm.
 * User: Rugalev
 * Date: 12.08.14
 * Time: 15:57
 */

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