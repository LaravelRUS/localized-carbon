<?php namespace Laravelrus\LocalizedCarbon;

use Carbon\Carbon;
use Laravelrus\LocalizedCarbon\DiffFormatters\DiffFormatterInterface;

class LocalizedCarbon extends Carbon {

    const DEFAULT_LANGUAGE = 'en';

    public static function determineLanguage() {
        return \App::getLocale();
    }

    public function diffForHumans(Carbon $other = null, $formatter = null) {
        if ($formatter === null) {
            $language = self::determineLanguage();
            $formatter = DiffFactoryFacade::get($language);
        } elseif (is_string($formatter)) {
            $formatter = DiffFactoryFacade::get($formatter);
        }

        // Original logic from Carbon
        $isNow = $other === null;

        if ($isNow) {
            $other = static::now($this->tz);
        }

        $isFuture = $this->gt($other);

        $delta = $other->diffInSeconds($this);

        // 4.35 weeks per year. 365 days in a year, 12 months, 7 days in a week:
        // 365/12/7 = 4.345238095238095 4.35 is good enough for big time calculations!
        $divs = array(
            'second' => self::SECONDS_PER_MINUTE,
            'minute' => self::MINUTES_PER_HOUR,
            'hour'   => self::HOURS_PER_DAY,
            'day'    => self::DAYS_PER_WEEK,
            'week'   => 4.35,
            'month'  => self::MONTHS_PER_YEAR
        );

        $unit = 'year';

        foreach ($divs as $divUnit => $divValue) {
            if ($delta < $divValue) {
                $unit = $divUnit;
                break;
            }

            $delta = floor($delta / $divValue);
        }

        if ($delta == 0) {
            $delta = 1;
        }

        // Format and return
        $result = null;
        if ($formatter instanceof DiffFormatterInterface) {
            $result = $formatter->format($isNow, $isFuture, $delta, $unit);
        } elseif ($formatter instanceof \Closure) {
            $result = $formatter($isNow, $isFuture, $delta, $unit);
        }

        return $result;
    }

    public function formatLocalized($format = self::COOKIE) {
        if (strpos($format, '%f') !== false) {
            $langKey = strtolower(parent::format("F"));
            $replace = \Lang::get("localized-carbon::months." . $langKey);
            $result = str_replace('%f', $replace, $format);
        } else {
            $result = $format;
        }

        $result = parent::formatLocalized($result);

        return $result;
    }
}
