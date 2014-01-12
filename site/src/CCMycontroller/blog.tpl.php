<h1>Min blogg<?php if($is_authenticated): ?><span class='headerlink'><a href='<?=create_url('blog', 'create')?>'>skapa nytt inlägg</a></span><?php endif;?></h1>

<?php if($contents != null):?>
  <?php foreach($contents as $val):?>
    <h2><?=esc($val['title'])?></h2>
    <p class='smaller-text'><em>Publicerat den <?=$val['created']?> av <?=$val['owner']?></em></p>
    <?=filter_data($val['data'], $val['filter'])?>
    <?php if($is_authenticated): ?>
    	<p class='smaller-text silent inline-link'><a href='<?=create_url("content/edit/{$val['id']}")?>'>redigera</a> | </p>
    <?php endif;?>
    <p class="smaller-text silent inline-link"><a href='<?=create_url("blog/view/{$val['id']}")?>'>visa</a></p>
  <?php endforeach; ?>
<?php else:?>
  <h2>Det finns inga inlägg</h2>
<?php endif;?>



