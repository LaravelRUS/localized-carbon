<?php

namespace Tests\Unit;

use LocalizedCarbon;
use Tests\TestCase;
use Carbon\Carbon;

class RoLocalizedCarbonTest extends TestCase
{

    public function test_ro_diffs()
    {

        $oneSecondAgo = Carbon::now()->subSecond(1);
        $this->assertEquals('acum o secundă', LocalizedCarbon::instance($oneSecondAgo)->diffForHumans());

        $inOneSecond = Carbon::now()->addSecond(1);
        $this->assertEquals('peste o secundă', LocalizedCarbon::instance($inOneSecond)->diffForHumans());

        $fiveSeconsAgo = Carbon::now()->subSecond(5);
        $this->assertEquals('acum 5 secunde', LocalizedCarbon::instance($fiveSeconsAgo)->diffForHumans());

        $inFiveSeconds = Carbon::now()->addSecond(5);
        $this->assertEquals('peste 5 secunde', LocalizedCarbon::instance($inFiveSeconds)->diffForHumans());

        $moreSeconsAgo = Carbon::now()->subSecond(59);
        $this->assertEquals('acum 59 secunde', LocalizedCarbon::instance($moreSeconsAgo)->diffForHumans());

        $inMoreSeconds = Carbon::now()->addSecond(59);
        $this->assertEquals('peste 59 secunde', LocalizedCarbon::instance($inMoreSeconds)->diffForHumans());

        $oneMinuteAgo = Carbon::now()->subMinute(1);
        $this->assertEquals('acum un minut', LocalizedCarbon::instance($oneMinuteAgo)->diffForHumans());

        $inOneMinute = Carbon::now()->addMinute(1);
        $this->assertEquals('peste un minut', LocalizedCarbon::instance($inOneMinute)->diffForHumans());

        $fiveMinutesAgo = Carbon::now()->subMinute(5);
        $this->assertEquals('acum 5 minute', LocalizedCarbon::instance($fiveMinutesAgo)->diffForHumans());

        $twentyfourMinutesAgo = Carbon::now()->subMinute(24);
        $this->assertEquals('acum 24 minute', LocalizedCarbon::instance($twentyfourMinutesAgo)->diffForHumans());

        $inTwentyfourMinutes = Carbon::now()->addMinute(24);
        $this->assertEquals('peste 24 minute', LocalizedCarbon::instance($inTwentyfourMinutes)->diffForHumans());

        $oneYearAgo = Carbon::now()->subMonth(13);
        $this->assertEquals('acum un an', LocalizedCarbon::instance($oneYearAgo)->diffForHumans());
        $twoYearsAgo = Carbon::now()->subMonth(25);
        $this->assertEquals('acum 2 ani', LocalizedCarbon::instance($twoYearsAgo)->diffForHumans());

        $fourWeeksAgo = Carbon::now()->subDays(32);
        $this->assertEquals('acum 4 săptămâni', LocalizedCarbon::instance($fourWeeksAgo)->diffForHumans());

        $oneMonthAgo = Carbon::now()->subWeek(7);
        $this->assertEquals('acum o lună', LocalizedCarbon::instance($oneMonthAgo)->diffForHumans());
    }


}
