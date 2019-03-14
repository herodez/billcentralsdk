<?php

namespace BillSDK\Exceptions;

class BillNotFoundException extends \Exception
{
	protected $message = 'Bill code not found.';
}