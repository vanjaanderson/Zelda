<h1>Logga in</h1>
<p>Här kan du logga in med root(root@dbwebb.se)/root eller doe(doe@dbwebb.se)/doe.</p>
<?=$login_form->GetHTML(array('start'=>true))?>
  <fieldset>
    <?=$login_form['acronym']->GetHTML()?>
    <?=$login_form['password']->GetHTML()?>  
    <?=$login_form['login']->GetHTML()?>
    <?php if($allow_create_user) : ?>
      <p class='form-action-link'><a href='<?=$create_user_url?>' title='Create a new user account'>Skapa ny användare</a></p>
    <?php endif; ?>
  </fieldset>
</form>