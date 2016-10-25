<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;

class AfDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {
        $txt = $delta . ' ' . $unit;
        $txt .= $delta == 1 ? '' : 's';
        
        if ($isNow) {
            $txt .= ($isFuture) ? ' van nou af' : ' terug';
            return $txt;
        }
        
        $txt .= ($isFuture) ? ' na' : ' voor';
        return $txt;
    }
    
}
