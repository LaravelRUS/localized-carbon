<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class NlDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {
        $txt = $delta . ' ' . \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'nl');

        if ($isNow) {
            $txt .= ($isFuture) ? ' in de toekomst' : ' geleden';
            return $txt;
        }

        $txt .= ($isFuture) ? ' na' : ' voor';
        return $txt;
    }
}
