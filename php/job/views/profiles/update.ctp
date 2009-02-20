<div id="menu-jos">
        <ul id="menu">
                <li><a href="" target="_self" title="sample">Bun venit</a></li>
                <li><?php echo $html->link('Modificare parola', array('controller' => 'candidate', 'action' => 'change_pass')); ?></li>
                <li><?php echo $html->link('Recuperare parola', array('controller' => 'candidate', 'action' => 'recover_pass')); ?></li>
                <li><?php echo $html->link('Profil', array('controller' => 'candidate', 'action' => 'profile'), array('class' => 'current')); ?></li>
                <li><?php echo $html->link('Deautentificare', array('controller' => 'candidate', 'action' => 'logout')); ?></li>
        </ul>
</div>
<p class="updateprofile">
<?php
    if(empty($profile)) {
        echo $form->create('Profile', array('action' => 'update'));
        echo $form->input('fname', array('label' => 'Numele')); //text
        echo $form->input('sname', array('label' => 'Prenumele')); 
        echo $form->input('birthdate', array( 'label' => 'Ziua de nastere'
                                    , 'type' => 'date'
                                    , 'dateFormat' => 'DMY'
                                    , 'minYear' => date('Y') - 70
                                    , 'maxYear' => date('Y') - 18
                                    )
                        ); 
        echo $form->input('country', array('label' => 'Tara', 'type' => 'hidden')); //text
        echo $form->input('county', array('label' => 'Judetul', 'type' => 'select')) . "\n"; //text
        echo $form->input('location', array('label' => 'Orasul')); //text
        echo $form->input('address', array('label' => 'Adresa', 'type' => 'textarea')); //textarea
        echo $form->input('tel', array('label' => 'Telefon')); //text
        echo $form->input('secemail', array('label' => 'Adresa email secundar')); //text
        echo $form->input('about', array('label' => 'Scurta descriere', 'type' => 'textarea')); //text
        echo $form->input('auxstudies', array('label' => 'Alte cursuri', 'type' => 'textarea')); //text
        echo $form->input('competences', array('label' => 'Competente, abilitati', 'type' => 'textarea')); //text
        echo $form->end('Trimite'); 
    }
    else {
        $profile['birthdate'] = array_reverse(array_combine(array('year','month','day'),explode('-',$profile['birthdate'])));
        echo $form->create('Profile', array('action' => 'update'));
        echo $form->input('fname', array('label' => 'Numele', 'default' => $profile['fname'])); //text
        echo $form->input('sname', array('label' => 'Prenumele', 'default' => $profile['sname'])); 
        echo $form->input('birthdate', array( 'label' => 'Ziua de nastere'
                                    , 'type' => 'date'
                                    , 'dateFormat' => 'DMY'
                                    , 'minYear' => date('Y') - 70
                                    , 'maxYear' => date('Y') - 18
                                    , 'selected' => $profile['birthdate']
                                    )
                        );  
        echo $form->input('country', array('label' => 'Tara', 'type' => 'hidden', 'default' => $profile['country'])); //text
        echo $form->input('county', array('label' => 'Judetul', 'default' => $profile['county'])); //text
        echo $form->input('location', array('label' => 'Orasul', 'default' => $profile['location'])); //text
        echo $form->input('address', array('label' => 'Adresa', 'type' => 'textarea', 'value' => $profile['address'])); //textarea
        echo $form->input('tel', array('label' => 'Telefon', 'default' => $profile['tel'])); //text
        echo $form->input('secemail', array('label' => 'Adresa email secundar', 'default' => $profile['secemail'])); //text
        echo $form->input('about', array('label' => 'Scurta descriere', 'type' => 'textarea', 'value' => $profile['about'])); //text
        echo $form->input('auxstudies', array('label' => 'Alte cursuri', 'type' => 'textarea', 'value' => $profile['auxstudies'])); //text
        echo $form->input('competences', array('label' => 'Competente, abilitati', 'type' => 'textarea', 'value' => $profile['competences'])); //text
        echo $form->end('Trimite');
    }
?>
</p>