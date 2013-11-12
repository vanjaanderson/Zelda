<?php if($content['id']):?>
  <h1><?=$content['title']?></h1>
  <p><?=$content['data']?></p>
  <p class='smaller-text silent'><a href='<?=create_url("content/edit/{$content['id']}")?>'>redigera</a> <a href='<?=create_url("content")?>'>visa alla</a></p>
<?php else:?>
  <p>404: Sidan existerar inte.</p>
<?php endif;?>