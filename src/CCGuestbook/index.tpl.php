<h1>Gästbok</h1>
<p>Implementering av gästbok i Zelda. Spara i databas.</p>

<form action="<?=$formAction?>" method='POST'>
  <p>
    <label>Meddelande: <br/>
    <textarea name='newEntry' rows="10" cols="46"></textarea></label>
  </p>
  <p>
    <input type='hidden' name='email' />
    <input type='submit' name='doAdd' value='Spara meddelandet' />
    <input type='submit' name='doClear' value='Rensa alla' />
    <input type='submit' name='doCreate' value='Skapa databastabell' />
  </p>
</form>

<h2>Meddelanden sparade i databasen</h2>

<?php foreach($entries as $val):?>
<div style='background-color:#f6f6f6;border:1px solid #ccc;margin-bottom:1em;padding:1em;'>
  <p>Datum: <?=$val['created']?></p>
  <p><?=htmlent($val['entry'])?></p>
</div>
<?php endforeach;?>