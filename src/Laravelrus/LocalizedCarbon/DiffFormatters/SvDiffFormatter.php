<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class SvDiffFormatter implements DiffFormatterInterface {

        public function format($isNow, $isFuture, $delta, $unit) {
            $txt = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'sv');
            $txt = $delta.' '.$txt;
            if ($isNow) {
                $txt .= ($isFuture) ? ' från nu' : ' sedan';
                return 'för '.$txt;
            }
            $txt .= ($isFuture) ? ' efter' : ' före';
            return 'om '.$txt;
        }
}