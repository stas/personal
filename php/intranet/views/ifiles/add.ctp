<h4><?=$html->link('Afișare lista fișierelor', array("controller"=>"ifiles", "action"=>"index"))?></h4>
<div class="mesaj">
  <?php if(!empty($results)) echo $results; ?>  
</div>
<div class="upload">
    <?=$form->create('Ifile',array('action'=>'add','name'=>'adauga_fisier', 'id'=>'adauga_fisier', 'type'=>'file')); ?>
    <fieldset>
        <legend>Publicați un fișier nou</legend>
        <?=$form->input('description',array('label'=>'Descriere'));?>
        <?=$form->input('file',array('label'=>'Fișier', 'type'=>'file'));?>
    </fieldset>
    <?=$form->end('Submit');?>
</div>