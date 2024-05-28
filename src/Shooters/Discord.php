<?php
namespace Raineri\KollelogLimited\Shooters;
use Dotenv\Dotenv;
use GuzzleHttp\Client;
use Raineri\KollelogLimited\Browser\RequestBrowserInspector;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();
class Discord
{
  public function triggerFromWebHook()
  {
    $getAllInformation = new RequestBrowserInspector();
    $data = $getAllInformation->getBrowserDataArray();
    $geoInformation = $getAllInformation->geoLocation("104.28.246.4");
    $client = new Client([
    'base_uri' => $_ENV['DISCORD_WEB_HOOK'],
  ]);
    $body = [
      "content" => null,
      "embeds" => [
        [
          "title" => "New Log",
          "description" => "**Trafficking from** `{$data['URI']}`",
          "color" => 5814783,
          "fields" => [
            [
              "name" => "User Agent",
              "value" => "{$data['USER_AGENT']}",
              "inline" => true
            ],
            [
              "name" => "OS",
              "value" => "{$data['OS']}",
              "inline" => true
            ],
            [
              "name" => "IP  :flag_" . strtolower($geoInformation['CONTRY_CODE']) . ":",
              "value" => "{$data['USER_IP']}",
              "inline" => true
            ],
            [
              "name" => "TIME",
              "value" => "{$data['DATE']}",
              "inline" => true
            ],
            [
              "name" => "Request URI",
              "value" => "`{$data['URI']}`",
              "inline" => true
            ],
            [
              "name" => "Domain",
              "value" => "{$data['HOST']}",
              "inline" => true
            ],
            [
              "name" => "CITY",
              "value" => "{$geoInformation['CITY']}",
              "inline" => true
            ],
            [
              "name" => "CONTRY :flag_" . strtolower($geoInformation['CONTRY_CODE']) . ":",
              "value" =>  "{$geoInformation['CONTRY_NAME']}",
              "inline" => true
            ],
            [
              "name" => "CONTINENT",
              "value" => "{$geoInformation['CONTINENT_NAME']}",
              "inline" => true
            ]
          ]
        ]
      ],
      "username" => "KolleLog",
      "attachments" => []
    ];
    $client->request('POST', $_ENV['DISCORD_WEB_HOOK'], ['json' => $body]);
  }
}