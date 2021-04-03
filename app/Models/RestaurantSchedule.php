<?php

namespace App\Models;

use App\Helpers\ScheduleHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantSchedule extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'restaurant_id',
        'mon_b',
        'mon_e',
        'tue_b',
        'tue_e',
        'wed_b',
        'wed_e',
        'thu_b',
        'thu_e',
        'fri_b',
        'fri_e',
        'sat_b',
        'sat_e',
        'sun_b',
        'sun_e',
    ];

    /**
     * Get the restaurant the schedule belongs to
     * 
     * @return 
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function get_schedule() {
        $schedule = [];

        $week_days = ScheduleHelper::WEEKDAYS;

        foreach($week_days as $key => $value) {
            $prop_b = $key . '_b';
            $prop_e = $key . '_e';

            $schedule[$key][] = $this->$prop_b;
            $schedule[$key][] = $this->$prop_e;

        }

        return $schedule;
    }

    public function set_schedule($schedule_array) {
        $week_days = ScheduleHelper::WEEKDAYS;

        foreach($week_days as $key => $value) {
            $prop_b = $key . '_b';
            $prop_e = $key . '_e';
            
            if(array_key_exists($prop_b, $schedule_array)) {
                $this->$prop_b = $schedule_array[$prop_b];
            }
            if(array_key_exists($prop_e, $schedule_array)) {
                $this->$prop_e = $schedule_array[$prop_e];
            }
        }
    }

    public function set_default_schedule() {
        $default_schedule = ScheduleHelper::DEFAULT_SCHEDULE;
        foreach($default_schedule as $key => $value) {
            $prop_b = $key . '_b';
            $prop_e = $key . '_e';

            $this->$prop_b = $value[0];
            $this->$prop_e = $value[1];
        }
    }
}
