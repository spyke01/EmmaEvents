<?php

class EmmaTest extends PHPUnit_Framework_TestCase {

    protected $EmmaClient;

    public function setup() {

        $this->EmmaClient = new FTS\EmmaEvents(
            EMMA_ACCOUNT_ID,
            EMMA_PUBLIC_KEY,
            EMMA_PRIVATE_KEY
        );
    }
	
	/* 
	//look into the best way to create a test for this
    public function test_trigger_event() {
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
			),
		);
        $response = $this->EmmaClient->trigger_event($dataToSend);
        $this->assertNull($response);
    }
    */
}