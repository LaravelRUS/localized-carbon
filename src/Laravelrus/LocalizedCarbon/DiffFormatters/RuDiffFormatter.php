<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class RuDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {
        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'ru');

        if ($isNow) {
            if ($isFuture) {
                $txt = "через " . $delta . " " . $unitStr;
            } else {
                if ($unit == "second" && $delta < 10) {
                    $txt = 'только что';
                } else {
                    $txt = $delta . " " . $unitStr . " назад";
                }
            }
        } else {
            if ($isFuture) {
                $txt = "спустя " . $delta . " " . $unitStr;
            } else {
                $txt = "за " . " " . $delta . " " . $unitStr . " до";
            }
        }
        return $txt;
    }
}
