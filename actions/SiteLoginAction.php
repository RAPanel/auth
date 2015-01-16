<?php

/**
 * Class SiteLoginAction
 *
 * @property AuthController $controller
 */
class SiteLoginAction extends CAction {

	public function run($returnTo = null) {
		$this->controller->pageTitle = 'Вход';

		/** @var UserBase $model */
		$className = $this->controller->userClassName;
		$model = new $className('login');

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
