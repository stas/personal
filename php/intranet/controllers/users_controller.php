<?php
    class UsersController extends AppController
    {
        var $name = 'Users';
        var $helpers = array('Html', 'Form', 'Javascript');
        var $uses = array('User');
        /*
         *  Prima pagina
         */
        
        function index()
        {
            // Informatii utilizator autentificat
            $user_info = $this->Session->read('User');
            $this->set('utilizator', $user_info);
            
            // Ultimele stiri de pe prima pagina
            $feed_utcn = $this->parse_xml('http://utcluj.ro/feeds/');
            $this->set('feed_utcn', $feed_utcn);
            
            // Ultimele stiri de pe forum
            $feed_forum = $this->parse_xml('http://intranet.utcluj.ro/forum/feed/index.php');
            $this->set('feed_forum', $feed_forum);            
        }
        
        /*
         *  Filtru pentru verificarea sesiunii utilizatorilor
         */
        function beforeFilter()
        {
            $this->__validateLoginStatus();
        }
        
        /*
         *  Autentificarea in sine
         */
        function login()
        {
            if(empty($this->data['User']['username']) == false && empty($this->data['User']['password']) == false)
            {
                $user = $this->User->validateLogin($this->data);
                if(empty($user) == false)
                {
                    $this->Session->write('User',$user);
                    $this->Session->setFlash('Autentificare cu succes.');
                    $this->redirect('index');
                    exit();
                }
                else
                {
                    $this->Session->setFlash('Datele pentru autentificare sunt incorecte.');
                    exit();
                }
            }
            else if($this->referer() != '/')
                $this->Session->setFlash('Se cere completarea câmpurilor pentru autentificare.');
        }
        
        /*
         *  Stergerea sesiunii, adica deautentificarea
         */
        function logout()
        {
            $this->Session->destroy('user');
            $this->Session->setFlash('Deconectare cu succes.');
            //$this->redirect('/users/login');
        }
        
        /*
         *  Filtru ce este apelat la fiecare vizualizare a unei pagini
         *  ce necesita autentificarea. Aceasta valideaza autentificarea.
         */
        function __validateLoginStatus()
        {
            if($this->action != 'login' && $this->action != 'logout')
            {
                if($this->Session->check('User') == false)
                {
                    $this->redirect('login');
                    $this->Session->setFlash('Se cere autentificarea pentru a accesa pagina.');
                }
            }
        }
        
        /*
         *  Functia este folosita la parsarea fisierelor xml, in special de tip RSS2.0
         *  param: fisierul sau adresa web a fisierului xml
         *  return: un array cu datele din RSS
         */
        function parse_xml($file)
        {
            App::import('Xml');
            
            $parsed_xml = new XML($file);
            // Conversie din obiect in array. E mai simplu de extras datele si parcurs.
            $parsed_xml = Set::reverse($parsed_xml);
            
            //debug($parsed_xml);
            
            // Scapam de namespace-urile RSS-ului, pastram doar continutul interesant
            foreach($parsed_xml as &$data)
            {
                foreach($data as $feed)
                {
                    continue;
                }
                
            }
            return $feed;
        }
        
    }
?>