<div>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	{html_image src="dialog-warning.png"}<br/>

	{translate key=ReservationFailed}
	<ul>
	{foreach from=$Errors item=each}
		<li>{$each}</li>
	{/foreach}
	</ul>

	<input type="button" id="btnSaveFailed" value="{translate key='Return'}" class="button" />
</div>