<?php

namespace FTS;

/**
 * EmmaEvents Class
 *
 * @package   EmmaEvents
 * @author    Paden Clayton <sales [at] fasttracksites dot com>
 * @copyright Paden Clayton, 2017
 * @version   1.17.03.20
 *
 * Documentation: http://api.myemma.com/api/external/event_api.html
 **/
class EmmaEvents
{

    /**
     * Emma API Dommain
     * @var string
     */
    private $emma_api_domain = 'events.e2ma.net/v1';

    /**
     * Emma Account Public Key
     * @var string
     */
    private $emma_public_key = '';

    /**
     * Emma Account Private Key
     * @var string
     */
    private $emma_private_key = '';

    /**
     * Emma Account ID
     * @var string
     */
    private $emma_account_id = '';

    /**
     * Contains the last response from Emma. It contains her response code followed
     * by a colon and a textual description
     * @var string
     */
    public $last_emma_response = '';

    /**
     * Contains the headers from the last response from Emma.
     * @var string
     */
    public $last_emma_response_headers = '';

    /**
     * Contains the last response information from Emma. It contains an array
     * of Contains the last response from Emma. It contains various information
     * about the request and response, including the HTTP code.
     * @var array
     */
    public $last_emma_response_info = array();

    /**
     * A debugging variable. Set to true to see debugging output
     * @var boolean
     */
    public $debug = false;

    /**
     * Class constructor
     *
     * @param  string|array $account_id  The Emma Account ID on which to perform actions, or an array of params
     * @param  string       $public_key  The Emma public key for the account
     * @param  string       $private_key The Emma private key for the account
     * @return boolean false if $account_id is not provided
     **/
    function __construct($account_id, $public_key=null, $private_key=null)
    {

        if (is_array($account_id) ) {
            $params = $account_id;
            $account_id = isset($params['account_id']) ? $params['account_id'] : null;
            $public_key = isset($params['public_key']) ? $params['public_key'] : null;
            $private_key = isset($params['private_key']) ? $params['private_key'] : null;
        }

        if (empty($account_id) || empty($public_key) || empty($private_key) ) {
            throw new \Exception('Emma Error: no account id, public key, or private key sent to constructor.');
        }

        // Save account ID to class object variable
        $this->emma_account_id = $account_id;
        $this->emma_public_key = $public_key;
        $this->emma_private_key = $private_key;

    }

    /**
     * Make a request to the Emma API
     *
     * @param  string $api_method  The API method to be called
     * @param  string $http_method The HTTP method to be used (GET, POST, PUT, DELETE, etc.)
     * @param  array  $data        Any data to be sent to the API
     * @return string|array API request results
     **/
    function make_request($api_method, $http_method = null, $data = null)
    {

        // Set query string
        $get_query_string = '';
        if (($http_method == 'GET' || $http_method == 'DELETE') && !empty($data) ) {
            $get_query_string = '?';
            $get_query_string .= http_build_query($data);
        }

        // Set request
        $request_url = 'https://'.$this->emma_api_domain.'/'.$this->emma_account_id.'/'.$api_method.$get_query_string;

        // Debugging output
        if ($this->debug) {
            echo 'HTTP Method: '.$http_method."\n";
            echo 'Request URL: '.$request_url."\n";
        }

        // Create a cURL handle
        $ch = curl_init();

        // Set the request
        curl_setopt($ch, CURLOPT_URL, $request_url);

        // Use HTTP Basic Authentication
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        // Set the public_key and private_key
        curl_setopt($ch, CURLOPT_USERPWD, $this->emma_public_key.':'.$this->emma_private_key);

        // Save the response to a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Send data as PUT request
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);

        // This may be necessary, depending on your server's configuration
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        // Send data
        if (!empty($data) ) {
            $postdata = json_encode($data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            	'Content-Length: ' . strlen($postdata),
            	'Accept: application/json',
				'Content-Type: application/json',
            ));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);

            // Debugging output
            if ($this->debug) {
                echo 'JSON Post Data: '.$postdata."\n";
            }
        }

        // Execute cURL request
        curl_setopt($ch, CURLOPT_HEADER, true);
        $curl_response = curl_exec($ch);
        $curl_info = curl_getinfo($ch);

        // Debugging
        if ($this->debug) {
            //$status = curl_getinfo($ch);
            //var_dump($status);
            //var_dump($curl_response);
        }

        // Close cURL handle
        curl_close($ch);

        // Parse response
        list($curl_response_headers, $curl_response) = preg_split("/\R\R/", $curl_response, 2);
        if ($this->count ) {
            $parsed_result = $curl_response;
        }
        else {
            $parsed_result = $this->parse_response($curl_response);
        }

        // Save response to class variable for use in debugging
        $this->last_emma_response = $curl_response;
        $this->last_emma_response_headers = $curl_response_headers;
        $this->last_emma_response_info = $curl_info;

        // Return parsed response
        return $parsed_result;
    }

    /**
     * Parse Response
     *
     * @param  string|array $response A json-formatted API response
     * @return string|array API request results
     **/
    function parse_response($response)
    {
        $data = json_decode($response);
        return $data;
    }

    /* *** BEGIN `EVENTS` METHODS *** */

    /**
     * Trigger Event
     *
     * @param  array $send_data An array of event information
     * @return string|array API request results
     **/
    function trigger_event($send_data)
    {
        $data = $this->make_request('events', 'POST', $send_data);
        return $data;
    }

    /* *** END `EVENTS` METHODS *** */

} // END class