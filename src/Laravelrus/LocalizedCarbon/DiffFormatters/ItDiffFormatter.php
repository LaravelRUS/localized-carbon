<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;
class ItDiffFormatter implements DiffFormatterInterface {
    public function format($isNow, $isFuture, $delta, $unit) {
        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'it');
        $txt = $delta . ' ' . $unitStr;
        if ($isNow) {
          if($isFuture){
            $pre= 'Tra ';
            return $pre . $txt;
          }
          else{
            $suffix= ' fa';
            return $txt . $suffix;
          }
        }
        return $txt .= ($isFuture) ? ' dopo' : ' prima';
    }
}
