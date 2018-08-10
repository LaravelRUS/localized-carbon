<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class BrDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {
        $txt = $delta . ' ' . $unit;
        $txt .= $delta == 1 ? '' : 's';

        if ($isNow) {
            $txt .= ($isFuture) ? ' a partir de agora' : ' atrás';
            return $txt;
        }

        $txt .= ($isFuture) ? ' depois' : ' antes';
        return $txt;
    }
}