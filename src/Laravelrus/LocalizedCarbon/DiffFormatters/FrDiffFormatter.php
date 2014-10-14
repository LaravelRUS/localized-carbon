<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class FrDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {

        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'fr');

        $txt = $delta . ' ' . $unitStr;

        if ($isNow) {
            $when = ($isFuture) ?  'Dans ' : 'Il y a ';
            return $when . $txt;
        }

        return $txt .= ($isFuture) ? ' après' : ' avant';

    }
}
