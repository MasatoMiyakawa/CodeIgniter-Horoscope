<?php
class Horoscope_exec extends CI_Controller{

	function __construct(){
		parent::__construct();
		if (!$this->input->is_cli_request()) {
			show_404();
		}
	}

	function index(){
		$this->load->model('horoscope_api');
		$this->load->model('mail');
		$to_address = array('admin@sample.com');
		$from_address = 'admin@sample.com';
		$from_name = 'NAME';

		$this->load->database();
		$this->load->helper('date');

		$date_add_10days = mdate("%Y/%m/%d", strtotime('10 day'));
		$res = $this->horoscope_api->fetch($date_add_10days);

		if(!$res) {
			$subject = "Failed to get the API data!!";
			$message = "";
			$this->mail->send_mail($to_address, $from_address, $from_name, $subject, $message);
			return false;
		}

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
						$subject = "Failed to write data API.";
						$message = "SQL：".$sql;
						$this->mail->send_mail($to_address, $from_address, $from_name, $subject, $message);
						return false;
					}
				}
			}
			else {
				$subject = "There was no data to DB.";
				$message = "SQL：".$sql;
				$this->mail->send_mail($to_address, $from_address, $from_name, $subject, $message);
				return false;
			}
			$query_select->free_result();
		}
		
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->model('horoscope_model');
		$this->output->enable_profiler(TRUE);
		
		$data['ranking'] = $this->horoscope_model->get_ranking(3);
	
		$fp = fopen('../include/horoscope_side.html', 'w');
		$html = $this->load->view('pc/horoscope_view_ranking_top3', $data, TRUE);
		fwrite($fp, $html);
		fclose($fp);
		
		$subject = "It has been successfully processed.";
		$message = "";
		$this->mail->send_mail($to_address, $from_address, $from_name, $subject, $message);
	}

}
