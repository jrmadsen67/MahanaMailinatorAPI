# MahanaMailinatorAPI

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/brnlbs/mailinator/blob/master/LICENSE)

Php Mailinator API library

## Token
Create a [Mailinator](http://www.mailinator.com) account, login, and find your token at [https://www.mailinator.com/settings.jsp](https://www.mailinator.com/settings.jsp)

## Requirements
You need to have the [cURL](http://php.net/manual/en/book.curl.php)-extension installed on your server. [PHP](http://www.php.net) 5.4 will suffice.

## Installation
`composer require jrmadsen67/mahana-mailinator-api`

## Usage
$token = 'whateveryourtokenisfromabove';

$mahanaMailinator = new jrmadsen67\MahanaMailinatorAPI\MahanaMailinatorAPI($token);

//Get messages in inbox//

$inbox = 'myinbox';

$messages = $mahanaMailinator->fetchInbox($inbox);

//Get a message//

$message = $mahanaMailinator->fetchMail($msgId);

//Delete a message//

$status = $mahanaMailinator->deleteMail($msgId);
