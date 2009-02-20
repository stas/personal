<div id="menu-jos">
        <ul id="menu">
                <li><a href="" target="_self" title="sample">Bun venit</a></li>
                <li><?php echo $html->link('Modificare parola', array('controller' => 'candidate', 'action' => 'change_pass'), array('class' => 'current')); ?></li>
                <li><?php echo $html->link('Recuperare parola', array('controller' => 'candidate', 'action' => 'recover_pass')); ?></li>
                <li><?php echo $html->link('Profil', array('controller' => 'candidate', 'action' => 'profile')); ?></li>
                <li><?php echo $html->link('Deautentificare', array('controller' => 'candidate', 'action' => 'logout')); ?></li>
        </ul>
</div>

<div class="changepass">
<h2>Modificare parola</h2>    
    <?php echo $form->create('Candidate', array('action' => 'change_pass'));?>
        <?php echo $form->input('email', array('label' => 'Adresa email'));?>
        <?php echo $form->input('newpass', array('label' => 'Noua parola', 'type' => 'password'));?>
        <?php echo $form->submit('Modificare');?>
    <?php echo $form->end(); ?>
</div> 