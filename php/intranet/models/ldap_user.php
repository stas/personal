<?php 
class LdapUser extends AppModel
{
   var $name       = 'LdapUser';
   var $useTable   = false;
   var $primaryKey = 'uid';

   var $host       = '';
   var $port       = 389;
   var $baseDn     = '';
   var $user       = '';
   var $pass       = '';

   var $ds;

   function __construct()
   {
      parent::__construct();
      $this->ds = ldap_connect($this->host, $this->port);
      ldap_set_option($this->ds, LDAP_OPT_PROTOCOL_VERSION, 3);
      ldap_bind($this->ds, $this->user, $this->pass);
   }

   function __destruct()
   {
      ldap_close($this->ds);
   }

   function findAll($attribute = 'uid', $value = '*', $baseDn = 'ou=users,dc=student,dc=utcluj,dc=ro')
   {
      $r = ldap_search($this->ds, $baseDn, $attribute . '=' . $value);
      if ($r)
      {
         //if the result contains entries with surnames,
         //sort by surname:
         ldap_sort($this->ds, $r, "sn");
   
         $result = ldap_get_entries($this->ds, $r);
         return $this->convert_from_ldap($result);
      }
      return null;
   }

   // would be nice to read fields. left the parameter in as placeholder and to be compatible with other read()'s
   function read($fields=null, $uid)
   {
      $r = ldap_search($this->ds, $this->baseDn, 'uid='. $uid);
      if ($r)
      {
         $l = ldap_get_entries($this->ds, $r);
         $convert = $this->convert_from_ldap($l);
         return $convert[0];
      }
   }
   
   // would be nice to read fields. left the parameter in as placeholder and to be compatible with other read()'s
   function readByUidnumber($fields=null, $uid)
   {
      $r = ldap_search($this->ds, $this->baseDn, 'uidnumber='. $uid);
      if ($r)
      {
         $l = ldap_get_entries($this->ds, $r);
         $convert = $this->convert_from_ldap($l);
         return $convert[0];
      }
   }
   
   function readByCNP($fields=null, $cnp)
   {
      $r = ldap_search($this->ds, $this->baseDn, 'tuCNP='.$cnp);
      if ($r)
      {
         $l = ldap_get_entries($this->ds, $r);
         $convert = $this->convert_from_ldap($l);
         return $convert[0];
      }
   }

   function findLargestUidNumber()
   {
      $r = ldap_search($this->ds, $this->baseDn, 'uidnumber=*');
      if ($r)
      {
         // there must be a better way to get the largest uidnumber, but I can't find a way to reverse sort.
         ldap_sort($this->ds, $r, "uidnumber");
            
         $result = ldap_get_entries($this->ds, $r);
         $count = $result['count'];
         $biguid = $result[$count-1]['uidnumber'][0];
         return $biguid;
      }
      return null;
   }
   
   /**
    * The "U" in CRUD
    */
   function ldapUpdate($entry = null) {
      $entryDn = "uid=".$entry['uid'].",".$this->baseDn;
      if($entry) {
         if( @ldap_modify( $this->ds, $entryDn, $entry) ) {
            return true;
         }
      }
      
   }

   private function convert_from_ldap($data)
   {
      foreach ($data as $key => $row):
         if($key === 'count') continue;
 
         foreach($row as $key1 => $param):
            if(!is_numeric($key1)) continue;
            if($row[$param]['count'] === 1)
               $final[$key]['LdapUser'][$param] = $row[$param][0];
            else
            {
               foreach($row[$param] as $key2 => $item):
                  if($key2 === 'count') continue;
                  $final[$key]['LdapUser'][$param][] = $item;
               endforeach;
            }
         endforeach;
      endforeach;
      return $final;
   }
}
?>
