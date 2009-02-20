<?php
class ProfilesController extends AppController {
    var $name = 'Profiles';
    var $helpers = array('Html', 'Form', 'Javascript');
    var $uses = array('Profile', 'County', 'Education');
    var $layout = 'candidate';
    
    function beforeFilter()
    {
        if(!$this->Session->check('Candidate'))
            $this->redirect(array('controller'=>'Candidates', 'action'=>'login'));
    }
    
    function index()
    {
        $this->Session->setFlash("Profil personal!");

        if(!empty($this->data['Education'])) {
            if(!$this->addedu($this->data['Education']))
                $this->Session->setFlash('Eroare la adaugarea educatiei!');
        }
        else
            $this->Session->setFlash('Eroare la trimiterea datelor!');

        $profile = $this->Profile->findByCid($this->Session->read('Candidate.id'));
        $education = $this->Education->findAllByCid($this->Session->read('Candidate.id'));
        if(empty($profile)) {
            $this->redirect('/candidate/profile/update');
        }
        else {
            $this->set("profile", $profile['Profile']);
            if (!empty($education))
                $this->set("educations", $education);
            else
                $this->set("education", null);
            $this->Session->setFlash("Acesta este profilul public ce a fost creat!");
        }
    }
    
    function addxp()
    {
        $this->Session->setFlash("XP!");
    }
    
    function addedu($data = null)
    {
        if(!empty($data)) {
            $data['cid'] = $this->Session->read('Candidate.id');
            $data['startdate'] = $data['startdate']['year'];
            $data['enddate'] = $data['enddate']['year'];
            if($this->Education->save($data))
                return true;
        }
    }
    
    function update()
    {
        $profile = $this->Profile->findByCid($this->Session->read('Candidate.id'));
        
        $counties = array();
        $counties_data = $this->County->find('all');
        foreach($counties_data as $county)
            array_push($counties, $county['County']['name']);
        
        $this->set('counties', $counties);
        
        if(empty($this->data['Profile']) && empty($profile['Profile']))
            $this->Session->setFlash("Completati profilul pentru a continua!");
        else if (empty($this->data['Profile']) && !empty($profile['Profile'])) {
            $this->Session->setFlash("Actualizati profilul!");
            $this->set('profile', $profile['Profile']);
        }
        else {
            $this->data['Profile']['cid'] = $this->Session->read('Candidate.id');
            if(empty($profile['Profile'])) {
                $this->Profile->create();
                $this->Profile->save($this->data);
            }
            $this->Profile->save();
            $this->redirect('/candidate/profile');
        }
    }
    
}

?>
