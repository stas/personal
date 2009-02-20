<div class="login">
<?php echo $html->link('Inregistrare', array('controller' => 'candidate', 'action' => 'register')); ?>
<h2>Login</h2>    
    <?php echo $form->create('Candidate', array('action' => 'login'));?>
        <?php echo $form->input('email', array('label' => 'Adresa email'));?>
        <?php echo $form->input('password', array('label' => 'Parola'));?>
        <?php echo $form->submit('Autentificare');?>
    <?php echo $form->end(); ?>
</div> 