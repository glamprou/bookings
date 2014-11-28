<div>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	{html_image src="dialog-warning.png"}<br/>

	<h2 style="text-align: center;">{translate key=ReservationFailed}</h2>
    {if $Warnings}
    <div class="warning">
        <ul>
            {foreach from=$Warnings item=each}
                <li>{$each|nl2br}</li>
            {/foreach}
        </ul>
    </div>
    {/if}
    {if $Errors}
	<div class="error">
		<ul>
		{foreach from=$Errors item=each}
			<li>{$each|nl2br}</li>
		{/foreach}
		</ul>
	</div>
    {/if}
	<div style="margin: auto;text-align: center;">
		<button id="btnSaveFailed"
				class="button">{html_image src="arrow_large_left.png"} {translate key='ReservationErrors'}</button>
	</div>
</div>