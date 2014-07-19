<div id="login-body">
	<div id="login-div">
		<h1>Logga in</h1>
		<?=$login_form->GetHTML(array('start'=>true))?>
		  <fieldset>
		    <?=$login_form['acronym']->GetHTML()?>
		    <?=$login_form['password']->GetHTML()?>  
		    <?=$login_form['login']->GetHTML()?>
		  </fieldset>
		</form>
	</div>
	<div id="under-login-div">
		<?="<span class='white'><a href='#'>Glömt lösenordet?</a>&nbsp; | &nbsp;<a class='login' href='" . create_url('my/page/') . "'>Gå till startsidan</a></span>"?>
	</div>
</div>