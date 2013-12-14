<h1>Min gästbok</h1>
<p>Lämna ett meddelande i min fina gästbok.</p>

<?=$form->GetHTML()?>

<h2>Senaste meddelanden</h2>

<?php foreach($entries as $val):?>
<div style='background-color:#f6f6f6;border:1px solid #ccc;margin-bottom:1em;padding:1em;'>
  <p>Datum: <?=$val['created']?></p>
  <p><?=htmlent($val['entry'])?></p>
</div>
<?php endforeach;?>
