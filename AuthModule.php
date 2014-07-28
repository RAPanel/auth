<?php
/**
 * @author ReRe Design studio
 * @email webmaster@rere-design.ru
 */

class AuthModule extends CWebModule {
    public function init()
    {
        YiiBase::setPathOfAlias('auth', YiiBase::getPathOfAlias('application.modules.auth'));

        $imports = array(
            'auth.models.*',
            'auth.controllers.*',
        );
        $this->setImport($imports);
        parent::init();
    }

}