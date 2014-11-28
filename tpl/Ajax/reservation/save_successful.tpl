<div>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	{html_image src="dialog-success.png"}<br/>
	<div>{translate key=ReservationCreated}</div>
	<div>{translate key=YourReferenceNumber args=$ReferenceNumber}</div>
	<ul>
	{foreach from=$Warnings item=each}
		<li>{$each}</li>
	{/foreach}
	</ul>
	<input type="button" id="btnSaveSuccessful" value="{translate key='Close'}" class="button" />
</div>