<?php

namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class DeDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {

        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'de');

        if ($isNow) {
            $pre = $isFuture ? 'in ' : 'vor ';
            $suffix = '';

            switch ($unit) {
                case 'second': $deltaInWords = 'einer'; break;
                case 'minute': $deltaInWords = 'einer'; break;
                case 'hour': $deltaInWords = 'einer'; break;
                case 'day': $deltaInWords = 'einem'; $suffix = 'n'; break;
                case 'week': $deltaInWords = 'einer'; break;
                case 'month': $deltaInWords = 'einem'; $suffix = 'n'; break;
                case 'year': $deltaInWords = 'einem'; $suffix = 'n'; break;
            }

            if($delta == 1) {
                $delta = $deltaInWords;
                $suffix = '';
            }

            return $pre . $delta . ' ' . $unitStr . $suffix;
        } else {
            $post = ($isFuture) ? ' davor' : ' danach'; // früher/später, vorher/nachher, davor/danach, bevor/nachdem

            if($delta == 1) {
                switch ($unit) {
                    case 'second': $delta = 'eine'; break;
                    case 'minute': $delta = 'eine'; break;
                    case 'hour': $delta = 'eine'; break;
                    case 'day': $delta = 'ein'; break;
                    case 'week': $delta = 'eine'; break;
                    case 'month': $delta = 'ein'; break;
                    case 'year': $delta = 'ein'; break;
                }
            }

            return $delta . ' ' . $unitStr . $post;
        }
    }
}
