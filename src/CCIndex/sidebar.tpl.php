<div class='box'>
<h4>Controllers och metoder</h4>

<p>
	Följande controller finns. Du aktiverar och/eller avaktiverar dem i  
	<code>site/config.php</code>.
</p>

<ul>
<?php foreach($controllers as $key => $val): ?>
  <li><a href='<?=create_url($key)?>'><?=$key?></a></li>

  <?php if(!empty($val)): ?>
  <ul>
  <?php foreach($val as $method): ?>
    <li><a href='<?=create_url($key, $method)?>'><?=$method?></a></li> 
  <?php endforeach; ?>		
  </ul>
  <?php endif; ?>
  
<?php endforeach; ?>		
</ul>
</div>
