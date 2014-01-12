<h1>Min gästbok</h1>
<p>Lämna ett meddelande i min fina gästbok.</p>

<?=$form->GetHTML()?>

<h2>Meddelanden</h2>

<?php foreach($entries as $val):?>
<div class='infobox'>
  <p>Datum: <?=$val['created']?></p>
  <p><?=htmlent($val['entry'])?></p>
</div>
<?php endforeach;?>
