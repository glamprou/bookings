{extends file="Reservation/create.tpl"}

{block name=header}
	{include file='globalheader.tpl' TitleKey='EditReservationHeading' TitleArgs=$ReferenceNumber cssFiles='css/reservation.css,css/jquery.qtip.min.css'}
{/block}

{block name=reservationHeader}
	{translate key="EditReservationHeading" args=$ReferenceNumber}
{/block}

{block name=deleteButtons}	
	{if $IsRecurring}
		<a href="#" class="delete prompt">
			{html_image src="cross-button.png"}
			{translate key='Delete'}
		</a>
	{else}
		<a href="#" class="delete save">
			{html_image src="cross-button.png"}
			{translate key='Delete'}
		</a>
	{/if}

	<a style='margin-left:10px;' href="{$Path}export/{Pages::CALENDAR_EXPORT}?{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}">
		{html_image src="calendar-plus.png"}
		{translate key=AddToOutlook}</a>
	
{/block}

{block name=submitButtons}
	{if $IsRecurring}
		<button type="button" class="button update prompt">
			<img src="img/tick-circle.png" />
			{translate key='Update'}
		</button>
		<div id="updateButtons" style="display:none;" title="{translate key=ApplyUpdatesTo}">
			<div style="text-align: center;line-height:50px;">
				<button type="button" id="btnUpdateThisInstance" class="button save">
					{html_image src="disk-black.png"}
					{translate key='ThisInstance'}
				</button>
				<button type="button" id="btnUpdateAllInstances" class="button save">
					{html_image src="disks-black.png"}
					{translate key='AllInstances'}
				</button>
				<button type="button" id="btnUpdateFutureInstances" class="button save">
					{html_image src="disk-arrow.png"}
					{translate key='FutureInstances'}
				</button>
				<button type="button" class="button">
					{html_image src="slash.png"}
					{translate key='Cancel'}
				</button>
			</div>
		</div>
	{else}
		<button type="button" id="btnCreate" class="button save update">
			<img src="img/disk-black.png" />
			{translate key='Update'}
		</button>
	{/if}
	<button type="button" id="btnPrint" class="button">
		<img src="img/printer.png" />
		{translate key='Print'}
	</button>
{/block}

{block name="ajaxMessage"}
	{translate key=UpdatingReservation}...<br/>
{/block}

{block name='attachments'}
<div style="clear:both">&nbsp;</div>

	<div id="attachmentDiv" class="res-attachments">
	<span class="heading">{translate key=Attachments} ({$Attachments|count})</span>
	{if $Attachments|count > 0}
		<a href="#" class="remove" id="btnRemoveAttachment">({translate key="Remove"})</a><br/>
		{foreach from=$Attachments item=attachment}
			<a href="attachments/{Pages::RESERVATION_FILE}?{QueryStringKeys::ATTACHMENT_FILE_ID}={$attachment->FileId()}&{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}" target="_blank">{$attachment->FileName()}</a>&nbsp;<input style='display: none;' type="checkbox" name="{FormKeys::REMOVED_FILE_IDS}[{$attachment->FileId()}]" />&nbsp;
		{/foreach}
	</div>
	{/if}
{/block}