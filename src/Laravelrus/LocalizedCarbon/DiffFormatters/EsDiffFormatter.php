<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class EsDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {

        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'es');

        $txt = $delta . ' ' . $unitStr;

        if ($isNow) {
            $when = ($isFuture) ?  'En ' : 'Hace ';
            return $when . $txt;
        }

        return $txt .= ($isFuture) ? ' después' : ' antes';
    }
}
