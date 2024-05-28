<?php
namespace Raineri\KollelogLimited\Rules;
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

  public function verifyRulesAllowed(array $rules) : bool
  {
    return false;
  }
}
