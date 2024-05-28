<?php
include("vendor/autoload.php");

use Dotenv\Dotenv;
use Raineri\KollelogLimited\Browser\RequestBrowserInspector;
use Raineri\KollelogLimited\Rules\Rules;
use Raineri\KollelogLimited\Shooters\Discord;

$getAllInformation = new RequestBrowserInspector();
$rules = new Rules();
$browserData = $getAllInformation->getBrowserDataArray();
$tempDiscord = new Discord();

// Add the URIs you want to retrieve.
// if you want to retrieve all the URIs just leave them empty or comment out the method.
$rules->setRuleAllowed(
  [
    "/",
    "/test"
  ]
);

// Add the URIs you don't want to pick up.
//if you want to pick up all the URIs just leave them empty or comment out the method.
$rules->setRuleBLocked(
  [
  "/dev"
  ]
);

$tempDiscord->triggerFromWebHook();