{include file='globalheader.tpl'}

<h1>{translate key=ServerSettings}</h1>

<ul class="indented">
	<li>Current Time: {$currentTime}</li>
	<li>Image Upload Physical Directory: {$imageUploadDirectory} ({translate key=Permissions}: {$imageUploadDirPermissions}) <a href="{$smarty.server.SCRIPT_URL}?{QueryStringKeys::ACTION}=changePermissions">Try to apply correct permissions</a></li>
	<li>Template Cache Directory: {$tempalteCacheDirectory} <a href="{$smarty.server.SCRIPT_URL}?{QueryStringKeys::ACTION}=flush">Try to flush cached files</a></li>
</ul>

<h3 style="margin-top: 20px;">Plugins</h3>
<ul class="indented">
{foreach from=$plugins key=category item=items}
	<li>{$category}
		<ul>
		{foreach from=$items item=pluginName}
			<li>{$pluginName}</li>
		{/foreach}
		</ul>
	</li>
{/foreach}
</ul>
{include file='globalfooter.tpl'}