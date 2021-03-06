# ICS generator

ICS generator is a PHP library for generating ICS calendar events

## Installation

Use the package manager [composer](https://getcomposer.org/) to install the package.

```bash
composer require kristianlentino/ics-util
```

##ICSEvent properties

Here is a short list of the available properties for a single event:

| Property | Description
| :---: | :---: |
| description | Description of the event |
| dateStart | Start date of the event |
| dateEnd | End date of the event |
| location | the place where the event will have place |
| summary | Title of the event |
| url | An url that will be displayed when opening the event on the calendar |
| unique_id | Unique identifier of the event |


##Tests
To run tests you need to install the vendor and the run the following command from the root of the library
```bash
./vendor/bin/phpunit ./src/tests
```
The ICS's files generated by this library have been tested on:


| Service | Test
| :---: | :---: |
| Gmail | ✅ |
| Apple | ✅ |
| Samsung | ✅ |

## Usage

```injectablephp
$dateStartEvent = date('Y-m-d');
$dateEndEvent = date('Y-m-d',strtotime('+10 days'));
$dateStart = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateStartEvent)));
$dateEnd = str_replace('+00:00', 'Z', gmdate('c', strtotime($dateEndEvent)));
$event = new ICSEvent([
    'dateStart' => $dateStart,
    'dateEnd' => $dateEnd
]);

$generator->addEvent($event);

//if you have an array of events just call the setEvents function with the array as parameter
$generator->setEvents($array);
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.


## License
[MIT](https://choosealicense.com/licenses/mit/)