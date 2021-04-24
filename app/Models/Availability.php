<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\ScheduleHelper;

class Availability extends Model
{
    use HasFactory;

     /**
     * Attributes that are mass assignable
     * 
     * @var array
     */
    protected $fillable = [
        'courier_id',
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

    public function courier() {
        return $this->belongsTo(User::class, 'courier_id', 'id');
    }

    public function get_availability() {
        $availability = [];

        $week_days = ScheduleHelper::WEEKDAYS;

        foreach($week_days as $key => $value) {
            $prop_b = $key . '_b';
            $prop_e = $key . '_e';

            $availability[$key][] = $this->$prop_b;
            $availability[$key][] = $this->$prop_e;

        }

        return $availability;
    }

    public function set_availability($availability_array) {
        $week_days = ScheduleHelper::WEEKDAYS;

        foreach($week_days as $key => $value) {
            $prop_b = $key . '_b';
            $prop_e = $key . '_e';
            
            if(array_key_exists($prop_b, $availability_array)) {
                $this->$prop_b = $availability_array[$prop_b];
            }
            if(array_key_exists($prop_e, $availability_array)) {
                $this->$prop_e = $availability_array[$prop_e];
            }
        }
    }

    public function set_default_availability() {
        $default_availability = ScheduleHelper::DEFAULT_SCHEDULE;
        foreach($default_availability as $key => $value) {
            $prop_b = $key . '_b';
            $prop_e = $key . '_e';

            $this->$prop_b = $value[0];
            $this->$prop_e = $value[1];
        }
    }


}
