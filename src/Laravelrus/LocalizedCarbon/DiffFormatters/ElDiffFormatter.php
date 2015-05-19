<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;

class ElDiffFormatter implements DiffFormatterInterface {
    public function format($isNow, $isFuture, $delta, $unit) {
        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'el');
        $txt = $delta . ' ' . $unitStr;
        if ($isNow) {
            $when = ($isFuture) ?  'από τώρα' : 'πρίν';
            return $when . $txt;
        }
        return $txt .= ($isFuture) ? 'μετά' : ' πρίν';
    }
}
