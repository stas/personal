<div id="meniu">
    <ul>
        <li><?php echo $html->link('Deconectare', array('controller' => 'users', 'action' => 'logout')); ?></li>
        <li><?php echo $html->link('Acasă', array('controller' => 'users', 'action' => 'index')); ?></li>
    </ul>
</div>
<div id="admin" class="admin">
    <h2>Panoul de Administrare INTRANET</h2>
    <h3>Sincronizare automata LDAP cu SINU</h3>
    <div class="mesaj">
        <p>Atenție! Durează!</p>
        <p>Se recomandă să fie actualizate maxim 1000 de intrări/cerere</p>
        <p>Acum sunt <?=$largestUid?> de intrări în LDAP</p>
    </div>
    <div class="formular">
        <?php echo $form->create('Admin', array('action' => 'updateldap_rec', 'type' => 'GET'))."\n"; ?>
            <?php echo $form->input('from', array('label' => 'Începând cu' ))."\n"; ?>
            <?php echo $form->input('to', array('label' => 'Terminând cu' ))."\n"; ?> 
        <?php echo $form->end('Sincronizare automata LDAP cu SINU')."\n"; ?>
    </div>
</div>