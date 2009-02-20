<?php
class CandidatesController extends AppController {
    var $name = 'Candidates';
    var $helpers = array('Html', 'Form');
    var $uses = array('Candidate', 'Profile', 'County');
    var $layout = 'candidate';

    function beforeFilter()
    {
        $this->__validateLoginStatus();
    }
    
    function index()
    {
        
    }
    
    function genPassword($length=8)
    {
        # first character is capitalize
        $pass =  chr(mt_rand(65,90));    // A-Z
       
        # rest are either 0-9 or a-z
        for($k=0; $k < $length - 1; $k++)
        {
            $probab = mt_rand(1,10);
       
            if($probab <= 8)   // a-z probability is 80%
                $pass .= chr(mt_rand(97,122));
            else            // 0-9 probability is 20%
                $pass .= chr(mt_rand(48, 57));
        }
        return $pass;
    }
    
    function recover_pass()
    {
        if(!empty($this->data['Candidate']['email'])) {
            $user = $this->Candidate->find(array('email' => $this->data['Candidate']['email']));
            $user['Candidate']['password'] = md5($this->genPassword());
            $this->Candidate->save($user);
        } 
    }
    
    function change_pass()
    {
        $id = $this->Session->read('Candidate.id');
        if(!empty($id) && !empty($this->data['Candidate']['newpass'])) {
            $user = $this->Candidate->find(array('id' => $id));
            $user['Candidate']['password'] = md5($this->data['Candidate']['newpass']);
            $this->Candidate->save($user);
            $this->Session->destroy();
            $this->redirect('candidate/login');
        } 
    }
    
    function register()
    {
        $counties = array();
        $counties_data = $this->County->find('all');
        foreach($counties_data as $county)
            array_push($counties, $county['County']['name']);
        
        $this->set('counties', $counties);
        
        if($this->data['Candidate'] != null) {
            
            $profile = $this->data['Candidate'];
            
            for($i = 0; $i <= 8; $i++) {
                array_pop($this->data['Candidate']);
            }
            
            for($i = 0; $i <= 2; $i++) {
                array_shift($profile);
            }
            
            $candidate = $this->Candidate->registerCandidate($this->data['Candidate']);
            if(empty($candidate) != true) {
                $profile['cid'] = $candidate['Candidate']['id'];
                if($this->Profile->save($profile))
                    $this->redirect('index');
                else
                    $this->redirect('login');
            }
            else
                $this->redirect('login');
            
        }
    }
    
    function login()
    {
        if(empty($this->data) == false)
        {
            if(($user = $this->Candidate->validateLogin($this->data['Candidate'])) == true)
            {
                $this->Session->write('Candidate', $user);
                $this->redirect('index');
                //$this->Session->setFlash('You\'ve successfully logged in.');
            }
            else
            {
                $this->Session->setFlash('Credentiale incorecte.');
                $this->redirect('login');
            }
        }
    }
    
    function logout()
    {
        $this->Session->destroy('Candidate');
        $this->Session->setFlash('Deautentificare cu succes.');
        $this->redirect('login');
    }
        
    function __validateLoginStatus()
    {
        if($this->action != 'login' && $this->action != 'logout' && $this->action != 'register' && $this->action != 'recover_pass')
        {
            if($this->Session->check('Candidate') == false)
            {
                $this->redirect('login');
                $this->Session->setFlash('Necesita autentificare.');
            }
        }
    }
    
}

?>
