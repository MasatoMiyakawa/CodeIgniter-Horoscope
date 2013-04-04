<?php

class Mail extends CI_Model{

	function __construct(){
		parent::__construct();
	}
  
  function send_mail($to_address, $from_address, $from_name, $subject, $message)
  {
		$this->load->library('email');

		$from_name = mb_encode_mimeheader($from_name, 'ISO-2022-JP');
		$subject = mb_encode_mimeheader($subject, 'ISO-2022-JP');
	  $this->email->to($to_address);
	  $this->email->from($from_address, $from_name);
	  $this->email->subject($subject);
	  $this->email->message($message);
	  $this->email->send();
  }
}