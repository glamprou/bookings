<label class="customAttribute" for="{$attributeName}">{$attribute->Label()|escape}</label>
{if $align=='vertical'}
<br/>
{/if}
{if $readonly}
	<span class="attributeValue">{if $attribute->Value() == "1"}{translate key='True'}{else}{translate key='False'}{/if}</span>
{else}
	<input type="checkbox" value="1" id="{$attributeName}" name="{$attributeName}" {if $attribute->Value() == "1"}checked="checked"{/if} />
{/if}