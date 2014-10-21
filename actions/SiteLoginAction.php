<?php

/**
 * Class SiteLoginAction
 *
 * @property AuthController $controller
 */
class SiteLoginAction extends CAction {

	public function run($returnTo = null) {
		$this->controller->pageTitle = 'Вход';

		/** @var UserForm|AuthForm $model */
		$model = new UserForm('login');

		if(Yii::app()->user->id)
			$this->controller->back($returnTo);
		$this->controller->performAjaxValidation($model, 'login-form');
		if (isset($_POST[get_class($model)])) {
			$model->setAttributes($_POST[get_class($model)]);
			if ($model->validate() && $model->login())
				$this->controller->back($returnTo);
		}

		$this->controller->renderActive($this->id, compact('model'));
	}

}
