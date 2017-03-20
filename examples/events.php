<?php

// Include Emma class
require __DIR__ . '/../src/Emma.php';

// Prep our data
$dataToSend = array(
	'event_name' => 'rss-updated', // This event name must be on the event trigger for emma
	'genre' => 'scifi',
	'email' => 'email@domain.com', // This email must be on the list we are specifying
	'new_items' => array(
		array(
			'title' => 'Test',
			'date' => '2017-06-08',
			'excerpt' => 'Testy test test',
			'link' => 'linkylink',
		),
		/*
		array(
			'title' => 'Test 2',
			'date' => '2017-06-09',
			'excerpt' => 'Testy test <strong>test</strong>',
			'link' => 'linkylink',
		),*/
	),
);

// Create new Emma class object
$E = new FTS\EmmaEvents('1234567', 'Drivorj7QueckLeuk', 'WoghtepheecijnibV');

// Control Debugging output
$E->debug = true;

// Make API request

// Trigger Event
$response = $E->trigger_event($dataToSend);

// Display response
var_dump($response);