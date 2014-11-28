{translate key=Created}: {format_date date=Date::Now() key=general_datetime}
<table width="100%" border="1">
	<tr>
	{foreach from=$Definition->GetColumnHeaders() item=column}
		<th>{translate key=$column->TitleKey()}</th>
	{/foreach}
	</tr>
	{foreach from=$Report->GetData()->Rows() item=row}
		<tr>
			{foreach from=$Definition->GetRow($row) item=data}
				<td>{$data->Value()|escape}&nbsp;</td>
			{/foreach}
		</tr>
	{/foreach}
</table>
{$Report->ResultCount()} {translate key=Rows}
{if $Definition->GetTotal() != ''}
	| {$Definition->GetTotal()} {translate key=Total}
{/if}

<script type="text/javascript" >
	window.print();
</script>

