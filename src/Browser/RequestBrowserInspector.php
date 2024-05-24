<?php
namespace Raineri\KollelogLimited\Browser;
use GuzzleHttp\Client;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class RequestBrowserInspector 
{
    public function getBrowserDataArray() : array 
    {
        $broserData =
        [
            "DATE" => date("m-d-y|G-i-s",$_SERVER['REQUEST_TIME']) ?? "Unable",
            "USER_AGENT" => $_SERVER['HTTP_USER_AGENT'] ?? "Unable",
            "HOST" => $_SERVER['HTTP_HOST'] ?? "Unable",
            "USER_IP" => $_SERVER['REMOTE_ADDR'] ?? "Unable",
     		"OS" => $_SERVER['HTTP_SEC_CH_UA_PLATFORM'] ?? "Unable",
      		"COMPUTER_USER" => $SERVER['USERDOMAIN_ROAMINGPROFILE'] ?? "Unable",
            "URI" => $_SERVER['REQUEST_URI'] ?? "Unable"
        ];
        if(!$broserData)
        {
            return ["ERROR" => "Couldn't get the information"]; 
        }
        return $broserData;
    }

	public function geoLocation(string $userIp)
	{
		$ipData = json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip={$userIp}"), true); // Temp IP
		$ipDataArray = [
			"CONTINENT_CODE" => $ipData['geoplugin_continentCode'] ?? "Unable",
			"CONTINENT_NAME" => $ipData['geoplugin_continentName'] ?? "Unable",
			"CONTRY_NAME" => $ipData['geoplugin_countryName'] ?? "Unable",
			"CONTRY_CODE" => $ipData['geoplugin_countryCode'] ?? "Unable",
			"CONTRY_CURRENCY" => $ipData['geoplugin_currencyCode'] ?? "Unable",
			"CITY" => $ipData['geoplugin_city'] ?? "Unable",
			"REGION_CODE" => $ipData['geoplugin_regionCode'] ?? "Unable",
			"REGION_NAME" => $ipData['geoplugin_regionName'] ?? "Unable"
        ];
		if(!$ipDataArray)
        {
            return ["ERROR" => "Couldn't get the information"]; 
        }
        return $ipDataArray;
	}
}