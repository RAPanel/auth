<?php
/**
 * Created by PhpStorm.
 * User: anatoly
 * Date: 15.10.14
 * Time: 12:35
 */

Yii::import('auth.models.PasswordForm');
class PasswordAction extends CAction {

    public function run() {
        $this->controller->pageTitle = "Изменить пароль";
        if(!Yii::app()->user->id)
            $this->controller->redirect(array('auth/login'));
        $model = new PasswordForm();

        $this->controller->performAjaxValidation($model, 'password-form');
        if (isset($_POST[get_class($model)])) {
            $model->setAttributes($_POST[get_class($model)]);
            if($model->validate()) {
                $model->applyPassword();
                Yii::app()->user->setFlash('info', 'Пароль успешно изменён');
                $this->controller->redirect(array('/site/index'));
            }
        }
        $this->controller->render('password', compact('model'));
    }

} 