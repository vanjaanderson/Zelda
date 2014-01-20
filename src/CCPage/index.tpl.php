<?php if(isset($content['id'])):?>
  <h1><?=esc($content['title'])?><!--<span class='headerlink'><a href='<?=create_url('content', 'create')?>'>skapa ny sida</a></span>--></h1>
  <p><?=$content->GetFilteredData()?></p>
  <p class='smaller-text silent'><a href='<?=create_url("content/edit/{$content['id']}")?>'>redigera</a> | <a href='<?=create_url("content/{$content['page']}")?>'>visa alla</a></p>
<?php else:?>
  <h2 class="error">404: Sidan existerar inte<span class='headerlink'><!--<a href='<?=create_url('content', 'create')?>'>skapa ny sida</a></span>--></h2>
<?php endif;?>