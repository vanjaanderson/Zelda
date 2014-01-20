<?php if($content['id']):?>
  <h1><?=esc($content['title'])?><?php if($is_authenticated): ?><span class='headerlink'><a href='<?=create_url('content', 'create')?>'>skapa ny sida</a></span><?php endif;?></h1>
  <?=$content->GetFilteredData()?>
  <p class='smaller-text silent'>
  	<?php if($is_authenticated): ?>
	  	<a href='<?=create_url("content/edit/{$content['id']}")?>'>ändra</a> | 
	<?php endif;?>
	<a href='<?=create_url("page/viewall")?>'>visa alla sidor</a></p>
<?php else:?>
  <p>404: Sidan finns inte.</p>
<?php endif;?>
