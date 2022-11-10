# easyRestAPI
Code less with this useful Rest API class.
<h3>
  Installation
  </h3>
It is simple, import easyRestAPI.php in your project using include like this:
<br>

```php

<?
include_once("/path/to/easyRestAPI.php");

```
<br>
<h3>
Introduce 
</h3>
First create object of easyRestAPI class where you want handle requests and change settings if you want:
<br>

```

<?
include_once("/path/to/easyRestAPI.php");
$rest = new easyR();
// SETTINGS
$rest->useFilters = TRUE;
$rest->saveLogs = TRUE;
$rest->defaultLogFile = 'my-logs.log';
date_default_timezone_set('Asia/Tehran'); // For saving logs with your custom timezone.
// END OF SETTINGS

```

<br>
Then parse inputs:
<br>

```

$inputs = $rest->inputs; // Get all income data
if($inputs['username']['method'] != 'POST') {
  die('Invalid request!');
}
print_r($inputs);
/*
# Result
array(
  'username' => array(
    'value' => 'pouria',
    'method' => 'POST'
  ),
  'password' => array(
    'value' => 'XXXXXXXXX',
    'method' => 'POST'
  )
)
*/

```

<br>
At the end send your response:
<br>

```

$responseAs = 'json'; // Or text
$rest->response('OK', $responseAs);
/*
  Prepared responses are listed bellow:
    OK
    SUCCESS
    ERROR
    INTERNAL-ERROR
    AUTH-ERROR
    ACCESS-DENIED
    FAILOR
    AUTH-FAILOR
    BAD-REQUEST
  ----------
  For see all details about responses use "print_r($rest->responses);"
*/

```

<br>
Hope this simple library helps in your projects,
Good luck.
