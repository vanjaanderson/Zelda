<div id="sidebarbox" class="box">

  <?php if($is_authenticated): ?> 
  <h3>Con&shy;troll&shy;ers och metod&shy;er</h3>

  <p>
  	Följande controller finns. Du aktiverar och/eller avaktiverar dem i  
  	<code>site/config.php</code>.
  </p>
 
  <?php foreach($controllers as $key => $val): ?>  
    <hr />

    <h4><a href='<?=create_url($key)?>'><?=$key?></a></h4>

    <?php if(!empty($val)): ?>
    <ul>
    <?php foreach($val as $method): ?>
      <li><a href='<?=create_url($key, $method)?>'><?=$method?></a></li> 
    <?php endforeach; ?>		
    </ul>
    <?php endif; ?> 
  <?php endforeach; ?>
<?php else: ?>
   
  <?php foreach($contents as $val):?>
    <h1><?=esc($val['title'])?></h1>
    <p class='smaller-text' style="margin:-1em 0 2em 0;"><em>Publicerad <?=$val['created']?>, av <?=$val['owner']?></em></p>
    <?=filter_data($val['data'], $val['filter'])?>
    <p class='smaller-text silent'><a href='<?=create_url('content', 'create')?>'>Skapa ny sida</a> | <a href='<?=create_url("content/edit/{$content['id']}")?>'>Redigera denna sida</a> | <a href='<?=create_url("content/{$content['page']}")?>'>Visa alla sidor</a></p>
  <?php endforeach; ?>

<?php endif; ?> 

</div>