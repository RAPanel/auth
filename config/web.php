<?php

return array(
	'modules' => array(
		'auth' => array(
			'class' => 'auth.AuthModule',
			'actions' => array(
				'vk' => array(
					'class' => 'auth.actions.VkLoginAction',
				),
				'fb' => array(
					'class' => 'auth.actions.FacebookLoginAction',
				),
			),
		),
	),
);