<?php
    echo $html->css('thickbox', true);
    
    if(isset($javascript)):
            echo $javascript->link('jquery.pack.js', false);
            echo $javascript->link('thickbox-compressed.js', false);
    endif;
?>

<h3>Profilul personal</h3>
<div id="menu-jos">
        <ul id="menu">
                <li><a href="" target="_self" title="sample">Bun venit</a></li>
                <li><?php echo $html->link('Modificare parola', array('controller' => 'candidate', 'action' => 'change_pass')); ?></li>
                <li><?php echo $html->link('Recuperare parola', array('controller' => 'candidate', 'action' => 'recover_pass')); ?></li>
                <li><?php echo $html->link('Profil', array('controller' => 'candidate', 'action' => 'profile'), array('class' => 'current')); ?></li>
                <li><?php echo $html->link('Deautentificare', array('controller' => 'candidate', 'action' => 'logout')); ?></li>
        </ul>
</div>
<p>
    <?php echo $html->link('Actualizare profil', array('action' => 'update')); ?>
    <ul>
        <li>Nume: <span><?=$profile['fname']?></span></li>
        <li>Prenume: <span><?=$profile['sname']?></span></li>
        <li>Ziua de nastere: <span><?=$profile['birthdate']?></span></li>
        <li>Adresa: <span><?=$profile['address']?></span></li>
        <li>Locatia: <span><?=$profile['location']?></span></li>
        <li>Judetul: <span><?=$profile['county']?></span></li>
        <li>Telefon: <span><?=$profile['tel']?></span></li>
        <li>Email secundar: <span><?=$profile['secemail']?></span></li>
        <li>About: <span><?=$profile['about']?></span></li>
        <li>Studii auxiliare: <span><?=$profile['auxstudies']?></span></li>
        <li>Competente: <span><?=$profile['competences']?></span></li>
    </ul>
</p>
<p class="education">
    <?php
        echo $html->link('Adauga educatie', '/candidate/profile/education', array('class' => 'thickbox'))
    ?>
    
    <ol class="educations">
        <?php
            foreach ($educations as $education) {
                echo "<li>";
                echo $education['Education']['name']." din ".$education['Education']['startdate']." pana in ".$education['Education']['enddate'];
                echo "<span>".$education['Education']['diploma']."</span>";
                echo "<span>".$education['Education']['details']."</span>";
                echo "</li>";
            }
        ?>
    </ol>
</p>