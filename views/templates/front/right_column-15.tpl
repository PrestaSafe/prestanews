{*
* @copyright web-batier.com (guillaume Batier)
*}

<div class="block news_block informations_block_left">
	<h4 class="title_block"><a href="#">{l s='News' mod='prestanews'}</a></h4>
	
		<!-- <a class="button" href="{$link->getModuleLink('prcustomeropinion')}">{l s='Give my opinion' mod='prcustomeropinion'}</a> -->
		
		<ul id="news-list" class="block_content tree dynamized">
			{foreach from=$news item=new name=newsforeach}
				<li class="bullet">
					<a href="{$module_dir}details-news.php?id={$new.id_news}">{$new.title}</a>
				</li>
			{/foreach}
		</ul>	
		<br />
		<center><a class="button" href="{$link->getModuleLink('prestanews')}">{l s='All news' mod='prestanews'}</a></center>
	
</div>
