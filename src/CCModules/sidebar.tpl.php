<div class='box'>
<h4>Alla moduler</h4>
<p><em>Alla Zeldas moduler:</em></p>
  <ul>
    <?php foreach($modules as $module): ?>
      <li><?=$module['name']?></li>
    <?php endforeach; ?>
  </ul>
</div>

<div class='box'>
<h4>Zelda Core</h4>
<p><em>Moduler i Zelda Core:</em></p>
  <ul>
    <?php foreach($modules as $module): ?>
      <?php if($module['isZeldaCore']): ?>
      <li><?=$module['name']?></li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</div>

<div class='box'>
<h4>Zelda CMF</h4>
<p><em>Lydia Content Management Framework (CMF) moduler:</em></p>
  <ul>
    <?php foreach($modules as $module): ?>
      <?php if($module['isZeldaCMF']): ?>
      <li><?=$module['name']?></li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</div>

<div class='box'>
<h4>Modeller</h4>
<p><em>En klass som innehåller en modell börjar på CM:</em></p>
  <ul>
    <?php foreach($modules as $module): ?>
      <?php if($module['isModel']): ?>
      <li><?=$module['name']?></li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</div>

<div class='box'>
<h4>Controllers</h4>
<p><em>En controller implementerar interfacet <code>IController</code>:</em></p>
  <ul>
    <?php foreach($modules as $module): ?>
      <?php if($module['isController']): ?>
      <li><?=$module['name']?></li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</div>

<div class='box'>
<h4>Hanterbara moduler</h4>
<p><em>Implemenerar interfacet <code>IModule</code>:</em></p>
<ul>
<?php foreach($modules as $module): ?>
  <?php if($module['isManageable']): ?>
  <li><?=$module['name']?></li>
  <?php endif; ?>
<?php endforeach; ?>
</ul>
</div>

<div class='box'>
<h4>Innehåller SQL</h4>
<p><em>Implementerar interfacet <code>IHasSQL</code>:</em></p>
  <ul>
    <?php foreach($modules as $module): ?>
      <?php if($module['hasSQL']): ?>
      <li><?=$module['name']?></li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</div>

<div class='box'>
<h4>Fler moduler</h4>
<p><em>Moduler som inte implementerar något interface i Zelda:</em></p>
  <ul>
    <?php foreach($modules as $module): ?>
      <?php if(!($module['isController'] || $module['isZeldaCore'] || $module['isZeldaCMF'])): ?>
      <li><?=$module['name']?></li>
      <?php endif; ?>
    <?php endforeach; ?>
  </ul>
</div>