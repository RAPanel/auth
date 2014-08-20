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

		$this->controller->performAjaxValidation($model, 'register-form');
		if ($this->controller->typicalSave($model, 1) && $model->login($model->password_repeat)) {
			$this->controller->flash(Yii::t('auth', 'User success registered', array(
				'{id}' => $model->id,
				'{name}' => $model->username,
				'{email}' => $model->email,
				'{phone}' => $model->phone,
				'{password}' => $model->password_repeat,
				'{role}' => $model->role,
			)));
			$this->controller->refresh();
		}

		$this->controller->render($this->id, compact('model'));
	}

}
