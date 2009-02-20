<?php class Candidate extends AppModel {
    var $name = 'Candidate';
    var $validate = array(
	'email' => array('rule' => 'email','required' => true),
	'password' => array('rule' => 'alphaNumeric','required' => true),
    );
    
    function validateLogin($data)
    {
        $user = $this->find(array('email' => $data['email'], 'password' => md5($data['password'])), array('id', 'email'));
        if(empty($user) == false)
            return $user['Candidate'];
        return false;
    }
    
    function registerCandidate($data)
    {
        $user = $this->find(array('email' => $data['email']), array('id', 'email'));
        if(empty($user) == true)
	{
	    $data['password'] = md5($data['password']);
	    $this->create();
	    $this->save($data);
            return $this->find(array('email' => $data['email']), array('id', 'email'));
	}
        return false;
    }
    
}
?>