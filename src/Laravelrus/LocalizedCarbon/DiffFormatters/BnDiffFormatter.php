<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;


class BnDiffFormatter implements DiffFormatterInterface {

    public function format($isNow, $isFuture, $delta, $unit) {
        $txt = $this->translateNumber($delta) . ' ' . $unit;

        if ($isNow) {
            $txt .= ($isFuture) ? ' এখন থেকে' : ' আগে';
            return $txt;
        }

        $txt .= ($isFuture) ? ' ' : ' আগে';
        return $txt;
    }

    public static function translateNumber($number) {
        if(is_numeric($number)) {
            $arrNumber = str_split($number);
        }
        else {
            return $number;
        }
        $transNumber = [];
        foreach($arrNumber as $number) {
            switch($number) {
                case '.':
                    array_push($transNumber, '. ');
                    break;
                case 0:
                    array_push($transNumber, '০');
                    break;
                case 1:
                    array_push($transNumber, '১');
                    break;
                case 2:
                    array_push($transNumber, '২');
                    break;
                case 3:
                    array_push($transNumber, '৩');
                    break;
                case 4:
                    array_push($transNumber, '৪');
                    break;
                case 5:
                    array_push($transNumber, '৫');
                    break;
                case 6:
                    array_push($transNumber, '৬');
                    break;
                case 7:
                    array_push($transNumber, '৭');
                    break;
                case 8:
                    array_push($transNumber, '৮');
                    break;
                case 9:
                    array_push($transNumber, '৯');
                    break;
                default:
                    $number;
                    break;
            }
        }
        return implode('', $transNumber);
    }
}