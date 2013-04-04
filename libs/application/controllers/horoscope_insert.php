<?php
//Insert to the data.
class Horoscope_insert extends CI_Controller{

	function __construct(){
		parent::__construct();
		if (!$this->input->is_cli_request()) {
			show_404();
		}
	}

	function index(){
		$this->load->model('horoscope_api');

		$this->load->database();
		$this->load->helper('date');

		$date_add_10days = mdate("2013/03/05");
		$res = $this->horoscope_api->fetch($date_add_10days);
		$data = $res->getWith($date_add_10days);
		$sql = "";
		foreach ( $data as $row ){
	    $sql = "select id from horoscope_constellations where name_kanji=".$this->db->escape($row['sign']).";";
			$query_select = $this->db->query($sql);
			if($query_select->num_rows() > 0) {
				foreach ($query_select->result() as $row_select)
				{
					
					$sql = "insert into horoscope_results (date, content, money, job, love, total, item, color, rank, constellation_id)
					values (".$this->db->escape($date_add_10days).",
							".$this->db->escape($row['content']).",
							".$this->db->escape($row['money']).",
							".$this->db->escape($row['job']).",
							".$this->db->escape($row['love']).",
							".$this->db->escape($row['total']).",
							".$this->db->escape($row['item']).",
							".$this->db->escape($row['color']).",
							".$this->db->escape($row['rank']).",
							".$this->db->escape($row_select->id).")";
					$query_insert = $this->db->query($sql);
					if(!$query_insert) {
						print 'Failed to write data.';
					}
				}
			}
			else {
				print 'Failed to get the data.';
			}
			$query_select->free_result();
		}

	}

}
