<?php echo $html->link('Autentificare', array('controller' => 'candidate', 'action' => 'login')); ?>
<?php
    echo $form->create('Candidate',array('action'=>'register')) . "\n";
    echo $form->input('email',array('after'=>$form->error('username_taken_error','Acest email este folosit deja.'))) . "\n";
    echo $form->input('password',array('value'=>''));
    echo $form->input('password_confirm', array('value'=>'','type'=>'password','error'=>'Parolele nu corespund.')) . "\n";
    echo $form->input('fname', array('label' => 'Numele')) . "\n"; 
    echo $form->input('sname', array('label' => 'Prenumele')) . "\n"; 
    echo $form->input('birthdate', array( 'label' => 'Ziua de nastere'
                                , 'type' => 'date'
                                , 'dateFormat' => 'DMY'
                                , 'minYear' => date('Y') - 70
                                , 'maxYear' => date('Y') - 18
                                )
                    ) . "\n";
    echo $form->input('country', array('label' => 'Tara', 'type' => 'hidden')) . "\n"; //text
    echo $form->input('county', array('label' => 'Judetul', 'type' => 'select')) . "\n"; //text
    echo $form->input('location', array('label' => 'Orasul')) . "\n"; //text
    echo $form->input('address', array('label' => 'Adresa', 'type' => 'textarea')) . "\n"; //textarea
    echo $form->input('tel', array('label' => 'Telefon')) . "\n"; //text
    echo $form->input('secemail', array('label' => 'Adresa email secundar')) . "\n"; //text

    echo $form->end('Inregistrare') . "\n";
?>