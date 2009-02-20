<div class="recover">
<?php echo $html->link('Autentificare', array('controller' => 'candidate', 'action' => 'login')); ?>
<h2>Recuperare parola</h2>    
    <?php echo $form->create('Candidate', array('action' => 'recover_pass'));?>
        <?php echo $form->input('email', array('label' => 'Adresa email'));?>
        <?php echo $form->submit('Recuperare');?>
    <?php echo $form->end(); ?>
</div> 