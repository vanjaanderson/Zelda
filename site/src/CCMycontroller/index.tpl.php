<?php if(file_exists('site/data/.ht.sqlite')): ?>
<h1>Välkommen till Zelda</h1>
<p>Välkommen till Zelda index controller.</p>

<h2>Ladda ner</h2>
<p><em>Du kan ladda ner Zelda från github:</em></p>
<blockquote>
	<code>git clone git://github.com/vanjaanderson/Zelda.git</code>
</blockquote>
<p><em>Du kan se källkoden på github:</em> <a href='https://github.com/vanjaanderson/Zelda'>https://github.com/vanjaanderson/Zelda</a></p>

<h2>Installation</h2>
<p>
	Först måste du se till att data-mappen är totalt skrivbar. I denna mapp läser och skriver Zelda alla sina filer.
</p>

<blockquote>
	<code>cd zelda; chmod 777 site/data</code>
</blockquote>

<? else: ?>
<p>
	Sedan måste vissa moduler initieras. <em>Detta gör du med nedanstående länk:</em>
</p>
<blockquote>
	<a class="smaller-text" href='<?=create_url('module/install')?>'>module/install</a>
</blockquote>

<?php endif; ?>