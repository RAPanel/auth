<?php

class RestoreForm extends CFormModel {

    public $email;

    public function attributeLabels() {
        return array(
            'email' => 'E-Mail адрес',
        );
    }

    public function rules() {
        return array(
            array('email', 'required'),
            array('email', 'email'),
        );
    }

    public function restorePassword($className = null) {
        if($className === null)
            $className = 'UserBase';
        $user = $className::model()->find('email=:email', array('email' => $this->email));
        if (is_object($user)) {
            $user->restorePassword();
        }
    }

}
