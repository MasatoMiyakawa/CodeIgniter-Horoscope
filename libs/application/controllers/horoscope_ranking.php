<?php
class Horoscope_ranking extends CI_Controller{

	function __construct(){
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->helper('array');
		$this->load->library('user_agent');
		$this->load->model('horoscope_model');
	}

	function index(){

		$data['ranking'] = $this->horoscope_model->get_ranking();

		$ua = $this->agent->agent_string();
		if(preg_match('/iPhone|iPod|Android/i', $ua )){
			//SmartPhone
			$this->load->view('sp/horoscope_view_ranking', $data);
		}
		else
		{
			//PC
			$this->load->view('pc/horoscope_view_ranking', $data);
		}

	}

	function getTop3(){
		$this->load->helper('form');
		$this->output->enable_profiler(TRUE);
		
		$data['ranking'] = $this->horoscope_model->get_ranking(3);

		$fp = fopen('horoscope_top3.html', 'w');
		$html = $this->load->view('pc/horoscope_view_ranking_top3', $data, TRUE);
		fwrite($fp, $html);
		fclose($fp);
		
	}

}
