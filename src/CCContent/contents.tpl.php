<h1>Innehåll<!--<span class='headerlink'><a href='<?=create_url('content', 'create')?>'>skapa nytt innehåll</a></span>--></h1>
<p>Skapa, redigera och visa innehåll.</p>

<h2>Alla sidor</h2>
<?php if($pages != null):?>
  <ul>
  <?php foreach($pages as $val):?>
    <li>
    	(<?=esc($val['id'])?>) <?=esc($val['title'])?>, av <?=$val['owner']?> | <a class="smaller-text" href='<?=create_url("content/edit/{$val['id']}")?>'>Redigera</a> | <a class="smaller-text" href='<?=create_url("page/view/{$val['id']}")?>'>Visa</a>
    </li>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>Det finns inget innehåll.</p>
<?php endif;?>

<h2>Alla blogginlägg</h2>
<?php if($posts != null):?>
  <ul>
  <?php foreach($posts as $val):?>
    <li>
      (<?=esc($val['id'])?>) <?=esc($val['title'])?>, av <?=$val['owner']?> | <a class="smaller-text" href='<?=create_url("content/edit/{$val['id']}")?>'>Redigera</a> | <a class="smaller-text" href='<?=create_url("page/view/{$val['id']}")?>'>Visa</a>
    </li>
  <?php endforeach; ?>
  </ul>
<?php else:?>
  <p>Det finns inget innehåll.</p>
<?php endif;?>