<?php


namespace Kristianlentino\IcsUtil;

use DateTime;

class ICSEvent
{

    const DT_FORMAT = 'Ymd\THis';

    private $description = "";
    private $dateStart = "";
    private $dateEnd = "";
    private $dateStamp = "";
    private $location = "";
    private $summary = "";
    private $url = "";
    private $timeZone = "";

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getDateStart(): string
    {
        return $this->dateStart;
    }

    /**
     * @param string $dateStart
     */
    public function setDateStart(string $dateStart): void
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @return string
     */
    public function getDateEnd(): string
    {
        return $this->dateEnd;
    }

    /**
     * @param string $dateEnd
     */
    public function setDateEnd(string $dateEnd): void
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return string
     */
    public function getDateStamp(): string
    {
        return $this->dateStamp;
    }

    /**
     * @param string $dateStamp
     */
    public function setDateStamp(string $dateStamp): void
    {
        $this->dateStamp = $dateStamp;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     */
    public function setSummary(string $summary): void
    {
        $this->summary = $summary;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getTimeZone(): string
    {
        return $this->timeZone;
    }

    /**
     * @param string $timeZone
     */
    public function setTimeZone(string $timeZone): void
    {
        $this->timeZone = $timeZone;
    }

    public function __construct(
    	$description = "",
		$dateStart = "",
		$dateEnd = "",
		$dateStamp = "",
		$location = "",
		$summary = "",
		$url = "",
		$timeZone = ""
	)
    {
        if(!empty($description)) $this->setDescription($description);
        if(!empty($dateStart)) $this->setDateStart($dateStart);
        if(!empty($dateEnd)) $this->setDateEnd($dateEnd);
        if(!empty($dateStamp)) $this->setDateStamp($dateStamp);
        if(!empty($location)) $this->setLocation($location);
        if(!empty($summary)) $this->setSummary($summary);
        if(!empty($url)) $this->setUrl($url);
        if(!empty($timeZone)) $this->setTimeZone($timeZone);
    }

    public function getEvent() :string
    {
        $event_string = "";

        // add header
        $event_string .= "BEGIN:VEVENT\r\n";

        // Set some default values
        $event_string .= "UID:" . uniqid() . "\r\n";

        if(!empty($this->getDateStamp())) {
            $event_string .= "DTSTAMP;" . $this->format_timestamp($this->getDateStamp()) . "\r\n";
        }
        else {
            $event_string .= "DTSTAMP;" . $this->format_timestamp('now') . "\r\n";
        }

        if(!empty($this->getDateStart())) {
            $event_string .= "DTEND;" . $this->format_timestamp($this->getDateStart()) . "\r\n";
        }

        if(!empty($this->getDateEnd())) {
            $event_string .= "DTSTART;" . $this->format_timestamp($this->getDateEnd()) . "\r\n";
        }

        if(!empty($this->getDescription())) {
            $event_string .= "DESCRIPTION:" . $this->escape_string($this->getDescription()) . "\r\n";
        }
        if(!empty($this->getLocation())) {
            $event_string .= "LOCATION:" . $this->escape_string($this->getLocation()) . "\r\n";
        }
        if(!empty($this->getSummary())) {
            $event_string .= "SUMMARY:" . $this->escape_string($this->getSummary()) . "\r\n";
        }
        if(!empty($this->getUrl())) {
            $event_string .= "URL:" . $this->escape_string($this->getUrl()) . "\r\n";
        }

        // add footer
        $event_string .= "END:VEVENT\r\n";

        return $event_string;
    }

    private function format_timestamp($timestamp) {
        $dt = new DateTime($timestamp);

        if (!empty($this->getTimeZone())) {
            return "TZID=\"" . $this->getTimeZone() . "\":" . $dt->format(self::DT_FORMAT);
        }
        else {
            return $dt->format(self::DT_FORMAT);
        }
    }

    private function escape_string($str) {
        return preg_replace('/([\,;])/','\\\$1', $str);
    }
}