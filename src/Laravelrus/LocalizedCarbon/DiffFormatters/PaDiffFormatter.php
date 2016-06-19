<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class PaDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {

        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'pa');

        $txt = $delta . ' ' . $unitStr;

        if ($isNow) {
            $when = ($isFuture) ?' وروسته' : ' پخوا';
            return $txt . $when;
        }

        return $txt .= ($isFuture) ? 'وروسته له ' : 'پخوا له ';

    }
}
