<?php
namespace Laravelrus\LocalizedCarbon\DiffFormatters;
class FaDiffFormatter implements DiffFormatterInterface {
    public function format($isNow, $isFuture, $delta, $unit) {
        $txt = $delta . ' ' . $unit;
        if ($isNow) {
            $txt .= ($isFuture) ? ' از حالا' : ' گذشته';
            return $txt;
        }
        $txt .= ($isFuture) ? ' بعد' : ' قبل';
        return $txt;
    }
}
