<?php

class PasswordForm extends CFormModel {

    public $oldPassword;
    public $newPassword;
    public $newPasswordRepeat;

    public function attributeLabels() {
        return array(
            'oldPassword' => 'Старый пароль',
            'newPassword' => 'Новый пароль',
            'newPasswordRepeat' => 'Повторите пароль',
        );
    }

    public function rules() {
        $rules = array(
            array('newPassword, newPasswordRepeat', 'required'),
            array('newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword', 'message' => 'Пароли не совпадают'),
        );
        if(Yii::app()->user->getState('tokenAuth', false) !== true) {
            $rules[] = array('oldPassword', 'validateOldPassword');
            $rules[] = array('oldPassword', 'required');
        }
        return $rules;
    }

    public function validateOldPassword($attribute) {
        $value = $this->$attribute;
        $result = Yii::app()->user->model->validatePassword($value);
        if(!$result)
            $this->addError($attribute, "Неверный пароль");
    }

    public function applyPassword() {
        $user = Yii::app()->user->model;
        $user->password = $this->newPassword;
        Yii::app()->user->setState('tokenAuth', false);
        $user->save(false, array('password'));
    }

}
