<link rel="stylesheet" type="text/css" href="css/popup.css">
{if $authorized}
<div class="res_popup_details" style="margin:0">	
    {if $isGame}
        <div class="rankingGamePopUpTitle">Αγώνας κατάταξης {$rankingName}</div>
        <div class="rankingGamePopUpPlr"><b>{$opponent1pos}.</b> {$opponent1name}</div>
        <div class="rankingGamePopUpVS">VS</div>
        <div class="rankingGamePopUpPlr"><b>{$opponent2pos}.</b> {$opponent2name}</div>
    {else}
        <div class="user">
            {if $hideUserInfo}
                {translate key=Private}
            {else}
                {$fullName} {$ownerPhone}
            {/if}
        </div>
        {if !$hideUserInfo}
        <div class="users">
        {translate key="Participants"} ({$participants|@count})
        {foreach from=$participants item=user name=participant_loop}
            {if !$user->IsOwner()}
                {fullname first=$user->FirstName last=$user->LastName}
            {/if}
            {if !$smarty.foreach.participant_loop.last},{/if}
        {/foreach}
        </div>
        {/if}
        {if !$hideDetails}
        <div class="title">{if $title neq ''}{translate key="ReservationTitle"}:<br />{$title}{/if}</div>
        {/if}
        {if !$hideDetails}
        <div class="summary">{if $summary neq ''}{$summary|truncate:300:"..."|nl2br}{/if}</div>
        {/if}
        <!-- {$ReservationId} -->
    {/if}
</div>
{else}
	{translate key='InsufficientPermissionsError'}
{/if}