<div id="meniu">
    <ul>
        <li><?php echo $html->link('Deconectare', array('controller' => 'users', 'action' => 'logout')); ?></li>
        <li><?php echo $html->link('Fișiere', array('controller' => 'ifiles', 'action' => 'index')); ?></li>
        <li><?php echo $html->link('Admin', array('controller' => 'admins', 'action' => 'index')); ?></li>
    </ul>
</div>
<div id="continut">
    <h3>Salut <?php echo $utilizator['name'];?></h3>
    <h3>Bine ați venit pe intranet.utcluj.ro!</h3>
    <div id="calendar"></div>
    <div style="width: 60%; margin: 0 auto;">
        <div id="bloc" class="dreapta" style="width: 50%; float: right; font-size: 11px;">
            <h3><a href="<?=$feed_utcn['link'];?>" title="<?=$feed_utcn['description'];?>"><?=$feed_utcn['title'];?></a></h3>
            <ul clas="bloc list">
                <?php
                    foreach($feed_utcn['Item'] as $items)
                    {
                        echo "<li class=\"item\"><a href=\"".$items['link']."\">".$items['title']."</a></li>";
                    }
                ?>  
            </ul>
        </div>
        <div id="bloc" class="stanga" style="width: 50%; float: left; font-size: 11px;">
            <h3><a href="<?=$feed_forum['link'];?>" title="<?=$feed_forum['description'];?>"><?=$feed_forum['title'];?></a></h3>
            <ul clas="bloc list">
                <?php
                    foreach($feed_forum['Item'] as $items)
                    {
                        echo "<li class=\"item\"><a href=\"".$items['link']."\">".$items['title']."</a></li>";
                    }
                ?>  
            </ul>
        </div>
    </div>
</div>