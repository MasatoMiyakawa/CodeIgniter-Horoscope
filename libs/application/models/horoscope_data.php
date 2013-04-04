<?php

class Horoscope_data extends CI_Model{

	public function __construct($data){
		parent::__construct();
        $this->data = $data;
	}

    public function getData(){
        return $this->data;
    }

    public function getWith($date = null, $sign = null){
        $data = $this->data;
        if($date){
            $data = $data[$date];
        }

        return $data;
    }

    public function getToday($sign = null)
    {
        return $this->getWith(date('Y/m/d'), $sign);
    }

    public function getTomorrow($sign = null)
    {
        $time = time();
        $time = $time + 60 * 60 * 24;
        return $this->getWith(date('Y/m/d', $time), $sign);
    }

    private function is_hash (&$array) {
        reset($array);
        list($key,$val) = each($array);
        return is_numeric($key) ? false : true;
    }

    private function locate ($date)
    {
        list($year, $month, $day) = split('/', $date);
        $birth_time = mktime(0, 0, 0, $month, $day, '92');

        if ( $month == 12 && $day >= 22 && $day <= 31 ){
            return 'capricorn';
        }

        foreach ( $this->horoscope as $key => $value ){
            list( $start_month, $start_day, $start_year ) = split('/', $value['start']);
            list( $end_month, $end_day, $end_year ) = split('/', $value['end']);

            $start_time =  mktime(0, 0, 0, $start_month, $start_day, $start_year);
            $end_time   =  mktime(23, 59, 59, $end_month, $end_day, $end_year);

            if( $start_time <= $birth_time && $birth_time <= $end_time ){
                return $key;
            }
        }
    }

}
