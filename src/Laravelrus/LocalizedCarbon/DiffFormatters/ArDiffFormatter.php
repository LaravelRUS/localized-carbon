<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class ArDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {

        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'ar');

        $txt = $delta . ' ' . $unitStr;

        if ($isNow) {
            $when = ($isFuture) ?' من الآن' : ' مرّت';
            return $txt . $when;
        }

        return $txt .= ($isFuture) ? 'بعد ' : 'قبل ';

    }
}
