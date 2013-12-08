<?php
namespace Bert\Bert;

class Time
{
    public $megaseconds;
    public $seconds;
    public $microseconds;

    public function __construct($megaseconds, $seconds, $microseconds)
    {
        $this->megaseconds = $megaseconds;
        $this->seconds = $seconds;
        $this->microseconds = $microseconds;
    }
}
