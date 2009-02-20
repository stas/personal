<?php
	Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
        
// Job
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
        Router::connect('/candidate', array('controller' => 'pages', 'action' => 'display', 'candidate'));
        Router::connect('/candidate/index', array('controller' => 'pages', 'action' => 'display', 'candidate'));
        Router::connect('/candidate/recover_pass', array('controller' => 'candidates', 'action' => 'recover_pass'));
        Router::connect('/candidate/change_pass', array('controller' => 'candidates', 'action' => 'change_pass'));
        Router::connect('/candidate/register', array('controller' => 'candidates', 'action' => 'register'));
        Router::connect('/candidate/login', array('controller' => 'candidates', 'action' => 'login'));
        Router::connect('/candidate/logout', array('controller' => 'candidates', 'action' => 'logout'));
        Router::connect('/candidate/profile', array('controller' => 'profiles', 'action' => 'index'));
        Router::connect('/candidate/profile/update', array('controller' => 'profiles', 'action' => 'update'));
        Router::connect('/candidate/profile/education', array('controller' => 'educations', 'action' => 'index'));




	Router::connect('/tests', array('controller' => 'tests', 'action' => 'index'));
?>