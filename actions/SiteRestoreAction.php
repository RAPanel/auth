<?php

/**
 * Class SiteRestoreAction
 *
 * @property $controller AuthController
 */
class SiteRestoreAction extends CAction {

	public function run($returnTo = null) {
		$this->controller->pageTitle = 'Востановление пароля';

		$model = new UserForm('restore');

		if(isset($_POST[get_class($model)]) && Yii::app()->request->isAjaxRequest) {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		if (isset($_POST[get_class($model)])) {
			$user = $model->find('email=:email', array('email' => $_POST[get_class($model)]['email']));
			if (is_object($user)) {
				$user->restorePassword();
			}
			Yii::app()->user->setFlash('restored', 'Новый пароль выслан на Ваш адрес');
			$this->controller->redirect(array('auth/login'));
		}

		if ($model->hasErrors() && Yii::app()->request->isAjaxRequest)
			Yii::app()->end(json_encode($model->errors));

		$this->controller->render($this->id, compact('model'));
	}

}
