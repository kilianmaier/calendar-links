<?php

namespace Spatie\CalendarLinks\Generators;

use Spatie\CalendarLinks\Link;
use Spatie\CalendarLinks\Generator;

class Ics implements Generator
{
    public function generate(Link $link) : string
    {
        $url = [
            'data:text/calendar;charset=utf8,',
            'BEGIN:VCALENDAR',
            'VERSION:2.0',
            'PRODID:' . $link->prodid ?? '',
            'CALSCALE:GREGORIAN',
            'METHOD:PUBLISH',
            'BEGIN:VEVENT',
            'UID:' . $link->uid ?? '',
            'DTSTART:' . $link->from,
            'DTEND:' . $link->to,
            'STATUS' . $link->status ?? '',
            'SUMMARY:' . $link->title,
        ];

        if ($link->description) {
            $url[] = 'DESCRIPTION:' . addcslashes($link->description, "\n");
        }

        if ($link->address) {
            $url[] = 'LOCATION:' . str_replace(',', '', $link->address);
        }

        if ($link->dtstamp) {
            $url[] = 'DTSTAMP:' . $link->dtstamp;
        }

        if ($link->attendee) {
            foreach ($thik->attendee as $value) {
                $url[] = 'ATTENDEE;' . $value;
            }
        }

        if ($link->organizer) {
            $url[] = 'ORGANIZER;' . $link->organizer;
        }

        $url[] = 'END:VEVENT';
        $url[] = 'END:VCALENDAR';
        $redirectLink = implode('%0A', $url);

        return $redirectLink;
    }
}
