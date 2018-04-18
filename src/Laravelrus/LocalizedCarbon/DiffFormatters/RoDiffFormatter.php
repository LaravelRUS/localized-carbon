<?php

namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class RoDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {

        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'ro');

        if ($isNow) {
            $pre = $isFuture ? 'în ' : 'acum ';
            $suffix = '';

            switch ($unit) {
                case 'second': $deltaInWords = 'einer'; break;
                case 'minute': $deltaInWords = 'einer'; break;
                case 'hour': $deltaInWords = 'einer'; break;
                case 'day': $deltaInWords = 'o'; $suffix = 'n'; break;
                case 'week': $deltaInWords = 'o'; break;
                case 'month': $deltaInWords = 'o'; $suffix = 'n'; break;
                case 'year': $deltaInWords = 'un'; $suffix = 'n'; break;
            }

            if($delta == 1) {
                $delta = $deltaInWords;
                $suffix = '';
            }

            return $pre . $delta . ' ' . $unitStr . $suffix;
        } else {
            $post = ($isFuture) ? ' înainte' : ' danach'; // früher/später, vorher/nachher, davor/danach, bevor/nachdem

            if($delta == 1) {
                switch ($unit) {
                    case 'second': $delta = 'o'; break;
                    case 'minute': $delta = 'un'; break;
                    case 'hour': $delta = 'o'; break;
                    case 'day': $delta = 'o'; break;
                    case 'week': $delta = 'o'; break;
                    case 'month': $delta = 'o'; break;
                    case 'year': $delta = 'un'; break;
                }
            }

            return $delta . ' ' . $unitStr . $post;
        }
    }
}
