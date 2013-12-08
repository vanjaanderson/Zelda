<h1>Modulhanterare</h1>


<h2>Om modulhanteraren</h2>
<p>
	<strong>Modulhanteraren</strong> visar information om vilka moduler som finns i Zelda, och hanterar dessa. Zelda är uppbyggt av moduler och varje modul har sin 
	egen mapp i <code>src</code>-mappen.
</p>

<h2>Hantera Zeldas moduler</h2>
<p>
	En modul kan implementera interfacet <code>IModule</code> som gör den hanterbar. Zelda erbjuder ett administrationsgränssnitt för dessa. 
	Du kan administrera moduler med nedanstående interface:
</p>
<ul>
  <li><a href='<?=create_url('module/install')?>'>installera</a></li>
</ul>

<h2>Aktiverade controllers</h2>
<p>
	Controllerna skapar det lokala API:t för denna webbplats. Här är en lista över alla aktiva controllers och deras metoder. Du aktiverar och/eller inaktiverar controllers i  
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
