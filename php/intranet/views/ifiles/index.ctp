<div id="meniu">
    <ul>
        <li><?php echo $html->link('Deconectare', array('controller' => 'users', 'action' => 'logout')); ?></li>
        <li><?php echo $html->link('Acasă', array('controller' => 'users', 'action' => 'index')); ?></li>
        <li><?php echo $html->link('Admin', array('controller' => 'admins', 'action' => 'index')); ?></li>
    </ul>
</div>
<h3>Lista fișierelor încărcate</h3>
<h4><?=$html->link('Adăugare fișier nou', array("controller"=>"ifiles", "action"=>"add"))?></h4>
<div id="listafisiere">
    <ul class="lista">
        <?php
            foreach($files as $item)
                echo "<li><a href=\"/ifiles/get/".$item['Ifile']['id']."\">".$item['Ifile']['description']."</a></li>"."\n";
        ?>
    </ul>
</div>