<?php if(isset($content['id'])):?>
  <h1><?=esc($content['title'])?></h1>
  <p><?=$content->GetFilteredData()?></p>
  <p class='silent'><a href='<?=create_url('content', 'create')?>'>Skapa ny sida</a> | <a href='<?=create_url("content/edit/{$content['id']}")?>'>Redigera denna sida</a> | <a href='<?=create_url("content/{$content['page']}")?>'>Visa alla sidor</a></p>
<?php else:?>
  <h2 class="error">404: Sidan existerar inte<span class='headerlink'></h2>
<?php endif;?>