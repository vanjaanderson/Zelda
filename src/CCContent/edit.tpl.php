<?php if($content['created']): ?>
  <h1>Redigera innehåll</h1>
  <p>Du kan redigera och spara detta innehåll.</p>
<?php else: ?>
  <h1>Skapa innehåll</h1>
  <p>Här skapar du blogginlägg <em>(post)</em> eller sida <em>(page)</em>. Fält markerade med &lowast; är obligatoriska.</p>
<?php endif; ?>


<?=$form->GetHTML(array('class'=>'content-edit'))?>

<p class='smaller-text'><em>
<?php if($content['created']): ?>
  Innehållet skapades av <?=$content['owner']?>, för <?=time_diff($content['created'])?> sedan.
<?php else: ?>
  Innehållet är inte sparat än.
<?php endif; ?>

<?php if(isset($content['updated'])):?>
  Senast uppdaterat för <?=time_diff($content['updated'])?> sedan.
<?php endif; ?>
</em></p>

<p class="smaller-text">
	<a href='<?=create_url('content', 'create')?>'>Skapa nytt innehåll</a> |
	<a href='<?=create_url('page', 'view', $content['id'])?>'>Visa detta innehåll</a> |
	<a href='<?=create_url("content")?>'>Visa allt</a>
</p>