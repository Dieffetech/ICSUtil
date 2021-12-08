<?php

namespace Kristianlentino\IcsUtil\tests;

use Kristianlentino\IcsUtil\ICSEvent;
use Kristianlentino\IcsUtil\ICSGenerator;
use PHPUnit\Framework\TestCase;

class ICSGeneratorTest extends TestCase
{

	public function testAddSingleEvent()
	{
		$dateStartEvent = date('Y-m-d');
		$dateEndEvent = date('Y-m-d',strtotime('+10 days'));
		$dateStart = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateStartEvent)));
		$dateEnd = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateEndEvent)));
		$event = new ICSEvent([
			'dateStart' => $dateStart,
			'dateEnd' => $dateEnd,
			'summary' => "Oggetto dell'evento",
			'description' => "Oggetto dell'evento",
		]);
		$generator = new ICSGenerator();
		$this->assertTrue($generator->addEvent($event));
	}

	/**
	 * @expectedException \Exception
	 */
	public function testEmptyProperties()
	{
		try {
			$eventEmpty = new ICSEvent();
		} catch (\Exception $exception){
			return $this->assertTrue(true);
		}

		return $this->assertTrue(false);
	}
	public function testGetEvents()
	{

		$dateStartEvent = date('Y-m-d');
		$dateEndEvent = date('Y-m-d',strtotime('+10 days'));
		$dateStart = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateStartEvent)));
		$dateEnd = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateEndEvent)));
		$event = new ICSEvent([
			'dateStart' => $dateStart,
			'dateEnd' => $dateEnd,
			'summary' => "Oggetto dell'evento"
		]);
		$dateStartEvent2 = date('Y-m-d',strtotime('-20 days'));
		$dateEndEvent2 = date('Y-m-d',strtotime('+50 days'));
		$dateStart2 = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateStartEvent2)));
		$dateEnd2 = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateEndEvent2)));
		$event2 = new ICSEvent([
			'dateStart' => $dateStart,
			'dateEnd' => $dateEnd,
			'summary' => "Oggetto dell'evento",
			'description' => "Oggetto dell'evento",
		]);
		$generator = new ICSGenerator();
		$generator->addEvent($event);
		$generator->addEvent($event2);


		return $this->assertIsArray($generator->getEvents(),'getEvents torna un array') && $this->assertObjectEquals($generator->getEvent($event2->getUniqueId()),ICSEvent::class);

	}

	public function testSetEvents()
	{
		$dateStartEvent = date('Y-m-d');
		$dateEndEvent = date('Y-m-d',strtotime('+10 days'));
		$dateStart = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateStartEvent)));
		$dateEnd = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateEndEvent)));
		$event = new ICSEvent([
			'dateStart' => $dateStart,
			'dateEnd' => $dateEnd,
			'summary' => "Oggetto dell'evento"
		]);
		$dateStartEvent2 = date('Y-m-d',strtotime('-20 days'));
		$dateEndEvent2 = date('Y-m-d',strtotime('+50 days'));
		$dateStart2 = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateStartEvent2)));
		$dateEnd2 = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateEndEvent2)));
		$event2 = new ICSEvent([
			'dateStart' => $dateStart2,
			'dateEnd' => $dateEnd2,
			'summary' => "Oggetto dell'evento",
			'description' => "Oggetto dell'evento",
		]);

		$array = [
			$event,
			$event2
		];

		$generator = new ICSGenerator();
		$generator->setEvents($array);

		$this->assertIsArray($generator->getEvents());
		$this->objectEquals($generator->getEvent($event2->getUniqueId()),ICSEvent::class);

	}

	public function testToICSString()
	{
		$dateStartEvent = date('Y-m-d');
		$dateEndEvent = date('Y-m-d',strtotime('+10 days'));
		$dateStart = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateStartEvent)));
		$dateEnd = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateEndEvent)));
		$event = new ICSEvent([
			'dateStart' => $dateStart,
			'dateEnd' => $dateEnd,
			'summary' => "Oggetto dell'evento",
			'description' => "Oggetto dell'evento",
		]);
		$dateStartEvent2 = date('Y-m-d',strtotime('-20 days'));
		$dateEndEvent2 = date('Y-m-d',strtotime('+50 days'));
		$dateStart2 = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateStartEvent2)));
		$dateEnd2 = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateEndEvent2)));
		$event2 = new ICSEvent([
			'dateStart' => $dateStart2,
			'dateEnd' => $dateEnd2,
			'summary' => "Oggetto dell'evento",
			'description' => "Oggetto dell'evento",
		]);

		$array = [
			$event,
			$event2
		];

		$generator = new ICSGenerator();
		$generator->setEvents($array);

		$this->assertIsString($generator->toICSString());
	}

	public function testSaveICSFile()
	{
		$dateStartEvent = date('Y-m-d');
		$dateEndEvent = date('Y-m-d',strtotime('+2 days'));
		$dateStart = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateStartEvent)));
		$dateEnd = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateEndEvent)));

		$event = new ICSEvent([
			'dateStart' => $dateStart,
			'dateEnd' => $dateEnd,
			'description' => 'Prova ICS',
			'location' => 'Codogno',
			'url' => 'https://kristianlentino.it',
			'summary' => "Oggetto dell'evento"
		]);

		$array = [
			$event,
		];

		$generator = new ICSGenerator();
		$generator->setEvents($array);

		$generator->saveICSFile("./src/tests/ics_files/test_".date('Y_m_d_H_i_s').".ics");
	}
	public function testDeleteIcsEvent()
	{
		$dateStartEvent = date('Y-m-d');
		$dateEndEvent = date('Y-m-d',strtotime('+10 days'));
		$dateStart = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateStartEvent)));
		$dateEnd = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateEndEvent)));

		$event = new ICSEvent([
			'dateStart' => $dateStart,
			'dateEnd' => $dateEnd,
			'description' => 'Prova ICS',
			'summary' => "Oggetto dell'evento"
		]);

		$array = [
			$event,
		];

		$generator = new ICSGenerator();
		$generator->setEvents($array);
		$eventId = $event->getUniqueId();
		$generator->deleteEvent($event->getUniqueId());


		$this->assertTrue(empty($generator->getEvent($eventId)));
	}
}
