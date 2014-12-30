<?php namespace Laravelrus\LocalizedCarbon\Models;


use Illuminate\Database\Eloquent\Model;
use Laravelrus\LocalizedCarbon\LocalizedCarbon;

class Eloquent extends Model {
    /**
     * Return a timestamp as DateTime object.
     *
     * @param  mixed  $value
     * @return \Laravelrus\LocalizedCarbon\LocalizedCarbon
     */
    protected function asDateTime($value)
    {
        // If this value is an integer, we will assume it is a UNIX timestamp's value
        // and format a Carbon object from this timestamp. This allows flexibility
        // when defining your date fields as they might be UNIX timestamps here.
        if (is_numeric($value))
        {
            return LocalizedCarbon::createFromTimestamp($value);
        }

        // If the value is in simply year, month, day format, we will instantiate the
        // Carbon instances from that format. Again, this provides for simple date
        // fields on the database, while still supporting Carbonized conversion.
        elseif (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value))
        {
            return LocalizedCarbon::createFromFormat('Y-m-d', $value)->startOfDay();
        }

        // Finally, we will just assume this date is in the format used by default on
        // the database connection and use that format to create the Carbon object
        // that is returned back out to the developers after we convert it here.
        elseif ( ! $value instanceof \DateTime)
        {
            $format = $this->getDateFormat();

            return LocalizedCarbon::createFromFormat($format, $value);
        }

        return LocalizedCarbon::instance($value);
    }
} 
