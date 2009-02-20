<?php
    echo $form->create('Education',array('url' => array('controller' => 'profiles', 'action'=>'index'))) . "\n";
    echo $form->input('name', array('label' => 'Numele institutiei')) . "\n"; 
    echo $form->input('diploma', array('label' => 'Diploma', 'type' => 'textarea')) . "\n"; //textarea
    echo $form->input('startdate', array( 'label' => 'Data inceperii'
                                , 'type' => 'date'
                                , 'dateFormat' => 'Y'
                                , 'minYear' => date('Y') - 70
                                , 'maxYear' => date('Y') - 1
                                )
                    ) . "\n";
    echo $form->input('enddate', array( 'label' => 'Data incheierii'
                                , 'type' => 'date'
                                , 'dateFormat' => 'Y'
                                , 'minYear' => date('Y') - 70
                                , 'maxYear' => date('Y')
                                )
                    ) . "\n";
    echo $form->input('details', array('label' => 'Principalele aspecte studiate', 'type' => 'textarea')) . "\n"; //textarea

    echo $form->end('Adauga') . "\n";
?>