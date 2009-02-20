<?php
    class Ifile extends AppModel {
       var $name = 'Ifile';

        /**
         *  Metoda incarca fisierele si salveaza detaliile in baza de date
         *  param: numele fisierului citit din $this->data si numele utilizatorului
         *  citit din sesiune.
         *  return: rezultatul incarcarii fisierului.
         */
       function addFile($file, $user)
        {
            // numele utilizatorului va fi folosit la crearea directorului personal
            // unde vor si fi salvate toate fisierele
            $userfolder = $user['username'];
            $targetDir = WWW_ROOT.'data/'.$userfolder;
            // numele fisierului in sine
            $theFile = $file['file'];
            
            $message = 'Fișierul nu a fost salvat!'; // incepem cu stangu
            if(!empty($file))
            {
               // verificarea existentei datelor
                if(empty($file['description']) || empty($file['file']['name']))
                    $message = 'Specificarea unui fișier și descrierea acestuia este obligatorie!';
                else
                {
                  // incarcarea in sine
                  $savedFile = $this->uploadFile($targetDir, $theFile);
                  // verificam succesul
                    if(empty($savedFile) == false)
                    {
                     // se creaza obiectul cu detaliile ce vor fi salvate in baza de date
                        $newfile->description = $file['description'];
                        $newfile->owner = $user['id'];
                        $newfile->name  = substr($savedFile, strlen(WWW_ROOT));
                        // tot timpul adaugam fisiere, deci nu facem update!!!
                        $this->create($newfile);
                        $this->save();
                        $message = 'Fișierul a fost salvat!'; // pentru a termina cu dreptul
                    }
                }
            }
            return $message;
        }
        
        /**
         *  Metoda face incarcarea fisierelor si verificare dupa tip
         *  param: locatia fisierului si fisierul in sine
         *  return: locatia cu fisierul salvat
         */
        function uploadFile($toFolder, $theFile)
        {
         // tipurile de fisiere interzise
            $deniedFiles = array('application/x-httpd-php', 'text/x-script.perl', 'application/x-bsh', 'application/x-sh', 'application/x-cd-image');
            // cream noua locatie daca nu exista
            if(!is_dir($toFolder))
                mkdir($toFolder);
            // nu vrem fisiere ce contin spatii
            $theFile['name'] = str_replace(' ', '_', $theFile['name']);
            $fileIsOK = false; // iarasi incepem cu stangu
            
            // verificare daca tipul este permis
            foreach($deniedFiles as $type)
            {  
               if($type == $theFile['type'])
               {
                  $fileIsOK = false;
                  break;
               }
               else
                  $fileIsOK = true; // pentru a incheia cu dreptul
            }
            
            $savedFile = false;
            if($fileIsOK)
            // verificari daca nu exista deja un astfel de fisier
                if(!file_exists($toFolder.'/'.$theFile['name']))
                {
                    if(move_uploaded_file($theFile['tmp_name'], $toFolder.'/'.$theFile['name']))
                        $savedFile = $toFolder.'/'.$theFile['name'];
                }
            // daca exista, redenumim punanand in fata timpul in unix si iara salvam
                else if(file_exists($toFolder.'/'.$theFile['name']))
                {
                    $theFile['name'] = time().$theFile['name'];
                    if(move_uploaded_file($theFile['tmp_name'], $toFolder.'/'.$theFile['name']))
                        $savedFile = $toFolder.'/'.$theFile['name'];
                }
            return $savedFile; // am incheiat
        }
        
    }
?>