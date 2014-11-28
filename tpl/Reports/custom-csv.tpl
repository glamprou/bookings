{foreach from=$Definition->GetColumnHeaders() item=column}"{translate key=$column->TitleKey()}",{/foreach}

{foreach from=$Report->GetData()->Rows() item=row}{foreach from=$Definition->GetRow($row) item=data}"{$data->Value()|escape}",{/foreach}

{/foreach}


