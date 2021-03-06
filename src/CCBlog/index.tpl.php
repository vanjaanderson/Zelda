<?php if($contents != null):?>
  <?php foreach($contents as $val):?>
    <h1><?=esc($val['title'])?></h1>
    <p class='smaller-text' style="margin:-1em 0 2em 0;"><em>Publicerad <?=$val['created']?>, av <?=$val['owner']?></em></p>
    <?=filter_data($val['data'], $val['filter'])?>
    <p class='smaller-text silent'><a href='<?=create_url('content', 'create')?>'>Skapa ny sida</a> | <a href='<?=create_url("content/edit/{$content['id']}")?>'>Redigera denna sida</a> | <a href='<?=create_url("content/{$content['page']}")?>'>Visa alla sidor</a></p>
  <?php endforeach; ?>
<?php else:?>
  <h2 class="error">Det finns inga inlägg</h2>
<?php endif;?>