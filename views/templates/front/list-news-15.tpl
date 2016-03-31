<h2>{l s='News' mod='prestanews'}</h2>
<hr />

<ul id="product_list" class="clear">
	{if $all_news|@count > 0}
	{foreach from=$all_news item=news name=listing-news}
	<li class=" clearfix">
		<h3><a href=""> {$news.title} </a></h3>
		<p class="product_desc"><a href="" title="" >{$news.txt|strip_tags:'UTF-8'|truncate:385:'...'}</a></p><br />
		<a href="{$modules_dir}prestanews/details-news.php?id={$news.id_news}" class="button" >{l s='Read more' mod='prestanews'}</a>
	</li>
	{/foreach}
	{else}
		<li class=" clearfix"><p>{l s='There no news' mod='prestanews'}</p></li>
	{/if}
	</ul>