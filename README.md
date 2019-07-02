#  Google Analytics library PHP
 Google Analytics library for:
- Analyze your API
- Analyze your image and other file type
- Analyze all server
- Analyze the user how block `127.0.0.1 google-analytics.com 127.0.0.1 www.google-analytics.com`

## Getting Started

- See the [Measurement Protocol Parameter Reference](https://developers.google.com/analytics/devguides/collection/protocol/v1/reference).


## Requirements
- PHP >= 7.1
- JSON PHP Extension
- CURL PHP Extension
- GMP PHP Extension


## Installation
Installing  Google Analytics library using Composer:
```shell
composer require benemohamed/analytics
```

## How to Use
usage is quite simple:
```php
require __DIR__ .'/vendor/autoload.php';
// import
use benemohamed\analytics\Analytics;

$analytics = new Analytics('UA-101958632-2',null);
// null = free TOKEN from https://ipfinder.io or sign up to get your free token ipfinder.io/auth/signup
// UA-101958632-2 = your The tracking ID / web property ID

// The hit type is pageview
$test->send();
```
>  with default we set User agent,user IP,Geographical Override,hostname,path,title

> include this file

## work with available methods

```php
require __DIR__ .'/vendor/autoload.php';
// import
use benemohamed\analytics\Analytics;

$analytics = new Analytics('TRACKING_ID_GOES_HERE','YOUR_IPFINDER_TOKEN_GOES_HERE');


$analytics->set_uagt('dsadasdasdasdsadasd') // User agent
                ->set_hit('pageview')   // Set Hit Type
                ->set_ip('9.9.9.9')    // user IP
                ->set_location('GB')   //  Geographical Override
                ->set_host('google.com')  // hostname
                ->set_path('/hello-world') // The path portion of the page URL. Should begin with '/'.
                ->set_title('hello world - Mohamed ') // The title of the page
                ->set_event_tra('server')         //  Event Tracking
                ->set_event_act('user block')     //  Event Action
                ->set_event_lab('test')           //  Event Action
                ->parms(array(
                     'dr' => 'http://example.com', // Document Referrer
                     'cn' => '(soical)',           // Campaign Name
                     'cm' => 'organic'             // Campaign Medium
                 ))
                ;

$analytics->send(); // make the call to the server

```

## Work with only method ```parms(array())```

lists all of the parameters for the [Measurement Protocol](https://developers.google.com/analytics/devguides/collection/protocol/v1/parameters#dl).

> Note check Required parameters


```php
require __DIR__ .'/vendor/autoload.php';
// import
use benemohamed\analytics\Analytics;

$analytics = new Analytics('TRACKING_ID_GOES_HERE','YOUR_IPFINDER_TOKEN_GOES_HERE');

$analytics-> ->parms(array(
                     'v' => 1,
                     'tid' => 'UA-101958632-2',
                     't' => 'pageview'
                     ......
                     ......
                     ......
                     ......
                     ......
                     ......
                 ));


$analytics->send(); // make the call to the server

```


## Work with php.ini
 [open_basedir](http://php.net/open-basedir)

```shell
php -d open_basedir=file_name
```

file_name now in all file


## Work with javascript

**check if google-analytics.com is load in the client side if not make your action in server side**


## Error handling


```php
$analytics = new Analytics('TRACKING_ID_GOES_HERE','YOUR_IPFINDER_TOKEN_GOES_HERE');


try {
    // do something
} catch (AnalyticsException $e) {
    print $e->getMessage();
}

```

## List methods

```php

$analytics = new Analytics('UA-101958632-2',null);

var_dump(get_class_methods($analytics));

```

| Name          |  Description
| -----------   | ----------- |
| set_hit       | Set Hit Type
| set_ds        | Set Data source e.x(`web`)
| set_ip        | Set IP address e.x(`1.1.1.1`)
| set_uagt      | Set User Agent e.x(`Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/75.0.3770.90 Chrome/75.0.3770.90 Safari/537.3`)
| set_location  | Set Geographical e.x(`DZ`,`MA`,`TN`)
| set_host      | Set hostname e.x(`google.com`)
| set_path      | Set path start with `/`
| set_title     | Set title e.x(`google.com`)
| set_event_tra | Set Event tracking
| set_event_act | Set Event Action
| set_event_lab | Set Event Label
| set_parms     | Set your Parameters


## Supported Hits
- pageview
- event
- screenview
- transaction
- item
- social
- exception
- timing

**use method  `parms(array())` method to pass Required Parameter to other hits**

## Running the tests

```shell
composer test
```

## other

- See the [IPFidner documentation](https://ipfinder.io/docs).
- See the [guzzlephp documentation](http://docs.guzzlephp.org/en/stable/quickstart.html)

## License

----
[![GitHub license](https://img.shields.io/github.com/benemohamed/google-analytics-php.svg)](https://github.com/benemohamed/google-analytics-php/blob/master/LICENSE)
