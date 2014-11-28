{if $Report->ResultCount() > 0}
	<div id="report-actions">
		<a href="#" id="btnChart">{html_image src="chart.png"}{translate key=ViewAsChart}</a>&nbsp;&nbsp;&nbsp;&nbsp;{if !$HideSave}<a href="#" id="btnSaveReportPrompt">{html_image src="disk-black.png"}{translate key=SaveThisReport}</a>&nbsp;&nbsp;&nbsp;&nbsp;{/if}<a href="#" id="btnPrint">{html_image src="printer.png"}{translate key=Print}</a>
	</div>
	<table width="100%" id="report-results" chart-type="{$Definition->GetChartType()}">
		<tr>
		{foreach from=$Definition->GetColumnHeaders() item=column}
			<th>{translate key=$column->TitleKey()}</th>
            {if $showParticipations}
                <th>Σύνολο{if $resultType == 'count'}(Προπονήσεις){/if}</th>
                <th>Κρατήσεις</th>
                <th>Συμμετοχές</th>
            {/if}
            {if $training}
                <th>Σύνολο Προπονήσεων</th>
                <th>Private</th>
                <th>Group</th>
            {/if}
		{/foreach}
		</tr>
        {$total=0}
		{foreach from=$Report->GetData()->Rows() item=row}
			{cycle values=',alt' assign=rowCss}
			<tr class="{$rowCss}">
				{foreach from=$Definition->GetRow($row) item=cell}
					<td chart-value="{$cell->ChartValue()}" chart-column-type="{$cell->GetChartColumnType()}" chart-group="{$cell->GetChartGroup()}">{$cell->Value()|escape}{if $zeroResUsers and $cell->Value() !== null and $resultType eq 'time'}0 hours{/if}</td>
				{/foreach}
                {if $showParticipations}
                    {if $resultType eq 'count'}
                        {$total = $total + $row['total_owner'] + $row['total_participant']}
                        <td>{$row['total_owner'] + $row['total_participant']} ({$row['total_training']})</td>
                        <td>{$row['total_owner']}</td>
                        <td>{$row['total_participant']}</td>
                    {else}
                        {$total = $total + $row['totalTime_owner'] + $row['totalTime_participant']}
                        <td>{if TimeInterval::Parse($row['totalTime_owner'] + $row['totalTime_participant']) neq ''}{TimeInterval::Parse($row['totalTime_owner'] + $row['totalTime_participant'])}{else}0 hours{/if}</td>
                        <td>{if TimeInterval::Parse($row['totalTime_owner']) neq ''}{TimeInterval::Parse($row['totalTime_owner'])}{else}0 hours{/if}</td>
                        <td>{if TimeInterval::Parse($row['totalTime_participant']) neq ''}{TimeInterval::Parse($row['totalTime_participant'])}{else}0 hours{/if}</td>
                    {/if}
                {/if}
                {if $training}
                    {$total = $total + $row['private_training'] + $row['group_training']}
                    <td>{$row['private_training'] + $row['group_training']}</td>
                    <td>{$row['private_training']} (-{$row['private_training_cancelled']})</td>
                    <td>{$row['group_training']} (-{$row['group_training_cancelled']})</td>
                {/if}
			</tr>
		{/foreach}
	</table>
	<h4>{$Report->ResultCount()} {translate key=Rows}
		{if $Definition->GetTotal() != ''}
			| {$Definition->GetTotal()} {translate key=Total}
        {else}
            {if $showParticipations}
                |
                {if $resultType eq 'count'}
                    {$total}
                {else}
                    {TimeInterval::Parse($total)}
                {/if}
                {translate key=Total}
            {/if}
		{/if}

	</h4>
{else}
	<h2 id="report-no-data" class="no-data" style="text-align: center;">{translate key=NoResultsFound}</h2>

{/if}

<script type="text/javascript">
$(document).ready(function(){
	$('#report-no-data, #report-results').trigger('loaded');
});
</script>