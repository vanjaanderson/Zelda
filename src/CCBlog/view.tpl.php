<h1>Inlägg<!--<span class='headerlink'><a href='<?=create_url('content', 'create')?>'>skapa nytt inlägg</a></span>--></h1>
<p>Skapa, redigera och visa innehåll.</p>

<h2>Alla inlägg</h2>
<?php if($content != null):?>
  <ul>
  <?php foreach($content as $val):?>
    <li>
    	(<?=esc($val['id'])?>) <?=esc($val['title'])?>, av <?=$val['owner']?> | <a class="smaller-text" href='<?=create_url("content/edit/{$val['id']}")?>'>redigera</a> | <a class="smaller-text" href='<?=create_url("page/view/{$val['id']}")?>'>visa</a>
    </li>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>Det finns inget innehåll.</p>
<?php endif;?>