<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class ArDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {

        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'pr');

        $txt = $delta . ' ' . $unitStr;

        if ($isNow) {
            $when = ($isFuture) ?' بعد' : ' قبل';
            return $txt . $when;
        }

        return $txt .= ($isFuture) ? 'بعد از ' : 'قبل از ';

    }
}
