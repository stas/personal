<?php
    class Admin extends AppModel
    {
        var $name = 'Admin';
        var $useTable   = 'users';
        var $belongsTo = array (
            'LdapUser',
        );
        
        // Cautam cel mai mare UID
        function getLargestUid()
        {
            return $this->LdapUser->findLargestUidNumber();
        }
        
        // Preluam CNP-ul dupa uid
        function getCnpByUid($LdapUid)
        {
            $user = $this->LdapUser->readByUidnumber('uid', $LdapUid);
            return $user['LdapUser']['tucnp'];
        }
        
        // Preluam CNP-ul dupa uid
        function getByUid($LdapUid)
        {
            $user = $this->LdapUser->readByUidnumber('uid', $LdapUid);
            return $user;
        }
        
        // Preluam utilizatorul dupa CNP
        function getByCnp($LdapCNP)
        {
            $user = $this->LdapUser->readByCNP('uid', $LdapCNP);
            return $user;
        }
        
        function diffUpdate($entry = null, $updates = null)
        {
            if(!empty($entry) && !empty($updates))
            {
                $entry['sn'] = $updates['nume'];
                $entry['givenname'] = $updates['prenume'];
                $entry['displayname'] = $updates['prenume']." ".$updates['nume'];
                    $gecos = explode(',', $entry['gecos']);
                    $gecos[0] = $entry['displayname'];
                $entry['gecos'] = implode(',', $gecos);
                $entry['ou'] = $updates['grupa'];
                
                if($this->LdapUser->ldapUpdate($entry))
                    return true;
            }

        }
        
        function diffUpdate_alumni($entry = null)
        {
            if(!empty($entry))
            {
                $entry['ou'] = 'alumni';
                if($this->LdapUser->ldapUpdate($entry))
                    return true;
            }
        }
    }
?>