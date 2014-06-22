<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;

interface DiffFormatterInterface {
    public function format($isNow, $isFuture, $delta, $unit);
}
