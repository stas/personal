<?php
class EducationsController extends AppController {
    var $name = 'Educations';
    var $helpers = array('Html', 'Form', 'Javascript');
    var $uses = array('Profile');
    var $layout = 'plain';
    
    function beforeFilter()
    {
        if(!$this->Session->check('Candidate'))
            $this->redirect(array('controller'=>'Candidates', 'action'=>'login'));
    }

    function index() {
        $this->Session->setFlash("Adauga educatie");
    }
    
}
?>