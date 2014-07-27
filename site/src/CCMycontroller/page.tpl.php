<?php if($content['id']):?>
  <h1><?=esc($content['title'])?></h1>
  <?=$content->GetFilteredData()?>
  <p class='smaller-text silent'>
  	<?php if($is_authenticated): ?>
	  	<a href='<?=create_url('content', 'create')?>'>Skapa ny sida</a> | <a href='<?=create_url("content/edit/{$content['id']}")?>'>Redigera sidan</a> | 
	<?php endif;?>
	<a href='<?=create_url("page/viewall")?>'>Visa alla sidor</a></p>
<?php else:?>
  <p>404: Sidan finns inte.</p>
<?php endif;?>
