<?php

class Horoscope_model extends CI_Model{

    function __construct() {
    	parent::__construct();
		$this->load->database();
    }

    function get_daily($sign=null, $whereDate) {

    	$result = array();

    	$sql = "select r.*, c.name_hiragana, c.name_kanji, c.code, c.start_month, c.start_day, c.end_month, c.end_day ,
    	if(r.date>=adddate(curdate(),INTERVAL 6 day),1,0) isLastday , if(r.date<=subdate(curdate(),INTERVAL 6 day),1,0) isFirstday,
    	adddate(r.date,INTERVAL 1 day) nextday, subdate(r.date,INTERVAL 1 day) prevday
    	from horoscope_results r join horoscope_constellations c on r.constellation_id = c.id where r.date=".$this->db->escape($whereDate)." and c.code=".$this->db->escape($sign)." limit 1;";
    	$query_select = $this->db->query($sql);

    	if($query_select->num_rows() > 0) {
    		$result = $query_select->result();
    	}
    	$query_select->free_result();
    	return $result;
    }

    function get_ranking($rank=12, $date="today") {

		if($date == "today") {
			$whereDate = mdate("%Y/%m/%d");
		}
		else {
			$whereDate = mdate($date);
		}

		$result = array();
		$this->db->join('horoscope_constellations c', 'r.constellation_id = c.id');
		$this->db->order_by('rank asc');
		$this->db->limit($rank);
		$query_select = $this->db->get_where('horoscope_results r', array('r.date' => $whereDate));
		if($query_select->num_rows() > 0) {
			$result = $query_select->result();
		}
		$query_select->free_result();

		return $result;
    }

    function get_list($currentHoroscope) {

		$result = array();
		$this->db->order_by('id asc');
		$this->db->not_like('code', $currentHoroscope);
		$query_select = $this->db->get('horoscope_constellations', 11);
		if($query_select->num_rows() > 0) {
			$result = $query_select->result();
		}
		$query_select->free_result();

		return $result;
    }

    function get_month_en($month) {

			switch($month){
				case 1:
						$result = 'JAN';
						break;
				case 2:
						$result = 'FEB';
						break;
				case 3:
						$result = 'MAR';
						break;
				case 4:
						$result = 'APR';
						break;
				case 5:
						$result = 'MAY';
						break;
				case 6:
						$result = 'JUN';
						break;
				case 7:
						$result = 'JUL';
						break;
				case 8:
						$result = 'AUG';
						break;
				case 9:
						$result = 'SEP';
						break;
				case 10:
						$result = 'OCT';
						break;
				case 11:
						$result = 'NOV';
						break;
				case 12:
						$result = 'DEC';
						break;
			}
	
			return $result;
    }

		function get_date_nextback($current_date, $addDays) {
				$year = substr($current_date, 0, 4);
				$month = substr($current_date, 4, 2);
				$day = substr($current_date, 6, 2);
				$baseSec = mktime(0, 0, 0, $month, $day, $year);//Šî€“ú‚ğ•b‚Åæ“¾
				$addSec = $addDays * 86400;//“ú”~‚P“ú‚Ì•b”
				$targetSec = $baseSec + $addSec;
				return date("Ymd", $targetSec);
		}
}
