<?php
namespace Raineri\KollelogLimited\Browser;
use GuzzleHttp\Client;

class Rules
{
	private array $URIAllowed;
	private array $URIBlocked;

	public function setRuleAllowed(array $URI) : void
	{
		$this->URIAllowed[] = $URI;
	}

	public function setRuleBLocked(array $URI) : void
	{
		$this->URIBlocked = $URI;
	}

	public function getRulesAllowed() : array
	{
		return $this->URIAllowed[0];
	}

	public function getRulesBlocked() : array
	{
		return $this->URIBlocked;
	}
}
