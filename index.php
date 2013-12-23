<?php

$secret_key = "5iutg76t";

$base64 = <<<END
QTk3OUFFN0YzQjdCM0E3MUU0Q0EyQTI2RUQ0Mzk3RkUzNzBBQjVGOTw/eG1sIHZlcnNpb249IjEuMCIgZW5jb2Rpbmc9InV0Zi04Ij8+DQo8UGVyc29uPg0KICA8VXNlcklEPjwhW0NEQVRBWzFGRkY4QkZENDZDQ0JGMzUwQkJBQkI1ODU1M0E2NDg0QzMyNjk1MzhdXT48L1VzZXJJRD4NCiAgPEZpcnN0TmFtZT48IVtDREFUQVtUZXN0IDAwMDJdXT48L0ZpcnN0TmFtZT4NCiAgPExhc3ROYW1lPjwhW0NEQVRBWyBUZXN0XV0+PC9MYXN0TmFtZT4NCiAgPEVtYWlsPjwhW0NEQVRBW21sZTAwMEBmb2EuZGtdXT48L0VtYWlsPg0KPC9QZXJzb24+
END;

echo "http://localhost.it-kartellet.dk/drupal-6.16/?hashauth=".urlencode($base64)."\n";

if(preg_match("/^(?P<hash>[^\<]+)(?P<xml><.+)$/s", base64_decode($base64), $matches)) {
    // Validate XML
    $sha1_validation = sha1($matches[xml] . $secret_key);
    if(strtoupper($sha1_validation) === strtoupper($matches[hash])) {
        $person = simplexml_load_string($matches[xml]);
        if($person) {
            echo "UserID:".$person->UserID."\n";
            echo "Firstname:".$person->FirstName."\n";
            echo "Email:".$person->Email."\n";

        } else {
            die("Could not parse XML");
        }

    } else {
        die("Hash not valid");
    }

} else {
    die("Could not split hash from xml");
}