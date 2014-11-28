BEGIN:VCALENDAR
VERSION:2.0
METHOD:REQUEST
PRODID:-//phpScheduleIt//NONSGML {$phpScheduleItVersion}//EN
{foreach from=$Reservations item=reservation}
BEGIN:VEVENT
CLASS:PUBLIC
CREATED:{formatdate date=$reservation->DateCreated key=ical}
DESCRIPTION:{$reservation->Description|regex_replace:"/\r\n|\n|\r/m":"\n "}
DTSTAMP:{formatdate date=$reservation->DateCreated key=ical}
DTSTART:{formatdate date=$reservation->DateStart key=ical}
DTEND:{formatdate date=$reservation->DateEnd key=ical}
LOCATION:{$reservation->Location}
ORGANIZER;CN={$reservation->Organizer}:MAILTO:{$reservation->OrganizerEmail}
{if $reservation->RecurRule neq ''}
RRULE:{$reservation->RecurRule}
{/if}
SUMMARY:{$reservation->Summary}
UID:{$reservation->ReferenceNumber}&{$ScriptUrl}
SEQUENCE:0
URL:{$reservation->ReservationUrl}
X-MICROSOFT-CDO-BUSYSTATUS:BUSY
END:VEVENT
{/foreach}
{if $reservation->StartReminder != null}
BEGIN:VALARM
TRIGGER;RELATED=START:-PT{$reservation->StartReminder->MinutesPrior()}M
ACTION:DISPLAY
DESCRIPTION:{$reservation->Summary}
END:VALARM
{/if}
{if $reservation->EndReminder != null}
BEGIN:VALARM
TRIGGER;RELATED=END:-PT{$reservation->EndReminder->MinutesPrior()}M
ACTION:DISPLAY
DESCRIPTION:{$reservation->Summary}
END:VALARM
{/if}
END:VCALENDAR