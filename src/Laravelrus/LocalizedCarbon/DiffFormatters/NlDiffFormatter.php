<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class NlDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {
        $txt = $delta . ' ' . $unit;
        $txt .= $delta == 1 ? '' : 's';

        if ($isNow) {
            $txt .= ($isFuture) ? ' in de toekomst' : ' geleden';
            return $txt;
        }

        $txt .= ($isFuture) ? ' na' : ' voor';
        return $txt;
    }
}
