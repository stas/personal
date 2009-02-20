<?php
    class AdminsController extends AppController
    {
        var $name = 'Admins';
        var $helpers = array('Html', 'Form', 'Javascript');
        var $uses = array('User', 'Admin');
        
        /**
         *  Filtru pentru verificarea sesiunii utilizatorilor
         */
        /*function beforeFilter()
        {
            if(!$this->Session->check('User'))
                $this->redirect(array('controller'=>'users', 'action'=>'login'));
        }*/
        
        /**
         * Prima pagina
         */
        function index()
        {
            $this->set('largestUid', $this->Admin->getLargestUid());
        }
        
        /**
         * Actualizare recursiva
         */
        function updateldap_rec()
        {
            if(empty($this->params['url']['from']) && empty($this->params['url']['to'])) {
                // Preluam cel mai mare uid
                $start_from = $this->Admin->getLargestUid();
                $end_with = $start_from - 1000; // Altfel facem overload
            }
            else {
                $start_from = $this->params['url']['from'];
                $end_with = $this->params['url']['to'];
            }
            
            $results = array();
            
            // Start actualizare recursiv
            for($i = $start_from; $i != $end_with; $i--)
            {
                $results[$i] = $this->updateldap($i);
            }
            
            $this->set('updatedRecords', $i);
            $this->set('results', $results);
            $this->set('info', 'Actualizare de la '.$start_from.' pana la '.$end_with);
        }
        
        /**
         * Sincronizarea LDAP-ului cu SINU
         */
        function updateldap($data = null)
        {
            // Incarcam clase
            App::import('HttpSocket'); // Pentru request-uri http 
            App::import('Sanitize'); // Pentru sanitizare
            
            if(!$data)
                $data = 4861;
            
            // Start
            if(empty($this->data['Admin']))
            {
                $result = "Rezultate UPGRADE: ";
                // Ce sa fie ignorat la sanitizare
                $ignoreOnStrip = array(" ", ".", "_", ",", "\(", "\)", "/", "\"", '@', '!', "$", "%", "^", "*", "-", "+", "=", "?", "[", "]", "|" );
                // Preluare cnp
                $LdapCnp = $this->Admin->getCnpByUid($data);
                // Pentru a putea sanitiza
                $cleaner = new Sanitize();
                // Pentru a putea face request-uri http
                $http = new HttpSocket();
                    $uri = 'http://sinu.utcluj.ro/cc_pk_cnp/checkLogin.jsp';
                    $request = array( 
                      'cnp' => $LdapCnp,
                      'Submit' => 'Login'
                    );

                // Preluam datele din LDAP
                $fromLdap = $this->Admin->getByCNP($LdapCnp);
                // Preluam date sinu, curatam si reordonam
                // Fara array-uri spre stripTags, ala nu le stie
                $httpData = null; $tries = 1;
                while(empty($httpData) && $tries <= 5) {
                    $httpData = $http->post($uri, $request);
                    $tries++;
                }
                $sinuResult = $cleaner->stripTags($httpData, 'body', 'html', 'meta', 'head','br');
                
                if($sinuResult = array_filter(explode('\n',preg_replace('/\s\s+/', '\n', $sinuResult))) && $sinuResult[9] != 'OK')
                {
                    $this->Admin->diffUpdate_alumni($fromLdap['LdapUser']);
                    $result .= "A fost actualizat utilizatorul ".$fromLdap['LdapUser']['displayname']." ID: ".$fromLdap['LdapUser']['uidnumber']." UID: ".$fromLdap['LdapUser']['uid']."\n";
                    $sinuResult = null;
                    
                }
                else if(!empty($sinuResult))
                {
                    
                    $fromSinu = array_filter(explode('\n',preg_replace('/\s\s+/', '\n', $sinuResult)));
                    // Primul element va fi header-ul http request-ului venit de la sinu
                    for($i = 8; $i != 0; $i--) {
                        array_shift($fromSinu);
                    }
                    $fromSinu = array_filter($fromSinu);
                    // Bug - An V (CA rom)
                    if($fromSinu[5] == 'An V' && $fromSinu[6] == '(CA rom)') {
                        $fromSinu[5] .= " ".$fromSinu[6];
                        $fromSinu[6] = $fromSinu[7];
                        array_pop($fromSinu);
                    }
                    $fromSinuKeys = array('status', 'nume', 'prenume', 'facultatea', 'catedra', 'cod_an', 'grupa');
                    if(array_combine($fromSinuKeys, $fromSinu) != false) {
                        $fromSinu = array_combine($fromSinuKeys, $fromSinu);
                        
                        if($this->Admin->diffUpdate($fromLdap['LdapUser'], $fromSinu))
                        {
                            $result .= "A fost actualizat utilizatorul ".$fromSinu['nume']." ".$fromSinu['prenume']." ID: ".$fromLdap['LdapUser']['uidnumber']." UID: ".$fromLdap['LdapUser']['uid']."\n";
                            //pr($this->Admin->getByUid($fromLdap['LdapUser']['uidnumber']));
                        }
                    }
                }
                else
                    $result .= "Eroare la conectarea cu SINU!";
            
            }
            else
                $this->redirect(array('controller' => 'admins', 'action' => 'index'));
        
        return $result;
        }
        
    }
?>