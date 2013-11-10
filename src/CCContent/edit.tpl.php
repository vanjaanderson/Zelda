<?php if($content['created']): ?>
  <h1>Redigera innehåll</h1>
  <p>Du kan redigera och spara detta innehåll.</p>
<?php else: ?>
  <h1>Skapa innehåll</h1>
  <p>Här kan du skapa nytt innehåll.</p>
<?php endif; ?>


<?=$form->GetHTML(array('class'=>'content-edit'))?>

<p class='smaller-text'><em>
<?php if($content['created']): ?>
  Innehållet skapades av <?=$content['owner']?>, <?=$content['created']?>.
<?php else: ?>
  Innehållet är inte sparat än.
<?php endif; ?>

<?php if(isset($content['updated'])):?>
  Senast uppdaterat <?=$content['updated']?>.
<?php endif; ?>
</em></p>

<a href='<?=create_url('content')?>'>Visa allt innehåll</a>