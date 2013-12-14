<?php if($content['id']):?>
  <h1><?=esc($content['title'])?></h1>
  <p><?=$content->GetFilteredData()?></p>
  <p class='smaller-text silent'><a href='<?=create_url("content/edit/{$content['id']}")?>'>ändra</a> | <a href='<?=create_url("content")?>'>visa alla</a></p>
<?php else:?>
  <p>404: Sidan finns inte.</p>
<?php endif;?>

