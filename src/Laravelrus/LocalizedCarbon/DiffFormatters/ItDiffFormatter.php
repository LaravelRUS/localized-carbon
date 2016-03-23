<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;
class ItDiffFormatter implements DiffFormatterInterface {
    public function format($isNow, $isFuture, $delta, $unit) {
        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'it');
        if($delta == 1){
            switch($unit){
                case 'hour': 
                    $delta = 'Un\'';
                    break;
                case 'week':
                    $delta = 'Una';
                    break;
                default:
                    $delta = 'Un';
                    break;
            }
        }
        $txt = $delta . ' ' . $unitStr;
        if ($isNow) {
          if($isFuture){
            $pre= 'Tra ';
            return $pre . strtolower($txt);
          }
          else{
            $suffix= ' fa';
            return $txt . $suffix;
          }
        }
        return $txt .= ($isFuture) ? ' dopo' : ' prima';
    }
}
