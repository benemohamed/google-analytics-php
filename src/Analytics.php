<?php namespace benemohamed\analytics;

/*
 * Copyright 2019 Mohamed Benrebia <mohamed@ipfinder.io>
 *
 * @package   analytics
 * @author    Mohamed Benrebia <mohamed@ipfinder.io>
 * @copyright 2019 Mohamed Benrebia
 * @license   https://opensource.org/licenses/Apache-2.0 Apache License, Version 2.0
 */

use benemohamed\analytics\Exception\AnalyticsException;
use benemohamed\analytics\UUID\Uuid;
use ipfinder\ipfinder\IPfinder as Ip;
use ipfinder\ipfinder\Validation\Ipvalidation;
use ipfinder\ipfinder\Validation\Domainvalidation;
use ipfinder\ipfinder\Exception\IPfinderException;
use benemohamed\analytics\Validation\HitTypevalidation;
use benemohamed\analytics\Validation\TrackingIdvalidation;
use GuzzleHttp\Client as Curl;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Exception;
// class Analytics implements AnalyticsInterface


/**
 * Main Analytics
 */
class Analytics
{

    /**
     * Note:
     * - delete the host on your hosts file
     * - 127.0.0.1 google-analytics.com
     * - 127.0.0.1 www.google-analytics.com
     * - cURL error 7: Failed to connect to www.google-analytics.com port 443: Connection refused (see http://curl.haxx.se/libcurl/c/libcurl-errors.html
     */

    /**
     * @see  http://docs.guzzlephp.org/en/stable/quickstart.html This page provides a quick introduction to Guzzle and introductory examples
     * @see  https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dl
     * Required values for hit type :pageview/event.
     * >> The Protocol version.
     * >> The tracking ID / web property ID.
     * >> The type of hit.
     * -- in event
     * >> Event Category.
     * >> Event Action.
     */


    /**
     * List Optional values for hit type :pageview/event.
     * ---------------          | --------------- |---------------
     * Parameter name           | (parm|type)     | Parameter description
     * ---------------          | --------------- |---------------
     * >> Data Source           |  (ds|string)    | data source set to 'web','call center' -note use urlencode(str);
     * >> Client ID             |  (cid|string)   | random UUID (version 4) Example usage: cid=35009a79-1a05-49d7-b876-2b884d0f825b
     * >> User ID               |  (uid|string)   | This field is required if Client ID (cid)
     * >> Session               |  (sc|string)    | Session Control Example usage: sc=start
     * >> IP Override           |  (uip|string)   | The IP address of the user
     * >> User Agent Override   |  (ua|string)    | The User Agent of the browser
     * >> Geographical Override |  (geoid|string) | Example usage: geoid=US
     * >> Document Host Name    |  (dh|string)    | domain name
     * >> Document Path         |  (dp|string)    | The path portion of the page URL. Should begin with '/'
     * >> Document Title        |  (dt|string)    | The title of the page
     * >> Event Tracking        |  (ec|string)    | Specifies the event category. Must not be empty
     * >> Event Action          |  (ea|string)    | Specifies the event action. Must not be empty.
     * >> Event Label           |  (el|string)    | Specifies the event label.
     */



    /**
     * IPFinder TOKEN
     *
     * @see sign up to get your free token https://ipfinder.io/auth/signup
     * @var string
     */
    const FREE_TOKEN  = 'free';


    const PARAMETERS = array(
        0  => 'v',
        1  =>  'tid', // tracking ID
        2  =>  't',   // hit
        3  =>  'ds',  // Data Source
        4  =>  'cid', // Client ID
        5  =>  'uid', // User ID
        6  =>  'sc',  // Session
        7  =>  'uip', // IP
        8  =>  'us', // user ag
        9  =>  'geoid', // location
        10  =>  'dh',  // host
        11 =>  'dp',  // path
        12 =>  'dt',  // title
        13 =>  'ec',  // e Tracking
        14 =>  'ea',  // e Action
        15 =>  'el'   // e Label
    );

    /**
     * The Protocol version
     */
    private $protocol_version = 1;


    /**
     * URL Endpoint
     * You can send data using either `POST` or `GET` requests.
     *
     * @var string
     */
    private $endpoint = 'https://www.google-analytics.com/collect?';

    /**
     * IPFinder token
     *
     * @var string
     */
    public $ipfinder_apitoken;
    /**
     * The tracking ID / web property ID
     *
     * @var string
     */
    public $trackingId;

    /**
     * user agent
     *
     * @var string
     */
    public $agent;

    /**
     * IP Address
     *
     * @var string
     */
    public $ip;

    /**
     * Data Source
     *
     * @var string
     */
    public $data_source;


    /**
     * $hit type
     *
     * @var string
     */
    public $hit;

    /**
     * ISO 3166-1 alpha-2 country code
     *
     * @var string
     */
    public $country_code;

    /**
     * Session
     *
     * @var string
     */
    public $session;
    /**
     * $Uuid_v4 random UUID
     *
     * @var string
     */
    public $Uuid_v4;


    /**
     * host without http or https
     *
     * @var string
     */
    public $host;

    /**
     * path host start with /
     *
     * @var string
     */
    public $path;


    /**
     * path page title
     *
     * @var string
     */
    public $title;

    /**
     * Event tracking
     *
     * @var string
     */
    public $event_tracking;

    /**
     * Event Action
     *
     * @var string
     */
    public $event_action;

    /**
     * Event label
     *
     * @var string
     */
    public $event_label;

    /**
     * your costum parameter
     *
     * @var string
     */
    public $parms;


    /**
     *
     * @var string
     */
    public $payload_data;

    /**
     *
     * @var string
     */
    public $payload_query;
    /**
     * guzzlephp class
     *
     * @var [type]
     */
    protected $guzzlephp;

    /**
     * ipfinder class
     *
     * @var [type]
     */
    protected $ipfinder;

    /**
     * Construct
     *
     * @see    SIGN UP TO GET FREE TOKEN 4.000  requests per day https://ipfinder.io/auth/signup
     * @param  string $trackingId          The tracking ID / web property ID
     * @param  string $ipfinder_token|null ipfinder API TOKEN
     * @throws AnalyticsException
     */
    public function __construct(string $trackingId, string $ipfinder_token = null)
    {
        if (empty($trackingId)) {
            throw new AnalyticsException("trackingId required Example value: UA-XXXX-Y");
        } else {
             TrackingIdvalidation::validate($trackingId);
             $this->trackingId =  $trackingId;
        }
        if (empty($ipfinder_token)) {
            $this->ipfinder_apitoken = null; // null = (string)'free'
        } else {
            $this->ipfinder_apitoken = (string)$ipfinder_token;
        }
        $this->ipfinder = new Ip($this->ipfinder_apitoken);
        $this->guzzlephp = new Curl(
            [
                         //   'base_uri' => $this->endpoint,
                            'http_errors' => false
            ]
        ); // 'timeout'  => 2.0,
    }

    /**
     * Call to google
     *
     * @param  array $parameters
     * @return mixed
     * @throws AnalyticsException
     */
    private function call(array $parameters = array())
    {

        /* I decided to use guzzlephp : composer require guzzlehttp/guzzle
        if (!function_exists('curl_init')) {
            throw new AnalyticsException("Curl require pleaser install php7.x-curl ");
        }
        */

        try {
            $this->payload_query = http_build_query($parameters, null, '&');
            $response = $this->guzzlephp->request(
                'GET',
                $this->endpoint,
                [
                'query' => $this->payload_query,'headers' => [ // set  Request headers
                'User-Agent' => 'Analytics php-client v1.0.0',
                'Authority' =>'www.google-analytics.com',
                'Upgrade-Insecure-Requests' =>1,
                'Accept' =>'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3',
                'Accept-Language' =>'en-US,en;q=0.9,ar;q=0.8,es;q=0.7,fr;q=0.6'
                ]
                ]
            );
        } catch (GuzzleException $e) {
            throw new AnalyticsException($e->getMessage());
        } catch (Exception $e) {
            throw new AnalyticsException($e->getMessage());
        }
       # echo $response->getStatusCode(); // satatus code always 200 ok
    }

    /**
     * Set Hit Type
     *
     * @param  string|null $type
     * @throws AnalyticsException
     */
    public function set_hit(string $type = null)
    {

        if (!empty($type)) {
             HitTypevalidation::validate($type);
             $this->hit = $type;
        } else {
             $this->hit = 'pageview';
        }
        return $this;
    }


    /**
     * Set Data Source
     *
     * @param  string|null $source
     * @throws AnalyticsException
     */
    public function set_ds(string $source = null)
    {
        if (!empty($source)) {
             $this->data_source = (string)$source;
        } else {
             $this->data_source = (string)'web';
        }
        return $this;
    }

    /**
     * Set Client Id
     *
     * @throws AnalyticsException
     * @return string
     */
    public function set_clid()
    {
        return  $this->Uuid_v4 = (string)Uuid::v4();
    }

    /**
     * Set Session
     */
    public function set_session()
    {
        if (session_id() == '') {
            session_start();
            return  $this->session = session_id();
        }
    }

    /**
     * Set IP address of the user
     *
     * @param  string|null $ip
     * @throws IPfinderException
     */
    public function set_ip(string $ip = null)
    {
        if (!empty($ip)) {
            Ipvalidation::validate($ip);
             $this->ip = (string)$ip;
        } else {
                // check if the user have one of this keys
            foreach (array('REMOTE_ADDR', 'HTTP_X_FORWARDED', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'HTTP_CLIENT_IP') as $key) {
                if (array_key_exists($key, $_SERVER) === true) {
                    foreach (explode(',', $_SERVER[$key]) as $ips) {
                        Ipvalidation::validate($ips);
                         $this->ip = (string)$ips;
                    }
                }
            }
        }
        return $this;
    }

    /**
     * Set User Agent
     *
     * @param  string|null $uagt
     * @throws AnalyticsException
     */
    public function set_uagt(string $uagt = null)
    {

        if (!empty($uagt)) {
            // if (!is_string($type)) {
            //    throw new AnalyticsException("User Agent mast be string");
            // }
              $this->agent = (string)$uagt;
        } else {
              $this->agent = (string)$_SERVER['HTTP_USER_AGENT'];
        }
        return $this;
    }

    /**
     * Set Geographical
     *
     * @param  string|null $geo
     * @throws IPfinderException
     */
    public function set_location(string $geo = null)
    {

        if (!empty($geo)) {
            if (strlen($geo) > 2) {
                throw new IPfinderException("the string mast be ISO 3166-1 alpha-2 country e.x(DZ,TN,MA)");
            }
             $this->country_code = (string)$geo;
        } else {
            $details = $this->ipfinder->getAddressInfo($this->ip);

             $this->country_code = (string)$details->country_code;
        }
        return $this;
    }

    /**
     * Set Host Name
     *
     * @param  string|null $host
     * @throws IPfinderException
     */
    public function set_host(string $host = null)
    {
        if (!empty($host)) {
            Domainvalidation::validate($host);
             $this->host = (string)$host;
        } else {
             $this->host = (string)$_SERVER['SERVER_NAME'];
            ;
        }

        return $this;
    }

    /**
     * Set host path
     *
     * @param string|null $path
     */
    public function set_path(string $path = null)
    {
        if (!empty($path)) {
             $this->path = (string)$path;
        } else {
             $this->path = (string)$_SERVER['REQUEST_URI'];
        }

        return $this;
    }


    /**
     * Set host path title
     *
     * @param  string|null $title
     * @throws AnalyticsException
     */
    public function set_title(string $title = null)
    {
        if (!empty($title)) {
             $this->title =  (string)$title;
        } else {

            $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
            $cont    = file_get_contents($link);
            preg_match("/<title>(.*?)<\/title>/s", $cont, $match);
             $this->title = (string)$match[1];
        }

        return $this;
    }


    /**
     * Set Event Tracking
     *
     * @param  string|null $tracking
     * @throws AnalyticsException
     */
    public function set_event_tra(string $tracking = null)
    {
        if (!empty($tracking)) {
             $this->event_tracking =(string)$tracking;
        } else {
            // must not be empty
             $this->event_tracking = (string)'Action from php';
        }

        return $this;
    }


    /**
     * Set Event Action
     *
     * @param  string|null $action
     * @throws AnalyticsException
     */
    public function set_event_act(string $action = null)
    {
        if (!empty($action)) {
             $this->event_action =(string)$action;
        } else {
            // must not be empty
             $this->event_action = (string)'from php actiion';
        }

        return $this;
    }

    /**
     * Set Event Label
     *
     * @param  string|null $action
     * @throws AnalyticsException
     */
    public function set_event_lab(string $label = null)
    {
        if (!empty($label)) {
             $this->event_label =(string)$label;
        } else {
             $this->event_label = (string)'from php label';
        }

        return $this;
    }

    /**
     * costum Parameters
     *
     * @param  array $parm
     * @throws AnalyticsException
     */
    public function set_parms(array $parm = array())
    {

        if (empty($action)) {
            $this->parms = (array)$parm;
        }

        return $this;
    }

    /**
     * send data to URL
     *
     * @return mixed
     */
    public function send()
    {
        $array = array();
        if (empty($this->hit) or $this->hit == null) {
            $array[] = $this->set_hit();
        }
        if (empty($this->data_source) or $this->data_source == null) {
            $array[] = $this->set_ds();
        }
        if (empty($this->ip) or $this->ip == null) {
            $array[] = $this->set_ip();
        }
        if (empty($this->agent) or $this->agent == null) {
            $array[] = $this->set_uagt();
        }
        if (empty($this->country_code) or $this->country_code == null) {
            $array[] = $this->set_location();
        }
        if (empty($this->host) or $this->host == null) {
            //   $this->host = $this->set_host();
        }
        if (empty($this->path) or $this->path == null) {
            $array[] = $this->set_path();
        }
        if (empty($this->title) or $this->title == null) {
            $array[] = $this->set_title();
        }

        if (!empty($this->parms) or $this->parms !== null) {
            $par = array();
            foreach ($this->parms as $key => $value) {
                $par[$key]   = $value;
            }
        }

        if ($this->hit == null && $this->data_source == null && $this->ip == null && $this->agent == null && $this->country_code == null && $this->host == null && $this->path == null && $this->title == null) {
            $this->payload_data =  [
                self::PARAMETERS[0] => $array[0]['protocol_version'],
                self::PARAMETERS[1] =>$array[0]['trackingId'],
                self::PARAMETERS[2] => $array[0]['hit'],
                self::PARAMETERS[3] =>$array[0]['data_source'],
                self::PARAMETERS[4] =>$this->set_clid(),
            //  self::PARAMETERS[5] =>$this->set_session(),
            //  self::PARAMETERS[6] =>$this->set_session(),
                self::PARAMETERS[7] =>$array[0]['ip'],
                self::PARAMETERS[8] =>$array[0]['agent'],
                self::PARAMETERS[9] =>$array[0]['country_code'],
            //   self::PARAMETERS[10] =>$this->host,
                self::PARAMETERS[11] =>$array[0]['path'],
                self::PARAMETERS[12] =>$array[0]['title'],
                 ];
        } else {
            $data = [
                self::PARAMETERS[0] => $this->protocol_version,
                self::PARAMETERS[1] =>$this->trackingId,
                self::PARAMETERS[2] => $this->hit,
                self::PARAMETERS[3] =>$this->data_source,
                self::PARAMETERS[4] =>$this->set_clid(),
            //  self::PARAMETERS[5] =>$this->set_session(),
            //  self::PARAMETERS[6] =>$this->set_session(),
                self::PARAMETERS[7] =>$this->ip,
                self::PARAMETERS[8] =>$this->agent,
                self::PARAMETERS[9] =>$this->country_code,
            //   self::PARAMETERS[10] =>$this->host,
                self::PARAMETERS[11] =>$this->path,
                self::PARAMETERS[12] =>$this->title,
                self::PARAMETERS[13] =>$this->event_tracking,
                self::PARAMETERS[14] =>$this->event_action,
                self::PARAMETERS[15] =>$this->event_label,
                 ];
            if (isset($par)) {
                 $this->payload_data  = array_unique(array_merge($data, $this->parms)); // remove duplicate values from an array and merge one or more arrays
            } else {
                 $this->payload_data = $data;
            }
        }


        $this->call($this->payload_data);
        return $this;
    }
}


// author    : mohamed benrebia
// data start: 27/06/2019
