<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class EnDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {
        $txt = $delta . ' ' . $unit;
        $txt .= $delta == 1 ? '' : 's';

        if ($isNow) {
            $txt .= ($isFuture) ? ' from now' : ' ago';
            return $txt;
        }

        $txt .= ($isFuture) ? ' after' : ' before';
        return $txt;
    }
}
