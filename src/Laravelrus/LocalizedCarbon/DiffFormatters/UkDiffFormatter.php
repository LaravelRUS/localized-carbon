<?php

namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class UkDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {

        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'uk');

        if ($isNow) {

            if ($isFuture) {
                if ($unit == "day" && $delta == 1) {
                    $txt = "завтра";
                } else if (($unit == "year" || $unit == "hour") && $delta == 1) {
                    $txt = "через " . " " . $unitStr;
                } else {
                    $txt = "через " . $delta . " " . $unitStr;
                }
            } else {
                if ($unit == "second" && $delta < 10) {
                    $txt = 'щойно';
                } else if ($unit == "day" && $delta == 1) {
                    $txt = "вчора";
                } else {
                    $txt = $delta . " " . $unitStr . " тому";
                }
            }

        } else {

            if ($isFuture) {
                $txt = $delta . " " . $unitStr . " потому";
            } else {
                $txt = "за " . " " . $delta . " " . $unitStr . " до";
            }

        }


        return $txt;

    }
}
