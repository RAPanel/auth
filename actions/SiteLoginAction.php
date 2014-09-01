<?php

/**
 * Class SiteLoginAction
 *
 * @property $controller AuthController
 */
class SiteLoginAction extends CAction {

	public function run($returnTo = null) {
		$this->controller->pageTitle = 'Вход';

		$model = new UserForm('login');

		if(Yii::app()->user->id)
			$this->controller->back($returnTo);
		$this->controller->performAjaxValidation($model, 'login-form');
		if (isset($_POST[get_class($model)])) {
			$model->setAttributes($_POST[get_class($model)]);
			if ($model->validate() && $model->login())
				$this->controller->back($returnTo);
		}

		$this->controller->render($this->id, compact('model'));
	}

}
