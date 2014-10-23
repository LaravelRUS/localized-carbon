<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;

class BgDiffFormatter implements DiffFormatterInterface
{
    public function format($isNow, $isFuture, $delta, $unit)
    {
        $unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'bg');

        $txt = $delta . ' ' . $unitStr;

        if ($isNow) {
            $txt = (($isFuture) ? 'след ' : 'преди ') . $txt;

            return $txt;
        }

        $txt .= ($isFuture) ? ' след това' : ' преди това';

        return $txt;
    }
}
