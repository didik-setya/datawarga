<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        cek_login();
        $this->load->model('M_dashboard', 'model');
    }

    public function index()
    {
        $data['admin'] = $this->db->get_where('tbl_admin', ['username' => $this->session->userdata('username_admin')])->row();
        $data['title'] = 'Dashboard';

        $this->load->library('pagination');
        $start = $this->uri->segment(3);
        $config['per_page'] = 20;
        

        $data['kk'] = $this->model->get_data_kk_all($config['per_page'], $start, null)->result();
        $data['rw'] = $this->model->getData('tbl_rw')->result();
        $data['status_warga'] = $this->model->getData('tbl_status_warga')->result();
        $data['bantuan'] = $this->model->getData('tbl_jenis_bantuan')->result();

        $data['jml_warga'] = $this->model->getJmlAll()->num_rows();
        $data['jml_kk'] = $this->model->getJmlAll('kk')->num_rows();

        if ($this->input->get('cari')) {
            $keyword = $this->input->get('cari');
            $cari = $this->model->cari($keyword);
            $data['kk'] = $cari;
        }

        $filter_rw = (isset($_GET['filter_rw']) ? $_GET['filter_rw']: null );
        $filter_rt = (isset($_GET['filter_rt']) ? $_GET['filter_rt']: null );
        $filter_bantuan = (isset($_GET['filter_bantuan']) ? $_GET['filter_bantuan']: null );
        $filter_status = (isset($_GET['filter_status']) ? $_GET['filter_status']: null );
        $filter_date = (isset($_GET['filter_date']) ? $_GET['filter_date']: null );
        $filter_nama = (isset($_GET['filter_nama']) ? $_GET['filter_nama']: null );
        $filter_nik = (isset($_GET['filter_nik']) ? $_GET['filter_nik']: null );
        $filter_kk = (isset($_GET['filter_kk']) ? $_GET['filter_kk']: null );

        $data['kk'] = $this->model->get_data_kk_all($config['per_page'], $start, $filter_rw, $filter_rt, $filter_bantuan, $filter_status, $filter_nik, $filter_nama,$filter_kk, $filter_date)->result();

        $data['jml_warga'] = $this->model->getJmlAll(null, $filter_rw, $filter_rt, $filter_bantuan, $filter_status, $filter_nik, $filter_nama,$filter_kk, $filter_date)->num_rows();
        $data['jml_kk'] = $this->model->getJmlAll('kk', $filter_rw, $filter_rt, $filter_bantuan, $filter_status, $filter_nik, $filter_nama,$filter_kk, $filter_date)->num_rows();

        //PENAMBAHAN FITUR
        $data['anak_laki'] = $this->model->getAllAnakLaki('kk', $filter_rw, $filter_rt, $filter_bantuan, $filter_status, $filter_nik, $filter_nama, $filter_kk, $filter_date);
        $data['anak_perempuan'] = $this->model->getAllAnakPerempuan('kk', $filter_rw, $filter_rt, $filter_bantuan, $filter_status, $filter_nik, $filter_nama, $filter_kk, $filter_date);
        $data['balita_laki'] = $this->model->getAllBalitaLaki('kk', $filter_rw, $filter_rt, $filter_bantuan, $filter_status, $filter_nik, $filter_nama, $filter_kk, $filter_date);
        $data['balita_perempuan'] = $this->model->getAllBalitaPerempuan('kk', $filter_rw, $filter_rt, $filter_bantuan, $filter_status, $filter_nik, $filter_nama, $filter_kk, $filter_date);
        $data['dewasa_laki'] = $this->model->getAllDewasaLaki('kk', $filter_rw, $filter_rt, $filter_bantuan, $filter_status, $filter_nik, $filter_nama, $filter_kk, $filter_date);
        $data['dewasa_perempuan'] = $this->model->getAllDewasaPerempuan('kk', $filter_rw, $filter_rt, $filter_bantuan, $filter_status, $filter_nik, $filter_nama, $filter_kk, $filter_date);
        $data['lansia_laki'] = $this->model->getAllLansiaLaki('kk', $filter_rw, $filter_rt, $filter_bantuan, $filter_status, $filter_nik, $filter_nama, $filter_kk, $filter_date);
        $data['lansia_perempuan'] = $this->model->getAllLansiaPerempuan('kk', $filter_rw, $filter_rt, $filter_bantuan, $filter_status, $filter_nik, $filter_nama, $filter_kk, $filter_date);
       
        $config['base_url'] = base_url('dashboard/index/');
        $config['total_rows'] = $this->model->getJmlAll('kk', $filter_rw, $filter_rt, $filter_bantuan, $filter_status, $filter_nik, $filter_nama,$filter_kk, $filter_date)->num_rows();
        $config['num_links'] = 5;
        

        if ($this->input->get('cari')) {
            $config['full_tag_open'] = '<nav class="d-none"><ul class="pagination justify-content-center">';
        }
        $this->pagination->initialize($config);

        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/index');
        $this->load->view('templates/footer');
    }



    public function add()
    {
        $data['admin'] = $this->db->get_where('tbl_admin', ['username' => $this->session->userdata('username_admin')])->row();
        $data['title'] = 'Tambah Data';
        $data['rw'] = $this->model->getData('tbl_rw')->result();
        $data['status_rumah'] = $this->model->getData('tbl_status_rumah')->result();
        $data['jenis_bantuan'] = $this->model->getData('tbl_jenis_bantuan')->result();
        $data['status_warga'] = $this->model->getData('tbl_status_warga')->result();


        $this->form_validation->set_rules('nokk', 'nokk', 'required|trim|is_unique[tbl_kk.no_kk]', ['is_unique' => 'No. KK sudah terdaftar']);
        $this->form_validation->set_rules('no_rumah', 'No Rumah', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat KTP', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('dashboard/add');
            $this->load->view('templates/footer');
        } else {
            $this->model->add_data();
        }
    }


    public function delete($no)
    {
        $this->db->delete('tbl_kk', ['id_kk' => $no]);
        $this->db->delete('tbl_anggota_kk', ['id_kk' => $no]);
        $this->session->set_flashdata('scs_msg', 'Data berhasil di hapus');
        redirect('dashboard');
    }


    public function edit($no = null)
    {
        cek_edit_kk();
        $data['admin'] = $this->db->get_where('tbl_admin', ['username' => $this->session->userdata('username_admin')])->row();
        $data['kk'] = $this->model->get_data_kk_no($no);
        $data['title'] = 'Edit Data';
        $data['rw'] = $this->model->getData('tbl_rw')->result();
        $data['status_rumah'] = $this->model->getData('tbl_status_rumah')->result();
        $data['jenis_bantuan'] = $this->model->getData('tbl_jenis_bantuan')->result();

        $this->form_validation->set_rules('nokk', 'nokk', 'required|trim');
        $this->form_validation->set_rules('alamat', 'alamat', 'required|trim');
        $this->form_validation->set_rules('no_rumah', 'No Rumah', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('dashboard/edit');
            $this->load->view('templates/footer');
        } else {
            $this->model->edit_data_kk($no);
        }
    }

    public function del_people($id_kk, $id)
    {
        if ($this->db->delete('tbl_anggota_kk', ['id_anggota' => $id])) {
            $this->session->set_flashdata('scs_msg', 'Data berhasil di hapus');
            redirect('dashboard/edit_anggota/' . $id_kk);
        } else {
            $this->session->set_flashdata('err_msg', 'Data berhasil di hapus');
            redirect('dashboard/edit_anggota/' . $id_kk);
        }
    }


    public function edit_anggota($id_kk = null)
    {
        cek_edit_kk();
        $data['admin'] = $this->db->get_where('tbl_admin', ['username' => $this->session->userdata('username_admin')])->row();
        $data['title'] = 'Edit Anggota KK';
        $data['anggota'] = $this->model->get_anggota_kk_all($id_kk);
        $data['id_kk'] = $id_kk;
        $data['status_warga'] = $this->model->getData('tbl_status_warga')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/edit_anggota');
        $this->load->view('templates/footer');
    }

    public function edit_anggota_kk($id_kk = null)
    {
        cek_edit_kk();
        return $this->model->edit_anggota_kk($id_kk);
    }

    public function add_anggota($id_kk = null)
    {
        cek_edit_kk();
        $data['admin'] = $this->db->get_where('tbl_admin', ['username' => $this->session->userdata('username_admin')])->row();
        $data['title'] = 'Tambah Anggota KK';
        $data['id_kk'] = $id_kk;
        $data['status_warga'] = $this->model->getData('tbl_status_warga')->result();
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/add_anggota');
        $this->load->view('templates/footer');
    }

    public function add_anggota_kk($id_kk = null)
    {
        cek_edit_kk();
        return $this->model->add_anggota_kk($id_kk);
    }

    public function export_excel()
    {
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga.xls");

        $data['kk'] = $this->model->get_data_kk_laporan(null, null)->result();

        $balita = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita'";
        $data['jml_balita'] = $this->db->query($balita)->row()->umur;

        $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'L'";
        $data['jml_balita_laki'] = $this->db->query($q1)->row()->umur;

        $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'P'";
        $data['jml_balita_perempuan'] = $this->db->query($q12)->row()->umur;


        
        $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak'";
        $data['jml_anak'] = $this->db->query($a)->row()->umur;

        $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'L'";
        $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;

        $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'P'";
        $data['jml_anak_perempuan'] = $this->db->query($q12)->row()->umur;



        $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa'";
        $data['jml_dewasa'] = $this->db->query($b)->row()->umur;

        $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'L'";
        $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;

        $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'P'";
        $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;


        $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia'";
        $data['jml_lansia'] = $this->db->query($c)->row()->umur;

        $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'L'";
        $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;

        $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'P'";
        $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;


        if(isset($_GET['rw'])){
            $rw = $_GET['rw'];
            $data['kk'] = $this->model->get_data_kk_laporan($rw, null)->result();


            $balita = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_kk.rw = $rw";
            $data['jml_balita'] = $this->db->query($balita)->row()->umur;
    
            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'L' AND tbl_kk.rw = $rw";
            $data['jml_balita_laki'] = $this->db->query($q1)->row()->umur;
    
            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'P' AND tbl_kk.rw = $rw";
            $data['jml_balita_perempuan'] = $this->db->query($q12)->row()->umur;

            

            $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rw = $rw";
            $data['jml_anak'] = $this->db->query($a)->row()->umur;
    
            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'L' AND tbl_kk.rw = $rw";
            $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;
    
            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'P' AND tbl_kk.rw = $rw";
            $data['jml_anak_perempuan'] = $this->db->query($q12)->row()->umur;
    
    
    
            $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rw = $rw";
            $data['jml_dewasa'] = $this->db->query($b)->row()->umur;
    
            $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'L' AND tbl_kk.rw = $rw";
            $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;
    
            $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'P' AND tbl_kk.rw = $rw";
            $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;
    
    
            $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rw = $rw";
            $data['jml_lansia'] = $this->db->query($c)->row()->umur;
    
            $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'L' AND tbl_kk.rw = $rw";
            $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;
    
            $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'P' AND tbl_kk.rw = $rw";
            $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;

        }

        if(isset($_GET['rt'])){
            $rt = $_GET['rt'];
            $data['kk'] = $this->model->get_data_kk_laporan(null, $rt)->result();

            $balita = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_kk.rt = $rt";
            $data['jml_balita'] = $this->db->query($balita)->row()->umur;

            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'L' AND tbl_kk.rt = $rt";
            $data['jml_balita_laki'] = $this->db->query($q1)->row()->umur;

            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'P' AND tbl_kk.rt = $rt";
            $data['jml_balita_perempuan'] = $this->db->query($q12)->row()->umur;


            $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rt = $rt";
            $data['jml_anak'] = $this->db->query($a)->row()->umur;

            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'L' AND tbl_kk.rt = $rt";
            $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;

            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'P' AND tbl_kk.rt = $rt";
            $data['jml_anak_perempuan'] = $this->db->query($q12)->row()->umur;


            $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rt = $rt";
            $data['jml_dewasa'] = $this->db->query($b)->row()->umur;

            $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'L' AND tbl_kk.rt = $rt";
            $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;

            $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'P' AND tbl_kk.rt = $rt";
            $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;


            $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rt = $rt";
            $data['jml_lansia'] = $this->db->query($c)->row()->umur;

            $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'L' AND tbl_kk.rt = $rt";
            $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;

            $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'P' AND tbl_kk.rt = $rt";
            $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;
        }

        if(isset($_GET['bantuan'])){
            $bantuan = $_GET['bantuan'];
            $data['kk'] = $this->model->get_data_kk_laporan(null, null, $bantuan, null)->result();

            $balita = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND (tbl_kk.ket_bantuan = '$bantuan' OR tbl_kk.jenis_bantuan = '$bantuan')";
            $data['jml_balita'] = $this->db->query($balita)->row()->umur;

            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'L' AND (tbl_kk.ket_bantuan = '$bantuan' OR tbl_kk.jenis_bantuan = '$bantuan')";
            $data['jml_balita_laki'] = $this->db->query($q1)->row()->umur;

            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'P' AND (tbl_kk.ket_bantuan = '$bantuan' OR tbl_kk.jenis_bantuan = '$bantuan')";
            $data['jml_balita_perempuan'] = $this->db->query($q12)->row()->umur;


            $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND (tbl_kk.ket_bantuan = '$bantuan' OR tbl_kk.jenis_bantuan = '$bantuan')";
            $data['jml_anak'] = $this->db->query($a)->row()->umur;

            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'L' AND (tbl_kk.ket_bantuan = '$bantuan' OR tbl_kk.jenis_bantuan = '$bantuan')";
            $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;

            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'P' AND (tbl_kk.ket_bantuan = '$bantuan' OR tbl_kk.jenis_bantuan = '$bantuan')";
            $data['jml_anak_perempuan'] = $this->db->query($q12)->row()->umur;



            $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND (tbl_kk.ket_bantuan = '$bantuan' OR tbl_kk.jenis_bantuan = '$bantuan')";
            $data['jml_dewasa'] = $this->db->query($b)->row()->umur;

            $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'L' AND (tbl_kk.ket_bantuan = '$bantuan' OR tbl_kk.jenis_bantuan = '$bantuan')";
            $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;

            $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'P' AND (tbl_kk.ket_bantuan = '$bantuan' OR tbl_kk.jenis_bantuan = '$bantuan')";
            $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;


            $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND (tbl_kk.ket_bantuan = '$bantuan' OR tbl_kk.jenis_bantuan = '$bantuan')";
            $data['jml_lansia'] = $this->db->query($c)->row()->umur;

            $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'L' AND (tbl_kk.ket_bantuan = '$bantuan' OR tbl_kk.jenis_bantuan = '$bantuan')";
            $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;

            $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'P' AND (tbl_kk.ket_bantuan = '$bantuan' OR tbl_kk.jenis_bantuan = '$bantuan')";
            $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;

        }

        if(isset($_GET['status'])){
            $status = $_GET['status'];
            $data['kk'] = $this->model->get_data_kk_laporan(null, null, null, $status)->result();
            $data['status'] = $status;

            $balita = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.status_warga = $status";
            $data['jml_balita'] = $this->db->query($balita)->row()->umur;

            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'L' AND tbl_anggota_kk.status_warga = $status";
            $data['jml_balita_laki'] = $this->db->query($q1)->row()->umur;

            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'P' AND tbl_anggota_kk.status_warga = $status";
            $data['jml_balita_perempuan'] = $this->db->query($q12)->row()->umur;


            $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.status_warga = $status";
            $data['jml_anak'] = $this->db->query($a)->row()->umur;

            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'L' AND tbl_anggota_kk.status_warga = $status";
            $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;

            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'P' AND tbl_anggota_kk.status_warga = $status";
            $data['jml_anak_perempuan'] = $this->db->query($q12)->row()->umur;


            $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.status_warga = $status";
            $data['jml_dewasa'] = $this->db->query($b)->row()->umur;

            $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'L' AND tbl_anggota_kk.status_warga = $status";
            $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;

            $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'P' AND tbl_anggota_kk.status_warga = $status";
            $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;


            $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.status_warga = $status";
            $data['jml_lansia'] = $this->db->query($c)->row()->umur;

            $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'L' AND tbl_anggota_kk.status_warga = $status";
            $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;

            $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'P' AND tbl_anggota_kk.status_warga = $status";
            $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;
        }

        if(isset($_GET['nik'])){
            $nik = $_GET['nik'];
            $data['kk'] = $this->model->get_data_kk_laporan(null, null, null, null, $nik)->result();
            $data['nik'] = $nik;

            $balita = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.nik LIKE '%$nik%'";
            $data['jml_balita'] = $this->db->query($balita)->row()->umur;

            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'L' AND tbl_anggota_kk.nik LIKE '%$nik%'";
            $data['jml_balita_laki'] = $this->db->query($q1)->row()->umur;

            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'P' AND tbl_anggota_kk.nik LIKE '%$nik%'";
            $data['jml_balita_perempuan'] = $this->db->query($q12)->row()->umur;


            $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.nik LIKE '%$nik%'";
            $data['jml_anak'] = $this->db->query($a)->row()->umur;

            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'L' AND tbl_anggota_kk.nik LIKE '%$nik%'";
            $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;

            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'P' AND tbl_anggota_kk.nik LIKE '%$nik%'";
            $data['jml_anak_perempuan'] = $this->db->query($q12)->row()->umur;


            $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.nik LIKE '%$nik%'";
            $data['jml_dewasa'] = $this->db->query($b)->row()->umur;

            $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'L' AND tbl_anggota_kk.nik LIKE '%$nik%'";
            $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;

            $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'P' AND tbl_anggota_kk.nik LIKE '%$nik%'";
            $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;


            $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.nik LIKE '%$nik%'";
            $data['jml_lansia'] = $this->db->query($c)->row()->umur;

            $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'L' AND tbl_anggota_kk.nik LIKE '%$nik%'";
            $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;

            $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'P' AND tbl_anggota_kk.nik LIKE '%$nik%'";
            $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;
        }

        if(isset($_GET['nama'])){
            $nama = $_GET['nama'];
            $data['kk'] = $this->model->get_data_kk_laporan(null, null, null, null, null, $nama)->result();
            $data['nama'] = $nama;

            $balita = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.nama_lengkap LIKE '%$nama%'";
            $data['jml_balita'] = $this->db->query($balita)->row()->umur;

            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'L' AND tbl_anggota_kk.nama_lengkap LIKE '%$nama%'";
            $data['jml_balita_laki'] = $this->db->query($q1)->row()->umur;

            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'P' AND tbl_anggota_kk.nama_lengkap LIKE '%$nama%'";
            $data['jml_balita_perempuan'] = $this->db->query($q12)->row()->umur;


            $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.nama_lengkap LIKE '%$nama%'";
            $data['jml_anak'] = $this->db->query($a)->row()->umur;

            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'L' AND tbl_anggota_kk.nama_lengkap LIKE '%$nama%'";
            $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;

            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'P' AND tbl_anggota_kk.nama_lengkap LIKE '%$nama%'";
            $data['jml_anak_perempuan'] = $this->db->query($q12)->row()->umur;



            $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.nama_lengkap LIKE '%$nama%'";
            $data['jml_dewasa'] = $this->db->query($b)->row()->umur;

            $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'L' AND tbl_anggota_kk.nama_lengkap LIKE '%$nama%'";
            $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;

            $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'P' AND tbl_anggota_kk.nama_lengkap LIKE '%$nama%'";
            $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;


            $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.nama_lengkap LIKE '%$nama%'";
            $data['jml_lansia'] = $this->db->query($c)->row()->umur;

            $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'L' AND tbl_anggota_kk.nama_lengkap LIKE '%$nama%'";
            $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;

            $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'P' AND tbl_anggota_kk.nama_lengkap LIKE '%$nama%'";
            $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;

        }
        
        if(isset($_GET['kk'])){
            $kk = $_GET['kk'];
            $data['kk'] = $this->model->get_data_kk_laporan(null, null, null, null, null, null, $kk)->result();

            $balita = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_kk.no_kk LIKE '%$kk%'";
            $data['jml_balita'] = $this->db->query($balita)->row()->umur;

            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'L' AND tbl_kk.no_kk LIKE '%$kk%'";
            $data['jml_balita_laki'] = $this->db->query($q1)->row()->umur;

            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_anggota_kk.jk = 'P' AND tbl_kk.no_kk LIKE '%$kk%'";
            $data['jml_balita_perempuan'] = $this->db->query($q12)->row()->umur;


            $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.no_kk LIKE '%$kk%'";
            $data['jml_anak'] = $this->db->query($a)->row()->umur;

            $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'L' AND tbl_kk.no_kk LIKE '%$kk%'";
            $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;

            $q12 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_anggota_kk.jk = 'P' AND tbl_kk.no_kk LIKE '%$kk%'";
            $data['jml_anak_perempuan'] = $this->db->query($q12)->row()->umur;



            $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.no_kk LIKE '%$kk%'";
            $data['jml_dewasa'] = $this->db->query($b)->row()->umur;

            $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'L' AND tbl_kk.no_kk LIKE '%$kk%'";
            $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;

            $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_anggota_kk.jk = 'P' AND tbl_kk.no_kk LIKE '%$kk%'";
            $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;


            $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.no_kk LIKE '%$kk%'";
            $data['jml_lansia'] = $this->db->query($c)->row()->umur;

            $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'L' AND tbl_kk.no_kk LIKE '%$kk%'";
            $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;

            $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_anggota_kk.jk = 'P' AND tbl_kk.no_kk LIKE '%$kk%'";
            $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;

        }



        $this->load->view('dashboard/gen_excel', $data);
    }

    public function cari()
    {
        $tipe = $_POST['tipe'];
        $cari = $_POST['cari'];


        if ($tipe == 'kk') {
            $data['kk'] = $this->db->like('no_kk', $cari)->get('tbl_kk')->result();
            $this->load->view('dashboard/get_table_rt', $data);
        } else if ($tipe == 'rt') {
            $data['kk'] = $this->db->where('rt', $cari)->get('tbl_kk')->result();
            $this->load->view('dashboard/get_table_rt', $data);
        } else if ($tipe == 'nik') {
            $q = "SELECT * FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.nik LIKE '%$cari%'";
            $data['kk'] = $this->db->query($q)->result();
            $this->load->view('dashboard/get_table_rt', $data);
        } else if ($tipe == 'nama') {
            $q = "SELECT * FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.nama_lengkap LIKE '%$cari%'";
            $data['kk'] = $this->db->query($q)->result();
            $this->load->view('dashboard/get_table_rt', $data);
        } else if ($tipe == 'rw') {
            $data['kk'] = $this->db->where('rw', $cari)->get('tbl_kk')->result();
            $this->load->view('dashboard/get_table_rt', $data);
        } else if ($tipe == 'status_rumah') {
            $data['kk'] = $this->db->like('status_rumah', $cari)->get('tbl_kk')->result();
            $this->load->view('dashboard/get_table_rt', $data);
        }
    }

    public function export_excel_rt($cari)
    {
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga by rt.xls");
        $data['kk'] = $this->db->where('rt', $cari)->get('tbl_kk')->result();

        $balita = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_kk.rt = $cari";
        $data['jml_balita'] = $this->db->query($balita)->row()->umur;

        $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_balita_laki'] = $this->db->query($q1)->row()->umur;

        $q11 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_balita_perempuan'] = $this->db->query($q11)->row()->umur;


        $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rt = $cari";
        $data['jml_anak'] = $this->db->query($a)->row()->umur;

        $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;

        $q11 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_anak_perempuan'] = $this->db->query($q11)->row()->umur;



        $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rt = $cari";
        $data['jml_dewasa'] = $this->db->query($b)->row()->umur;

        $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;

        $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;



        $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rt = $cari";
        $data['jml_lansia'] = $this->db->query($c)->row()->umur;

        $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;

        $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rt = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;

        $this->load->view('dashboard/gen_excel', $data);
    }

    public function export_excel_kk($cari)
    {
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga by kk.xls");
        $data['kk'] = $this->db->like('no_kk', $cari)->get('tbl_kk')->result();
        $this->load->view('dashboard/gen_excel', $data);
    }

    public function export_excel_nik($cari)
    {
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga by nik.xls");
        $q = "SELECT * FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.nik LIKE '%$cari%'";
        $data['kk'] = $this->db->query($q)->result();
        $this->load->view('dashboard/gen_excel', $data);
    }

    public function export_excel_nama($cari)
    {
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga by nama.xls");
        $q = "SELECT * FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.nama_lengkap LIKE '%$cari%'";
        $data['kk'] = $this->db->query($q)->result();
        $this->load->view('dashboard/gen_excel', $data);
    }

    public function export_excel_rw($cari)
    {
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga by rw.xls");

        $balita = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_kk.rw = $cari";
        $data['jml_balita'] = $this->db->query($balita)->row()->umur;

        $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_balita_laki'] = $this->db->query($q1)->row()->umur;

        $q11 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Balita' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_balita_perempuan'] = $this->db->query($q11)->row()->umur;


        $a = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rw = $cari";
        $data['jml_anak'] = $this->db->query($a)->row()->umur;

        $q1 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_anak_laki'] = $this->db->query($q1)->row()->umur;

        $q11 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Anak' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_anak_perempuan'] = $this->db->query($q11)->row()->umur;



        $b = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rw = $cari";
        $data['jml_dewasa'] = $this->db->query($b)->row()->umur;

        $q2 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_dewasa_laki'] = $this->db->query($q2)->row()->umur;

        $q22 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Dewasa' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_dewasa_perempuan'] = $this->db->query($q22)->row()->umur;



        $c = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rw = $cari";
        $data['jml_lansia'] = $this->db->query($c)->row()->umur;

        $q3 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'L'";
        $data['jml_lansia_laki'] = $this->db->query($q3)->row()->umur;

        $q33 = "SELECT COUNT('tbl_anggota_kk.umur') AS umur FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_anggota_kk.umur = 'Lansia' AND tbl_kk.rw = $cari AND tbl_anggota_kk.jk = 'P'";
        $data['jml_lansia_perempuan'] = $this->db->query($q33)->row()->umur;

        $data['kk'] = $this->db->where('rw', $cari)->get('tbl_kk')->result();
        $this->load->view('dashboard/gen_excel', $data);
    }

    public function export_excel_status_rumah($cari)
    {
        header("Content-type: application/vdn-ms-excel");
        header("Content-Disposition: attachment; filename=data warga by status rumah.xls");
        $data['kk'] = $this->db->like('status_rumah', $cari)->get('tbl_kk')->result();
        $this->load->view('dashboard/gen_excel', $data);
    }


    public function getRTbyRW()
    {
        $rw = $_POST['rw'];
        $data = $this->db->get_where('tbl_rt', ['id_rw' => $rw])->result();
        echo json_encode($data);
    }

    public function download($file){
        $path = 'assets/docs/'.$file;
        $this->downloadFile($path);
    }

    private function downloadFile($file) {
        if(file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($file).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            readfile($file);
            exit;
        }
    }

    public function grafic(){
        $data = [
            'admin' => $this->db->get_where('tbl_admin', ['username' => $this->session->userdata('username_admin')])->row(),
            'title' => 'Charts',
            'warga' => $this->model->get_all_warga()->num_rows(),
            'jenis_grafik' => (isset($_GET['jenis_grafik'])? $_GET['jenis_grafik'] : null),
            'rw' => $this->model->getData('tbl_rw')->result(),
            'bulan' => (isset($_GET['bulan'])? $_GET['bulan'] : null),
        ];

        if(isset($_GET['jenis_grafik']) ){
            if($_GET['jenis_grafik'] == "jumlah_penduduk"){
                $data['jumlah_penduduk'] = 1;
                $rw = $_GET['rw'];
                if($_GET['rw'] == ''){
                    if($_GET['bulan'] == ''){
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, null,null, null)->num_rows();
                        $data['L'] = $this->model->get_all_warga(null, null, null, null,null, null, 'L')->num_rows();
                        $data['P'] = $this->model->get_all_warga(null, null, null, null,null, null, 'P')->num_rows();
                        $data['data'] = $this->model->get_all_warga(null, null, null, null,null, null)->num_rows();
                        $data['type'] = '';
                    }else{
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, null,null, $bulan)->num_rows();
                        $data['L'] = $this->model->get_all_warga(null, null, null, null,null, $bulan, 'L')->num_rows();
                        $data['P'] = $this->model->get_all_warga(null, null, null, null,null, $bulan, 'P')->num_rows();
                        $data['data'] = $this->model->get_all_warga(null, null, null, null,null, $bulan)->num_rows();
                        $data['type'] = '';
                    }
                }else{
                    if($_GET['bulan'] == ''){
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, $rw,null, null)->num_rows();
                        $data['L'] = $this->model->get_all_warga(null, null, null, $rw,null, null, 'L')->num_rows();
                        $data['P'] = $this->model->get_all_warga(null, null, null, $rw,null, null, 'P')->num_rows();
                        $data['data'] = $this->model->get_all_warga(null, null, null, $rw,null, null)->num_rows();
                        $data['type'] = '';
                    }else{
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, $rw,null, $bulan)->num_rows();;
                        $data['L'] = $this->model->get_all_warga(null, null, null, $rw,null, $bulan, 'L')->num_rows();
                        $data['P'] = $this->model->get_all_warga(null, null, null, $rw,null, $bulan, 'P')->num_rows();
                        $data['data'] = $this->model->get_all_warga(null, null, null, $rw,null, $bulan)->num_rows();
                        $data['type'] = '';
                    }
                }
            }else if($_GET['jenis_grafik'] == "bantuan"){
                $bantuan = $this->model->getAllBantuan()->result();
                $rw = $_GET['rw'];
                $data['bantuan'] = 1;
                if($_GET['rw'] == ''){
                    if($_GET['bulan'] == ''){
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, null,null, null)->num_rows();
                        $data['data'] = $this->model->get_all_warga(null, null, null, null,null, null)->num_rows();
                        $data['type'] = '';
                        foreach($bantuan as $item){
                            $data['nama_bantuan'][] = $item->jenis_bantuan;
                            $data['jumlah_bantuan'][] =  $this->model->get_all_warga(null, null, null, null,null, null,null, $item->id_jenis)->num_rows();
                            $data['color'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
                        }
                    }else{
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, null,null, $bulan)->num_rows();
                        $data['data'] = $this->model->get_all_warga(null, null, null, null,null, $bulan)->num_rows();
                        $data['type'] = '';
                        foreach($bantuan as $item){
                            $data['nama_bantuan'][] = $item->jenis_bantuan;
                            $data['jumlah_bantuan'][] =  $this->model->get_all_warga(null, null, null, null,null, $bulan,null, $item->id_jenis)->num_rows();
                            $data['color'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
                        }
                    }
                }else{
                    if($_GET['bulan'] == ''){
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, $rw,null, null)->num_rows();;
                        $data['data'] = $this->model->get_all_warga(null, null, null, $rw,null, null)->num_rows();
                        $data['type'] = '';
                        foreach($bantuan as $item){
                            $data['nama_bantuan'][] = $item->jenis_bantuan;
                            $data['jumlah_bantuan'][] =  $this->model->get_all_warga(null, null, null, $rw,null, null,null, $item->id_jenis)->num_rows();
                            $data['color'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
                        }
                    }else{
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, $rw,null, $bulan)->num_rows();;
                        $data['data'] = $this->model->get_all_warga(null, null, null, $rw,null, $bulan)->num_rows();
                        $data['type'] = '';
                        foreach($bantuan as $item){
                            $data['nama_bantuan'][] = $item->jenis_bantuan;
                            $data['jumlah_bantuan'][] =  $this->model->get_all_warga(null, null, null, $rw,null, $bulan,null, $item->id_jenis)->num_rows();
                            $data['color'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
                        }
                    }
                }
            
            //PENAMBAHAN FITUR
                //FILTER BERDASARKAN UMUR WARGA
            } else if ($_GET['jenis_grafik'] == "umur") {
                $data['umur'] = ['Balita', 'Anak', 'Dewasa', 'Lansia'];
                $rw = $_GET['rw'];
                if ($_GET['rw'] == '') {
                    if ($_GET['bulan'] == '') {
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, null, null, null)->num_rows();
                        $data['data'] = $this->model->get_all_warga(null, null, null, null, null, null)->num_rows();
                        foreach ($data['umur'] as $item) {
                            $data['nama_umur'][] = $item;
                            $data['jumlah_umur_laki'][] =  $this->model->get_all_warga(null, null, null, null, null, null, 'L', null, $item)->num_rows();
                            $data['jumlah_umur_perempuan'][] =  $this->model->get_all_warga(null, null, null, null, null, null, 'P', null, $item)->num_rows();
                            $data['color_laki'][] = '#D61355';
                            $data['color_perempuan'][] = '#30E3DF';
                        }
                    } else {
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, null, null, $bulan)->num_rows();
                        $data['data'] = $this->model->get_all_warga(null, null, null, null, null, $bulan)->num_rows();
                        foreach ($data['umur'] as $item) {
                            $data['nama_umur'][] = $item;
                            $data['jumlah_umur_laki'][] =  $this->model->get_all_warga(null, null, null, null, null, $bulan, 'L', null, $item)->num_rows();
                            $data['jumlah_umur_perempuan'][] =  $this->model->get_all_warga(null, null, null, null, null, $bulan, 'P', null, $item)->num_rows();
                            $data['color_laki'][] = '#D61355';
                            $data['color_perempuan'][] = '#30E3DF';
                        }
                    }
                } else {
                    if ($_GET['bulan'] == '') {
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, $rw, null, null)->num_rows();;
                        $data['data'] = $this->model->get_all_warga(null, null, null, $rw, null, null)->num_rows();
                        foreach ($data['umur'] as $item) {
                            $data['nama_umur'][] = $item;
                            $data['jumlah_umur_laki'][] =  $this->model->get_all_warga(null, null, null, $rw, null, null, 'L', null, $item)->num_rows();
                            $data['jumlah_umur_perempuan'][] =  $this->model->get_all_warga(null, null, null, $rw, null, null, 'P', null, $item)->num_rows();
                            $data['color_laki'][] = '#D61355';
                            $data['color_perempuan'][] = '#30E3DF';
                        }
                    } else {
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, $rw, null, $bulan)->num_rows();;
                        $data['data'] = $this->model->get_all_warga(null, null, null, $rw, null, $bulan)->num_rows();
                        foreach ($data['umur'] as $item) {
                            $data['nama_umur'][] = $item;
                            $data['jumlah_umur_laki'][] =  $this->model->get_all_warga(null, null, null, $rw, null, $bulan, 'L', null, $item)->num_rows();
                            $data['jumlah_umur_perempuan'][] =  $this->model->get_all_warga(null, null, null, $rw, null, $bulan, 'P', null, $item)->num_rows();
                            $data['color_laki'][] = '#D61355';
                            $data['color_perempuan'][] = '#30E3DF';
                        }
                    }
                }
                //END FILTER
                //END PENAMBAHAN FITUR
                } else {
                $status = $this->model->getAllStatus()->result();
                $rw = $_GET['rw'];
                $data['status'] = 1;
                if($_GET['rw'] == ''){
                    if($_GET['bulan'] == ''){
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, null,null, null)->num_rows();
                        $data['data'] = $this->model->get_all_warga(null, null, null, null,null, null)->num_rows();
                        $data['type'] = '';
                        foreach($status as $item){
                            $data['nama_status'][] = $item->status_warga;
                            $data['jumlah_status'][] =  $this->model->get_all_warga($item->id_status, null, null, null,null, null,null, null)->num_rows();
                            $data['color'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
                        }
                    }else{
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, null,null, $bulan)->num_rows();
                        $data['data'] = $this->model->get_all_warga(null, null, null, null,null, $bulan)->num_rows();
                        $data['type'] = '';
                        foreach($status as $item){
                            $data['nama_status'][] = $item->status_warga;
                            $data['jumlah_status'][] =  $this->model->get_all_warga($item->id_status, null, null, null,null, $bulan,null, null)->num_rows();
                            $data['color'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
                        }
                    }
                }else{
                    if($_GET['bulan'] == ''){
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, $rw,null, null)->num_rows();;
                        $data['data'] = $this->model->get_all_warga(null, null, null, $rw,null, null)->num_rows();
                        $data['type'] = '';
                        foreach($status as $item){
                            $data['nama_status'][] = $item->status_warga;
                            $data['jumlah_status'][] =  $this->model->get_all_warga($item->id_status, null, null, $rw,null, null,null, null)->num_rows();
                            $data['color'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
                        }
                    }else{
                        $bulan = $_GET['bulan'];
                        $data['warga'] = $this->model->get_all_warga(null, null, null, $rw,null, $bulan)->num_rows();;
                        $data['data'] = $this->model->get_all_warga(null, null, null, $rw,null, $bulan)->num_rows();
                        $data['type'] = '';
                        foreach($status as $item){
                            $data['nama_status'][] = $item->status_warga;
                            $data['jumlah_status'][] =  $this->model->get_all_warga($item->id_status, null, null, $rw,null, $bulan,null, null)->num_rows();
                            $data['color'][] = '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);
                        }
                    }
                }
            }
        }

        
        // print_r($data); exit;

        // print_r($data);exit;
        $this->load->view('templates/header', $data);
        $this->load->view('dashboard/charts');
        $this->load->view('templates/footer');
    }

    public function coba(){
        if($this->uri->segment(3) == null){
            $awal = 0;
        } else {
            $awal = $this->uri->segment(3);
        }

        echo $awal;
    }

}
