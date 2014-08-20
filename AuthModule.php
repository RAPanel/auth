<?php

YiiBase::setPathOfAlias('auth', dirname(__FILE__));

class AuthModule extends CWebModule
{
	public $defaultController = 'auth';

	public $controllerMap = array();

	public $actions = array();

	public function init()
	{
		$imports = array(
			'auth.controllers.*',
			'auth.actions.*',
		);
		$this->setImport($imports);
		parent::init();
	}

}