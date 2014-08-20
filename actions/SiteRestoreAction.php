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

		if (isset($_POST[get_class($model)])) {
			$user = $model->find('email=:email', array('email' => $_POST[get_class($model)]['email']));
			if (is_object($user)) {
				$user->controller->restore();

				$this->controller->flash('Новый пароль выслан на Ваш адрес');
//                if (Yii::app()->request->isAjaxRequest) Yii::app()->end('1');
				$this->controller->back($returnTo);

			} else $model->addError('email', 'Пользователь с таким паролем не зарегистрирован в системе');
		}

		if ($model->hasErrors() && Yii::app()->request->isAjaxRequest)
			Yii::app()->end(json_encode($model->errors));

		$this->controller->render($this->action->id, compact('model'));
	}

}
