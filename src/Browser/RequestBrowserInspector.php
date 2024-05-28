<?php
namespace Raineri\KollelogLimited\Browser;
use GuzzleHttp\Client;

class RequestBrowserInspector 
{
    private function getPrivateData()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            echo '
        <script>
        function collectDeviceInfo() {
            var numCPUs = navigator.hardwareConcurrency || 1;
            var language = navigator.language || navigator.userLanguage;
            var platform = navigator.platform;
            var userAgent = navigator.userAgent;
            var screenWidth = window.screen.width;
            var screenHeight = window.screen.height;

            var deviceInfo = {
                cpus: numCPUs,
                language: language,
                platform: platform,
                userAgent: userAgent,
                screenWidth: screenWidth,
                screenHeight: screenHeight
            };

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("device_info=" + JSON.stringify(deviceInfo));
        }
        window.onload = collectDeviceInfo;
    </script>
    ';
        }
        $info = [];
        if (isset($_SESSION['NUM_CPUS'])) {
            $info['NUM_CPUS'] = $_SESSION['NUM_CPUS'];
        }
        if (isset($_SESSION['LANGUAGE'])) {
            $info['LANGUAGE'] = $_SESSION['LANGUAGE'];
        }
        if (isset($_SESSION['PLATFORM'])) {
            $info['PLATFORM'] = $_SESSION['PLATFORM'];
        }
        if (isset($_SESSION['USER_AGENT'])) {
            $info['USER_AGENT'] = $_SESSION['USER_AGENT'];
        }
        if (isset($_SESSION['SCREEN_WIDTH'])) {
            $info['SCREEN_WIDTH'] = $_SESSION['SCREEN_WIDTH'];
        }
        if (isset($_SESSION['SCREEN_HEIGHT'])) {
            $info['SCREEN_HEIGHT'] = $_SESSION['SCREEN_HEIGHT'];
        }
        session_destroy();
        return $info;
    }
    public function getBrowserDataArray() : array 
    {
        $private = $this->getPrivateData();
        $broserData =
        [
            "DATE" => date("m/d/y | G:i:s",$_SERVER['REQUEST_TIME']) ?? "Unable",
            "USER_AGENT" => $_SERVER['HTTP_USER_AGENT'] ?? "Unable",
            "HOST" => $_SERVER['HTTP_HOST'] ?? "Unable",
            "USER_IP" => $_SERVER['REMOTE_ADDR'] ?? "Unable",
     		"OS" => $_SERVER['HTTP_SEC_CH_UA_PLATFORM'] ?? "Unable",
            "NUM_CPUS" => $private['NUM_CPUS'] ?? "Unable",
            "LANGUAGE" => $private['LANGUAGE'] ?? "Unable",
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
		$ipData = json_decode(file_get_contents(
            "http://www.geoplugin.net/json.gp?ip={$userIp}"),
            true);
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