<?php

Yii::import('auth.models.RestoreForm');
/**
 * Class SiteRestoreAction
 *
 * @property AuthController $controller
 */
class SiteRestoreAction extends CAction {

	public function run($returnTo = null, $token = null) {
		$this->controller->pageTitle = 'Восстановление пароля';

		if($token !== null) {
			$identity = new RTokenUserIdentity($token);
			$identity->authenticate();
			if(Yii::app()->user->login($identity))
				$this->controller->redirect(array('auth/password'));
			else
				$this->controller->redirect(array('auth/restore', $returnTo => $returnTo));
		}

		$model = new RestoreForm();

		$this->controller->performAjaxValidation($model, 'restore-form');
		if (isset($_POST[get_class($model)])) {
			$model->setAttributes($_POST[get_class($model)]);
			if($model->validate()) {
				$model->restorePassword($this->controller->userClassName);
				Yii::app()->user->setFlash('info', 'Ссылка для восстановления выслана на Ваш E-mail адрес');
				$this->controller->redirect(array('/site/index'));
			}
		}

		$this->controller->renderActive($this->id, compact('model'));
	}

}
