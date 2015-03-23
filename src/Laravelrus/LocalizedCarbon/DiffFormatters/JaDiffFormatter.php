<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class JaDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {
        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'ja');
        $txt = $delta . ' ' . $unitStr;

        if ($isNow) {
            $txt .= ($isFuture) ? '今' : '前';
            return $txt;
        }

        $txt .= ($isFuture) ? '前' : '後';
        return $txt;
    }
}
