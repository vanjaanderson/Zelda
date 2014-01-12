<div class='box'>
<h3>Controllers och metoder</h3>

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

</div>
