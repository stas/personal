<h1><?php echo $ldap_user['LdapUser']['displayname']?></h1>
<table>
<tr>
   <td>uid</td>
   <td><?php echo $ldap_user['LdapUser']['uid']?></td>
</tr>
<tr>
   <td>ou</td>
   <td><?php echo $ldap_user['LdapUser']['tucnp']?></td>
</tr>
<tr>
   <td>id</td>
   <td><?php echo $ldap_user['LdapUser']['uidnumber']?></td>
</tr>
<tr>
   <td>name</td>
   <td><?php echo $ldap_user['LdapUser']['displayname']?></td>
</tr>
<tr>
   <td>mail</td>
   <td><?php echo $ldap_user['LdapUser']['tumail']?></td>
</tr>
<tr>
   <td>ou</td>
   <td><?php echo $ldap_user['LdapUser']['ou']?></td>
</tr>
<tr>
   <td>password</td>
   <td><?php echo $ldap_user['LdapUser']['userpassword']?></td>
</tr>
</table>
<?php //pr($ldap_user['LdapUser']) ?>