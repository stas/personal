<?php
    class IfilesController extends AppController {
        
        var $name = 'Ifiles';
        var $uses = array('User', 'Ifile');
        
        var $helpers = array(
            'Html',
            'Form',
            'Javascript'
        );
        
        /**
         *  Functia genereaza pagina de acasa cu fisiere
         */
        function index ()
        {
            $files = $this->Ifile->findAllByOwner($this->Session->read(array('User','id')));
            $this->set('files', $files);
        }
        
        /**
         *  Filtru pentru verificarea sesiunii utilizatorilor
         */
        function beforeFilter()
        {
            if(!$this->Session->check('User'))
                $this->redirect(array('controller'=>'users', 'action'=>'login'));
        }
        
        /**
         *  Functia coordoneaza incarcarea fisierelor
         */
        function add()
        {
            $user['username'] = $this->Session->read(array('User','username'));
            $user['id'] = $this->Session->read(array('User','id'));
            
            if(!empty($this->data))
                $results = $this->Ifile->addFile($this->data['Ifile'], $user);
            
            if(!empty($results))
                $this->set('results', $results);
        }
        
        /**
         *  Functia coordoneaza descarcarea fisierelor
         *  param: id-ul fisierului
         */
        function get($fid)
        {
            $file = $this->Ifile->findById($fid);
            $this->set('filename', $file['Ifile']['name']);
        }
 
    }
?>