<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	public function index()
	{
		cek_login_auth();
		$this->form_validation->set_rules('username','username','required|trim',['required' => 'Username harap di isi']);
		$this->form_validation->set_rules('password','password','required|trim',['required' => 'Password harap di isi']);
		if($this->form_validation->run() == false){
			$this->load->view('login');
		} else {
			$this->pv_login();
		}
	}

	private function pv_login(){
		$password = md5($this->input->post('password'));
		$admin = $this->db->get_where('tbl_admin',['username' => $this->input->post('username')])->row();

		if($admin){
			if($admin->password == $password){
				$data = [
					'username_admin' => $admin->username
				];
				$this->session->set_userdata($data);
				redirect('dashboard');
			} else {
				$this->session->set_flashdata('err_msg','Password salah');
			redirect(base_url());
			}
		} else {
			$this->session->set_flashdata('err_msg','Username tidak terdaftar');
			redirect(base_url());
		}
		
	}

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}


}
