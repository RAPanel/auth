<?php

YiiBase::setPathOfAlias('auth', dirname(__FILE__));

class AuthModule extends CWebModule
{
	public $authFormClass = 'UserForm';

	public $defaultController = 'auth';

	public $controllerMap = array();

	public $actions = array();

	public function init()
	{
		$imports = array(
			'auth.controllers.*',
			'auth.actions.*',
			'auth.models.*',
		);
		$this->setImport($imports);
		parent::init();
	}

}