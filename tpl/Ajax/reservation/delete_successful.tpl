<div>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<div>{translate key=ReservationRemoved}</div>
	<ul>
	{foreach from=$Warnings item=each}
		<li>{$each}</li>
	{/foreach}
	</ul>
	<input type="button" id="btnSaveSuccessful" value="{translate key='Close'}" class="button" />

</div>