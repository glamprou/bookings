<label class="customAttribute" for="{$attributeName}">{$attribute->Label()|escape}</label>
{if $align=='vertical'}
<br/>
{/if}
{if $readonly}
<span class="attributeValue">{$attribute->Value()|escape|nl2br}</span>
{else}
<textarea id="{$attributeName}" name="{$attributeName}" class="customAttribute textbox">{$attribute->Value()|escape}</textarea>
{/if}