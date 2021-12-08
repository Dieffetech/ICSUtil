<?php


namespace Kristianlentino\IcsUtil;

use DateTime;

class ICSEvent
{

    const DT_FORMAT = 'Ymd\THis';
	const REQUIRED_PROPERTIES = [
		'dateStart',
		'dateEnd',
		'description',
	];

	private string $description = "";
    private string $dateStart;
    private string $dateEnd;
    private string $dateStamp = "";
    private string $location = "";
    private string $summary = "";
    private string $url = "";
    private string $timeZone = "";
    private string $unique_id = "";

	const MAP_ICS_PROPERTIES = [
		'dateStart' => 'dtstart',
		'dateEnd' => 'dtend',
		'description' => 'description',
		'location' => 'location',
		'summary' => 'summary',
		'url' => 'url',
	];

	public function __construct(
		array $properties = []
	)
	{

		if(empty($properties))
			throw new \Exception("You need to initialize the class with at least the start date , end date and the description ");

		foreach ($properties as $propertyName => $property) {

			$setterFunctionName = "set".ucfirst($propertyName);
			$this->$setterFunctionName($property);
		}

		$this->unique_id = uniqid("",true);
	}

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



    public function getEvent() :string
    {
		// Build ICS properties - add header
		$ics_props = array(
			"BEGIN:VEVENT"
		);


		$hasCompiledRequiredProperties = $this->checkRequiredProperties();

		if(!$hasCompiledRequiredProperties){
			throw new \Exception("You should set at least the following attributes: ".implode(',',self::REQUIRED_PROPERTIES));
		}

		// Build ICS properties - add header
		$props = array();
		foreach($this::MAP_ICS_PROPERTIES as $classAttribute => $icsPropertyName) {
			$value = $this->sanitize_val($this->$classAttribute,$icsPropertyName);
			$props[strtoupper($icsPropertyName . ($icsPropertyName === 'url' ? ';VALUE=URI' : ''))] = $value;
		}

		// Set some default values
		$props['DTSTAMP'] = $this->format_timestamp('now');
		$props['UID'] = $this->unique_id;

		// Append properties
		foreach ($props as $k => $v) {
			$ics_props[] = "$k:$v";
		}

		// Build ICS properties - add footer
		$ics_props[] = "END:VEVENT\r\n";

		return implode("\r\n",$ics_props);
    }


	private function sanitize_val($val, $key = false) {
		switch($key) {
			case 'dtend':
			case 'dtstamp':
			case 'dtstart':
				$val = $this->format_timestamp($val);
				break;
			default:
				$val = $this->escape_string($val);
		}

		return $val;
	}
	private function format_timestamp($timestamp) {
		$dt = new \DateTime($timestamp);
		return $dt->format(self::DT_FORMAT);
	}

    private function escape_string($str) {
        return preg_replace('/([\,;])/','\\\$1', $str);
    }
	/**
	 * @return string
	 */
	public function getUniqueId(): string
	{
		return $this->unique_id;
	}

	/**
	 * @param string $unique_id
	 */
	public function setUniqueId(string $unique_id): void
	{
		$this->unique_id = $unique_id;
	}

	private function checkRequiredProperties()
	{
		foreach (self::REQUIRED_PROPERTIES as $required_property) {

			if(empty($this->$required_property))
				return false;

		}

		return true;
	}
}