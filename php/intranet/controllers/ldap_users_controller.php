<?php
class LdapUsersController extends AppController
{
   var $name = 'LdapUsers';
   var $helpers = array('Html', 'Form', 'Javascript');
   var $uses = array('LdapUser');

   function index()
   {
      //$users = $this->LdapUser->findAll('uid', '*');
      $users = $this->LdapUser->findLargestUidNumber();
      $this->set('largestUid', $users);
   }

   function view($uid) {
      $this->set('ldap_user', $this->LdapUser->read(null, $uid));
   }
   
   function viewByUid($uidnumber) {
      $this->set('ldap_user', $this->LdapUser->readByUidnumber(null, $uidnumber));
   }

}
?> 