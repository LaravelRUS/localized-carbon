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

        // 4 weeks per month, 365 days per year... good enough!!
        $divs = array(
            'second' => self::SECONDS_PER_MINUTE,
            'minute' => self::MINUTES_PER_HOUR,
            'hour'   => self::HOURS_PER_DAY,
            'day'    => self::DAYS_PER_WEEK,
            'week'   => 4,
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
        return $formatter->format($isNow, $isFuture, $delta, $unit);
    }
}
