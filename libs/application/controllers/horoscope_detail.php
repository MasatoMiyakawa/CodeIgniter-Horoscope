<?php
class Horoscope_detail extends CI_Controller{

	function __construct(){
		parent::__construct();
	}

	function index($date='today'){

		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('array');
		$this->load->library('user_agent');
		$this->load->model('horoscope_model');

		$sign = preg_replace('/(\d+|\/)/','',uri_string());

		if($date == 'today') {
			$whereDate = mdate("%Y%m%d");
		}
		else {
			$whereDate = mdate($date);
		}
		
		$date_next7 = $this->horoscope_model->get_date_nextback(mdate("%Y%m%d"), 7);
		$date_back7 = $this->horoscope_model->get_date_nextback(mdate("%Y%m%d"), -7);

		if($whereDate >= $date_next7 || $whereDate <= $date_back7) {
			redirect('URL', 'location');
		}

		$data['daily'] = $this->horoscope_model->get_daily($sign, $whereDate);
		$data['list'] = $this->horoscope_model->get_list($sign);

		$data['current_date'] = $whereDate;

		$ua = $this->agent->agent_string();
		if(preg_match('/iPhone|iPod|Android/i', $ua )){
			//SmartPhone
			$this->load->view('sp/horoscope_view_detail', $data);
		}
		else
		{
			//PC
			$this->load->view('pc/horoscope_view_detail', $data);
		}

	}

}
