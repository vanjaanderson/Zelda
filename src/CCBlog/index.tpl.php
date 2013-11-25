<h1>Blogg</h1>
<p>En lista på alla blogginlägg, innehåll av typen "post". <a href='<?=create_url("content")?>'>Visa allt innehåll</a>.</p>

<?php if($contents != null):?>
  <?php foreach($contents as $val):?>
    <h2><?=esc($val['title'])?></h2>
    <p class='smaller-text'><em>Publicerad <?=$val['created']?>, av <?=$val['owner']?></em></p>
    <p><?=filter_data($val['data'], $val['filter'])?></p>
    <p class='smaller-text silent'><a href='<?=create_url("content/edit/{$val['id']}")?>'>Redigera</a></p>
  <?php endforeach; ?>
<?php else:?>
  <p>Det finns inga inlägg.</p>
<?php endif;?>