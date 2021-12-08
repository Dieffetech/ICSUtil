<?php


namespace Kristianlentino\IcsUtil;


class ICSGenerator
{

	/**
	* @var $events ICSEvent[]
 	*/
    private $events = [];

    public function __construct($events = null)
    {
        if (!empty($events)) { 
            $this->setEvents($events);
        }
    }

    public function setEvents(array $events) :void
    {

		if(!$events[0] instanceof ICSEvent){
			throw new \Exception("You should pass an array of ICSEvent objects");
		}

		foreach ($events as $index => $event) {
			$this->events[$event->getUniqueId()] = $event;
        }
    }

    public function getEvents(): array
    {
        return $this->events;
    }
    public function getEvent(string $uid): ?ICSEvent
    {
        return $this->events[$uid]??null;
    }
	public function deleteEvent(string $uid): bool
    {
        unset($this->events[$uid]);
		return true;
    }

    public function addEvent(ICSEvent $event) :bool
    {
        $this->events[$event->getUniqueId()] = $event;
		return true;
    }

    public function toICSString(): string
    {
        $ics_string = "";

        // add header
        $ics_string .= "BEGIN:VCALENDAR\r\n";
        $ics_string .= "VERSION:2.0\r\n";
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
        file_put_contents($path, $this->toICSString());
    }
}