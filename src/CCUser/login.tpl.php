<h1>Logga in</h1>
<p>Här kan du logga in med root/root.</p>
<?=$login_form->GetHTML(array('start'=>true))?>
  <fieldset>
    <?=$login_form['acronym']->GetHTML()?>
    <?=$login_form['password']->GetHTML()?>  
    <?=$login_form['login']->GetHTML()?>
  </fieldset>
</form>