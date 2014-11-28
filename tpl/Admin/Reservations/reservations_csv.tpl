{translate key='User'},{translate key='Resource'},{translate key='Title'},{translate key='Description'},{translate key='BeginDate'},{translate key='EndDate'},{translate key='Duration'},{translate key='Created'},{translate key='LastModified'},{translate key='ReferenceNumber'}{foreach from=$AttributeList->GetLabels() item=label},{$label}{/foreach}

{foreach from=$reservations item=reservation}
"{fullname first=$reservation->FirstName last=$reservation->LastName}","{$reservation->ResourceName}","{$reservation->Title}","{$reservation->Description}",{formatdate date=$reservation->StartDate timezone=$Timezone key=res_popup},{formatdate date=$reservation->EndDate timezone=$Timezone key=res_popup},"{$reservation->GetDuration()->__toString()}",{formatdate date=$reservation->CreatedDate timezone=$Timezone key=general_datetime},{formatdate date=$reservation->ModifiedDate timezone=$Timezone key=general_datetime},{$reservation->ReferenceNumber}{foreach from=$AttributeList->GetValues($reservation->SeriesId) item=value},"{$value}"{/foreach}

{/foreach}