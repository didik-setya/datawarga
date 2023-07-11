<?php
defined('BASEPATH')or exit('No direct script access allowed');
class Admin extends CI_Controller{

    public function __construct()
    {
        parent::__construct();
        cek_login();
    }

    public function index(){
        $data['admin'] = $this->db->get_where('tbl_admin',['username' => $this->session->userdata('username_admin')])->row();
        $data['title'] = 'Setting Akun';

        $this->form_validation->set_rules('nama','nama','required|trim',['required' => 'Nama harap di isi']);

        if($this->form_validation->run() == false){
        $this->load->view('templates/header', $data);
        $this->load->view('admin/index');
        $this->load->view('templates/footer');
        } else {
            $data = [
                'nama_admin' => $this->input->post('nama',true),
            ];
            if($this->db->where('username',$this->session->userdata('username_admin'))->update('tbl_admin', $data)){
                $this->session->set_flashdata('scs_msg','Profil berhasil di ubah');
                        redirect('admin');
            } else {
                $this->session->set_flashdata('err_msg','Profil gagal di ubah');
                        redirect('admin');
            }

        }
    }

    public function edit_pass(){
        $oldpass = $this->input->post('pl');
        $newpass = $this->input->post('pb');
        $confirmpass = $this->input->post('kp');
        $admin_pass = $this->db->get_where('tbl_admin',['username' => $this->session->userdata('username_admin')])->row()->password;

        if($newpass == $confirmpass){
            if($oldpass != $newpass){
                if(md5($oldpass) == $admin_pass){
                    
                    $data = [
                        'password' => md5($newpass)
                    ];
                    if($this->db->where('username' , $this->session->userdata('username_admin'))->update('tbl_admin', $data)){
                        $this->session->set_flashdata('scs_msg','Password berhasil di ubah');
                        redirect('admin');
                    } else {
                        $this->session->set_flashdata('err_msg','Password gagal di ubah');
                        redirect('admin');
                    }

                } else {
                    //old pass salah
                    $this->session->set_flashdata('err_msg','Password lama salah');
            redirect('admin');
                }
            } else {
                //pass tidak boleh sama
                $this->session->set_flashdata('err_msg','Password baru tidak boleh sama denga password lama');
            redirect('admin');
            }
        } else {
            $this->session->set_flashdata('err_msg','Kesalahan penulisan harap coba kembali');
            redirect('admin');
        }

    }

}