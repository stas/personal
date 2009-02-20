<div class="login">
    <h2>Autentificare</h2>
    <?php echo $form->create('User', array('action' => 'login')); ?>
        <?php echo $form->input('username'); ?>
        <?php echo $form->input('password'); ?>
        <?php echo $form->submit('Trimite'); ?>
    <?php echo $form->end(); ?>
</div>