<?php

class AuthController extends RController
{
    public $ajaxValidate = false;

    public function actionRegister($returnTo = false)
    {
        $this->layout = '//layouts/wrapper';
        $this->pageTitle = 'Регистрация';

        $model = new UserForm('register');

        if ($this->typicalSave($model, 1) && $model->login($model->password_repeat)) {
            $this->flash(Yii::t('auth', 'User success registered', array(
                '{id}' => $model->id,
                '{name}' => $model->username,
                '{email}' => $model->email,
                '{phone}' => $model->phone,
                '{password}' => $model->password_repeat,
                '{role}' => $model->role,
            )));
            $this->refresh();
        }

        $this->render($this->action->id, compact('model'));
    }

    public function actionLogin($returnTo = false)
    {
        $this->pageTitle = 'Вход';

        $model = new UserForm('login');

        if (isset($_POST[get_class($model)])) {
            $model->setAttributes($_POST[get_class($model)]);
            if ($model->validate() && $model->login())
                $this->back($returnTo);
            elseif (Yii::app()->request->isAjaxRequest)
                Yii::app()->end(json_encode($model->errors));
        }

        $this->render($this->action->id, compact('model'));
    }

    public function actionRestore($returnTo = false)
    {
        $this->pageTitle = 'Востановление пароля';

        $model = new UserForm('restore');

        if (isset($_POST[get_class($model)])) {
            $user = $model->find('email=:email', array('email' => $_POST[get_class($model)]['email']));
            if (is_object($user)) {
                $user->restore();

                $this->flash('Новый пароль выслан на Ваш адрес');
//                if (Yii::app()->request->isAjaxRequest) Yii::app()->end('1');
                $this->back($returnTo);

            } else $model->addError('email', 'Пользователь с таким паролем не зарегистрирован в системе');
        }

        if ($model->hasErrors() && Yii::app()->request->isAjaxRequest)
            Yii::app()->end(json_encode($model->errors));

        $this->render($this->action->id, compact('model'));
    }

    public function actionBack($id, $code = false)
    {
        if ($id == 'vk' && $code) {
            $vkId = '4456009';
            $vkKey = 'VCGLUyF9WZzPKY1Y9pSp';
            $bask = 'http://mariyaleontieva.com/auth/back?id=vk';
            $url = "https://oauth.vk.com/access_token?client_id={$vkId}&client_secret={$vkKey}&code={$code}&redirect_uri={$bask}";
            $data = json_decode(file_get_contents($url));

            $user = UserForm::model()->find('email=:email', array('email' => $data->email));
            if (is_null($user)) {
                $info = json_decode(file_get_contents("https://api.vk.com/method/users.get?user_ids={$data->user_id}&fields=sex,bdate,city,photo_400_orig,contacts,screen_name&v=5.23&access_token={$data->access_token}"));
                $info = $info->response[0];
                Mail::quiсkSend(CVarDumper::dumpAsString($info, 10, 1), 'semyonchick@gmail.com');
                $model = new UserForm('register');
                $model->name = $info->first_name;
                $model->surname = $info->last_name;
                $model->username = trim("{$model->name} {$model->surname}");
                $model->birthday = strtotime($info->bdate);
                $model->sex = $info->sex;
                $model->city = $info->city->title;
                $model->photoLink = $info->photo_400_orig;
                $model->phone = $info->home_phone;
                $model->vk = '//vk.com/' . $info->screen_name;
                $model->email = $data->email;
                $model->password = $model->password_repeat = uniqid();
                if ($model->save() && $model->login($model->password_repeat))
                    Yii::app()->end('<script>window.opener.location.reload();window.close();</script>');
                else CVarDumper::dump($model->errors, 10, 1);
            } else {
                if ($user->login(false, 1))
                    Yii::app()->end('<script>window.opener.location.reload();window.close();</script>');
                else CVarDumper::dump($user->errors, 10, 1);
            }
        } elseif ($id == 'fb') {
            echo '111';
            Mail::quiсkSend(CVarDumper::dumpAsString($_REQUEST, 10, 1), 'semyonchick@gmail.com');

        }
    }

    public function actionLogout($returnTo = false)
    {
        Yii::app()->user->logout();
        $this->back($returnTo);
    }
}
