<?php
    class User extends AppModel
    {
        var $name = 'User';
        var $belongsTo = array (
            'LdapUser',
        );
        
        function validateLogin($data)
        {
            
            $ldap_data = $this->LdapUser->read('',$data['User']['username']); //Get data from ldap
            $ldappassword = substr($ldap_data['LdapUser']['userpassword'], 7); //Tokenize {CRYPT}
            $salt = substr($ldappassword, 0, 12); //Get salt
            $userpassword = crypt($data['User']['password'], $salt); //Generate hash using users data
            if($ldap_data['LdapUser']['uid'] == $data['User']['username'] && $ldappassword == $userpassword)
            {
                $user['id'] = $ldap_data['LdapUser']['uidnumber'];
                $user['username'] = $ldap_data['LdapUser']['uid'];
                $user['name'] = $ldap_data['LdapUser']['displayname'];
                $user['email'] = $ldap_data['LdapUser']['tumail'];
                
                //Mysql stuff
                if($this->field('id',  $user['id']) != null) // To update or to create?!
                {
                    $this->save($user); //Update
                }
                else
                {
                    $this->create($user); //Create
                    $this->save();
                }
            }
            
            if(empty($user) == false)
                return $user;
            else
                return false;
        }
        
    }
?>