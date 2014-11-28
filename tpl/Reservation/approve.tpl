{extends file="Reservation/view.tpl"}

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
		<a href="#" class="delete save">
			{html_image src="cross-button.png"}
			{translate key='Delete'}
		</a>
	{/if}
{/block}

{block name=submitButtons}
	<button type="button" class="button" id="btnApprove">
		<img src="img/tick-circle.png" />
		{translate key='Approve'}
	</button>
{/block}

{block name="ajaxMessage"}
	{translate key=UpdatingReservation}...<br/>
{/block}