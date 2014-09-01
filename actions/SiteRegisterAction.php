<?php

/**
 * Class SiteRegisterAction
 *
 * @property $controller AuthController
 */
class SiteRegisterAction extends CAction {

	public function run($returnTo = null) {
		$this->controller->pageTitle = 'Регистрация';

		$model = new UserForm('register');

		if(Yii::app()->user->isLoggedIn)
			$this->controller->back($returnTo);

		$this->controller->performAjaxValidation($model, 'register-form');
		if (isset($_POST[get_class($model)])) {
			$model->setAttributes($_POST[get_class($model)]);
			if ($model->save() && $model->login($_POST['UserForm']['password']))
				$this->controller->back($returnTo);
		}

		$this->controller->render($this->id, compact('model'));
	}

}
