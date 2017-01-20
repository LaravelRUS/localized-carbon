<?php namespace Laravelrus\LocalizedCarbon\DiffFormatters;

class TrDiffFormatter implements DiffFormatterInterface
{
	public function format($isNow, $isFuture, $delta, $unit)
	{
		$unitStr = \Lang::choice("localized-carbon::units." . $unit, $delta, array(), 'tr');

		$txt = $delta . ' ' . $unitStr;

		if ($isNow) {
			$txt .= " " . (($isFuture) ? 'sonra ' : 'önce ');
			
			return $txt;
		}

		$txt .= ($isFuture) ? ' sonrası' : ' öncesi';

		return $txt;
	}
}
