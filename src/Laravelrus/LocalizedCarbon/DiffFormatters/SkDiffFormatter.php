<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class SkDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit)
    {
        $unitStr = \Lang::choice('localized-carbon::units.' . (($isFuture || !$isNow) ? '_' : '') . $unit, $delta, array(), 'sk');

        if ($isNow) {
            if ($isFuture) {
                if ($unit == 'second' && $delta < 10) {
                    $txt = 'za chvíľu';
                } else if ($unit == 'day' && $delta == 1) {
                    $txt = 'zajtra';
                } else {
                    $txt = 'za ' . ($delta > 1 ? $delta . ' ' : '') . $unitStr;
                }
            } else {
                if ($unit == 'second' && $delta < 10) {
                    $txt = 'pred chvíľou';
                } else if ($unit == 'day' && $delta == 1) {
                    $txt = 'včera';
                } else {
                    $txt = 'pred ' . ($delta > 1 ? $delta . ' ' : '') . $unitStr;
                }
            }
        } else {
            $txt = ($delta > 1 ? $delta . ' ' : '') . $unitStr;
            $txt .= ($isFuture) ? ' potom' : ' predtým';
        }
        return $txt;
    }
}
