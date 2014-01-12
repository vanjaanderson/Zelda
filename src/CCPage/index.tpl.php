<?php if($content['id']):?>
  <h1><?=esc($content['title'])?></h1>
  <p><?=$content->GetFilteredData()?></p>
  <p class='smaller-text silent'><a href='<?=create_url("content/edit/{$content['id']}")?>'>redigera</a> | <a href='<?=create_url("content/{$content['page']}")?>'>visa alla</a></p>
<?php else:?>
  <h2 class="error">404: Sidan existerar inte</h2>
<?php endif;?>