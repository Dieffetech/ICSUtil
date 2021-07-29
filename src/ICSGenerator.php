<?php


namespace common\util\ICS;


class ICSGenerator
{

    private $events = [];

    public function __construct($events = null)
    {
        if (!empty($events)) {
            $this->setEvents($events);
        }
    }

    public function setEvents($events) :void
    {

        $this->events = $events;
    }

    public function getEvents(): array
    {
        return $this->events;
    }

    public function addEvent(ICSEvent $event) :void
    {
        $this->events[] = $event;
    }

    public function toICSString(): string
    {
        $ics_string = "";

        // add header
        $ics_string .= "BEGIN:VCALENDAR\r\n";
        $ics_string .= "'VERSION:2.0\r\n";
        $ics_string .= "PRODID:-//hacksw/handcal//NONSGML v1.0//EN\r\n";
        $ics_string .= "CALSCALE:GREGORIAN\r\n";

        foreach ($this->getEvents() as $event) {
            /* @var $event ICSEvent */
            $ics_string .= $event->getEvent();
        }

        // add footer
        $ics_string .= "END:VCALENDAR\r\n";

        return $ics_string;
    }

    public function saveICSFile($path) :void
    {
        file_put_contents($path, $this->generateICSString());
    }
}