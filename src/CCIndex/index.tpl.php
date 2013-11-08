<h1>Indexkontroller</h1>
<p>Detta kan du göra.</p>

<?php foreach($menu as $val): ?>
<li><a href='<?=create_url($val)?>'><?=$val?></a>  
<?php endforeach; ?>		
