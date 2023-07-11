<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_dashboard extends CI_Model
{

    //limit, start, rw, rt, bantuan, status
    public function get_data_kk_all($limit = null, $start = null, $filter_rw = null, $filter_rt = null, $bantuan = null, $status = null, $nik = null, $nama = null, $kk = null, $bulan= null)
    {
        // return $this->db->get('tbl_kk', $limit, $start)->result();

        $this->db->select('
            tbl_kk.*,
            tbl_rt.*,
            tbl_rw.*,
            tbl_status_rumah.*,
            tbl_anggota_kk.*
        ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_anggota_kk','tbl_kk.id_kk = tbl_anggota_kk.id_kk')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status');

        if ($filter_rw != null) {
            $this->db->where('tbl_kk.rw', $filter_rw);
        }
        if ($filter_rt != null) {
            $this->db->where('tbl_kk.rt', $filter_rt);
        }
     
        if($bantuan){
            $this->db->where('tbl_kk.jenis_bantuan', $bantuan);
            $this->db->or_where('tbl_kk.ket_bantuan', $bantuan);
        }

        if($status){
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }

        if($nik){
            $this->db->like('tbl_anggota_kk.nik', $nik);
        }

        if($nama){
            $this->db->like('tbl_anggota_kk.nama_lengkap', $nama);
        }

        if($kk){
            $this->db->like('tbl_kk.no_kk', $kk);
        }
        if($bulan){
            $this->db->where("DATE_FORMAT(tbl_anggota_kk.tgl_input,'%Y-%m') <=", $bulan);
        }

        $this->db->where('tbl_anggota_kk.status_warga !=', 3);
        $this->db->where('tbl_anggota_kk.status_warga !=', 5);


        $this->db->group_by('tbl_kk.id_kk');
        $this->db->limit($limit, $start);
        return $this->db->get();
    }

    public function get_data_kk_laporan($rw = null, $rt = null, $bantuan = null, $status = null, $nik = null, $nama = null, $kk = null)
    {
        $this->db->select('
            tbl_kk.*,
            tbl_rt.*,
            tbl_rw.*,
            tbl_status_rumah.*,
            tbl_anggota_kk.*
        ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_anggota_kk','tbl_kk.id_kk = tbl_anggota_kk.id_kk')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status');

        if($rw){
            $this->db->where('tbl_kk.rw', $rw);
        }
        if($rt){
            $this->db->where('tbl_kk.rt', $rt);
        }
        if($bantuan){
            $this->db->where('tbl_kk.jenis_bantuan', $bantuan);
            $this->db->or_where('tbl_kk.ket_bantuan', $bantuan);
        }

        if($status){
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }

        if($nik){
            $this->db->like('tbl_anggota_kk.nik', $nik);
        }

        if($nama){
            $this->db->like('tbl_anggota_kk.nama_lengkap', $nama);
        }

        if($kk){
            $this->db->like('tbl_kk.no_kk', $kk);
        }

        $this->db->group_by('tbl_kk.id_kk');
        return $this->db->get();
    }

    public function get_data_kk_no($no)
    {
        return $this->db->get_where('tbl_kk', ['id_kk' => $no])->row();
    }

    public function get_kk_all()
    {
        return $this->db->get('tbl_kk')->result();
    }

    public function get_anggota_kk_all($id_kk)
    {
        return $this->db->get_where('tbl_anggota_kk', ['id_kk' => $id_kk])->result();
    }


    public function cari($keyword)
    {
        $q = "SELECT * FROM tbl_kk JOIN tbl_anggota_kk ON tbl_kk.id_kk = tbl_anggota_kk.id_kk WHERE tbl_kk.no_kk LIKE '%$keyword%' OR tbl_anggota_kk.nik LIKE '%$keyword%' OR tbl_anggota_kk.nama_lengkap LIKE '%$keyword%' ";
        return $this->db->query($q)->result();
    }


    public function add_data()
    {

        if(isset($_FILES['docs'])){
            $config['upload_path']          = './assets/docs/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
            $config['file_name']            = 'document_kk';

            $this->load->library('upload', $config);

            if($this->upload->do_upload('docs')){
                $document = $this->upload->data('file_name');
                $doc_exc = $this->upload->data('file_ext');
            } else {
                $document = '';
                $doc_exc = '';
            }
        } 

        $data_kk = [
            'no_kk' => $this->input->post('nokk'),
            'rw' => $this->input->post('rw'),
            'rt' => $this->input->post('rt'),
            'no_rumah' => $this->input->post('no_rumah'),
            'no_rumah_baru' => $this->input->post('no_new'),
            'status_rumah' => $this->input->post('status_rumah'),
            'alamat_ktp' => $this->input->post('alamat'),
            'alamat_domisili' => $this->input->post('alamat_domisili'),
            'ket_rumah' => $this->input->post('rumah'),
            'ket_bantuan' => $this->input->post('bantuan'),
            'tahun_bantuan' => $this->input->post('thnbantuan'),
            'jenis_bantuan' => $this->input->post('jenis_bantuan'),
            'nop_pbb' => $this->input->post('nop_pbb'),
            'tahun_nop_pbb' => $this->input->post('tahun_nop'),
            'doc_exc' => $doc_exc,
            'doc_kk' => $document,
            'no_nop_pbb' => $this->input->post('no_nop')
        ];




        if ($this->db->insert('tbl_kk', $data_kk)) {

            $id_kk = $this->db->get_where('tbl_kk', ['no_kk' => $this->input->post('nokk')])->row()->id_kk;

            $no_kk = $id_kk;
            $nama = $_POST['nama'];
            $nik = $_POST['nik'];
            $jk = $_POST['jk'];
            $tahun_lahir = $_POST['th'];
            $status = $_POST['status_warga'];
            // $umur = $_POST['umur'];




            $data_anggota_kk = array();

            $index = count($nik);

            for ($i = 0; $i < $index; $i++) {
                $only_year = substr($tahun_lahir[$i], 0, 4);
                $u = date('Y') - $only_year;
                if($u < 6){
                    $umur = 'Balita';
                }else if ($u >= 6 && $u < 17) {
                    //anak
                    $umur = 'Anak';
                } else if ($u >= 17 & $u < 60) {
                    //dewasa
                    $umur = 'Dewasa';
                } else if ($u >= 60) {
                    //lansia
                    $umur = 'Lansia';
                }

                array_push($data_anggota_kk, array(
                    'nik' => $nik[$i],
                    'id_kk' => $no_kk,
                    'nama_lengkap' => $nama[$i],
                    'tahun_lahir' => $tahun_lahir[$i],
                    'jk' => $jk[$i],
                    'umur' => $umur,
                    'status_warga' => $status[$i],
                    'tgl_input' => date('Y-m-d'),
                    'tgl_edit_status' => date('Y-m-d'),
                ));
            }



            if ($this->db->insert_batch('tbl_anggota_kk', $data_anggota_kk)) {
                $this->session->set_flashdata('scs_msg', 'Data baru berhasil di tambahkan');
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('err_msg', 'Data baru gagal di tambahkan');
                redirect('dashboard');
            }
        } else {
            $this->session->set_flashdata('err_msg', 'Terjadi kesalahan, harap coba kembali');
            redirect('dashboard');
        }
    }

    public function edit_data_kk($no)
    {
        $kk = $this->db->get_where('tbl_kk',['id_kk' => $no])->row();

        if(isset($_FILES['docs'])){
            $config['upload_path']          = './assets/docs/';
            $config['allowed_types']        = 'gif|jpg|png|jpeg|pdf';
            $config['file_name']            = 'document_kk';

            $this->load->library('upload', $config);

            if($this->upload->do_upload('docs')){
                unlink(FCPATH .'assets/docs/'. $kk->doc_kk);

                $document = $this->upload->data('file_name');
                $doc_exc = $this->upload->data('file_ext');
            } else {
                $document = $kk->doc_kk;
                $doc_exc = $kk->dox_exc;
            }
        } 

        $data_kk = [
            'no_kk' => $this->input->post('nokk'),
            'rw' => $this->input->post('rw'),
            'rt' => $this->input->post('rt'),
            'no_rumah' => $this->input->post('no_rumah'),
            'no_rumah_baru' => $this->input->post('no_new'),
            'status_rumah' => $this->input->post('status_rumah'),
            'alamat_ktp' => $this->input->post('alamat'),
            'alamat_domisili' => $this->input->post('domisili'),
            'ket_rumah' => $this->input->post('rumah'),
            'ket_bantuan' => $this->input->post('bantuan'),
            'tahun_bantuan' => $this->input->post('thnbantuan'),
            'jenis_bantuan' => $this->input->post('jenis_bantuan'),
            'nop_pbb' => $this->input->post('nop_pbb'),
            'tahun_nop_pbb' => $this->input->post('tahun_nop'),
            'doc_exc' => $doc_exc,
            'doc_kk' => $document,
            'no_nop_pbb' => $this->input->post('no_nop')
        ];

        if ($this->db->where('id_kk', $no)->update('tbl_kk', $data_kk)) {
            $this->session->set_flashdata('scs_msg', 'Data KK berhasil di perbarui');
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('err_msg', 'Data KK gagal di perbarui');
            redirect('dashboard');
        }
    }

    public function edit_anggota_kk($id_kk)
    {
        $nama = $_POST['nama'];
        $nik = $_POST['nik'];
        $jk = $_POST['jk'];
        $tahun_lahir = $_POST['th'];
        $status_warga = $_POST['status_warga'];

        // $umur = $_POST['umur'];
        // $id_anggota = $_POST['id_anggota'];
        $id = $_POST['id_anggota'];

        $data_anggota_kk = array();

        $index = count($id);

        for ($i = 0; $i < $index; $i++) {

            $only_year = substr($tahun_lahir[$i], 0, 4);
            $u = date('Y') - $only_year;
            if($u < 6){
                $umur = 'Balita';
            }else if ($u >= 6 && $u < 17) {
                //anak
                $umur = 'Anak';
            } else if ($u >= 17 & $u < 60) {
                //dewasa
                $umur = 'Dewasa';
            } else if ($u >= 60) {
                //lansia
                $umur = 'Lansia';
            }

            $status_old = $this->db->get_where('tbl_anggota_kk', ['id_kk' => $id_kk])->result();
            if($status_old == $status_warga[$i]){
                $tgl_edit_status = $status_old->tgl_edit_status;
            }else{
                $tgl_edit_status = date('Y-m-d');
            }

            array_push($data_anggota_kk, array(
                'id_anggota' => $id[$i],
                'nik' => $nik[$i],
                'nama_lengkap' => $nama[$i],
                'tahun_lahir' => $tahun_lahir[$i],
                'jk' => $jk[$i],
                'umur' => $umur,
                'status_warga' => $status_warga[$i],
                'tgl_edit_status' => $tgl_edit_status
            ));
        }

        // var_dump($data_anggota_kk);die;
        if ($this->db->update_batch('tbl_anggota_kk', $data_anggota_kk, 'id_anggota')) {
            $this->session->set_flashdata('scs_msg', 'Data Berhasil di ubah');
            redirect('dashboard/edit_anggota/' . $id_kk);
        } else {
            redirect('dashboard/edit_anggota/' . $id_kk);
        }
    }

    public function add_anggota_kk($id_kk)
    {
        $no_kk = $id_kk;
        $nama = $_POST['nama'];
        $nik = $_POST['nik'];
        $jk = $_POST['jk'];
        $tahun_lahir = $_POST['th'];
        $status_warga = $_POST['status_warga'];
        // $umur = $_POST['umur'];
        $data_anggota_kk = array();

        $index = count($nik);

        for ($i = 0; $i < $index; $i++) {
            $only_year = substr($tahun_lahir[$i], 0, 4);
            $u = date('Y') - $only_year;
            if($u < 6){
                $umur = 'Balita';
            }else if ($u >= 6 && $u < 17) {
                //anak
                $umur = 'Anak';
            } else if ($u >= 17 & $u < 60) {
                //dewasa
                $umur = 'Dewasa';
            } else if ($u >= 60) {
                //lansia
                $umur = 'Lansia';
            }
            array_push($data_anggota_kk, array(
                'nik' => $nik[$i],
                'id_kk' => $no_kk,
                'nama_lengkap' => $nama[$i],
                'tahun_lahir' => $tahun_lahir[$i],
                'jk' => $jk[$i],
                'umur' => $umur,
                'status_warga' => $status_warga[$i],
                'tgl_input' => date('Y-m-d'),
                'tgl_edit_status' => date('Y-m-d'),
            ));
        }

        if ($this->db->insert_batch('tbl_anggota_kk', $data_anggota_kk)) {
            $this->session->set_flashdata('scs_msg', 'Data baru berhasil di tambahkan');
            redirect('dashboard');
        } else {
            $this->session->set_flashdata('err_msg', 'Data baru gagal di tambahkan');
            redirect('dashboard');
        }
    }


    public function add($table, $data)
    {
        $this->db->insert($table, $data);
    }

    public function getData($table)
    {
        return $this->db->get($table);
    }

    public function edit($where, $id, $db, $data)
    {
        $this->db->where($where, $id)->update($db, $data);
    }


    public function getDataRTAll($filter = null)
    {
        $this->db->select('tbl_rt.*, tbl_rw.no_rw')->from('tbl_rt')->join('tbl_rw', 'tbl_rt.id_rw = tbl_rw.id_rw');

        if ($filter) {
            $this->db->where('tbl_rt.id_rw', $filter);
        }

        return $this->db->get();
    }

    public function getAnggotaKK($id_kk = null, $status = null, $nik = null, $nama = null)
    {
        $this->db->select('
            tbl_anggota_kk.*,
            tbl_status_warga.*
        ')
            ->from('tbl_anggota_kk')
            ->join('tbl_status_warga', 'tbl_anggota_kk.status_warga = tbl_status_warga.id_status')
            ->where('tbl_anggota_kk.id_kk', $id_kk);

        if($status){
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }
        if($nik){
            $this->db->like('tbl_anggota_kk.nik', $nik);
        }
        if($nama){
            $this->db->like('tbl_anggota_kk.nama_lengkap', $nama);
        }

        return $this->db->get()->result();
    }
    public function get_data_kk_status_warga($limit = null, $start = null, $filter_status = null)
    {
        // return $this->db->get('tbl_kk', $limit, $start)->result();

        $this->db->select('
            tbl_kk.*,
            tbl_rt.*,
            tbl_rw.*,
            tbl_status_rumah.*,
            tbl_anggota_kk.*,
        ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status')
            ->join('tbl_anggota_kk', 'tbl_kk.id_kk = tbl_anggota_kk.id_kk');

        if ($filter_status != null) {
            $this->db->where('tbl_anggota_kk.status_warga', $filter_status);
        }

        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }
    public function get_data_kk_bantuan($limit = null, $start = null, $filter_bantuan = null)
    {
        // return $this->db->get('tbl_kk', $limit, $start)->result();

        $this->db->select('
            tbl_kk.*,
            tbl_rt.*,
            tbl_rw.*,
            tbl_status_rumah.*,
            tbl_anggota_kk.*,
        ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status')
            ->join('tbl_anggota_kk', 'tbl_kk.id_kk = tbl_anggota_kk.id_kk');

        if ($filter_bantuan != null) {
            $this->db->where('tbl_kk.ket_bantuan', $filter_bantuan);
        }

        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }


        public function get_all_warga($status = null, $bantuan = null, $get_all_kk = null, $rw = null, $rt = null, $bulan = null, $get_jk = null, $get_bantuan = null, $umur = null){
        $this->db->select('
            tbl_kk.*,
            tbl_anggota_kk.*
        ')->from('tbl_kk')
        ->join('tbl_anggota_kk','tbl_kk.id_kk = tbl_anggota_kk.id_kk');

        if($status){
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }

        if($bantuan){
            $this->db->where('tbl_kk.jenis_bantuan', $bantuan);
            $this->db->or_where('tbl_kk.ket_bantuan', $bantuan);
            $this->db->group_by('tbl_kk.id_kk');
        }
        if ($umur) {
            $this->db->where('tbl_anggota_kk.umur', $umur);
        }


        if($get_all_kk){
            $this->db->group_by('tbl_kk.id_kk');   
        }

        if($rw){
            $this->db->where('tbl_kk.rw', $rw);
        }

        if($rt){
            $this->db->where('tbl_kk.rt', $rt);
        }

        if($bulan){
            $this->db->where("DATE_FORMAT(tbl_anggota_kk.tgl_edit_status,'%Y-%m') <=", $bulan);
        }

        if($get_jk){
            $this->db->where('tbl_anggota_kk.jk', $get_jk);
        }

        if($get_bantuan){
            $this->db->where('tbl_kk.jenis_bantuan', $get_bantuan);
        }

        $this->db->where('tbl_anggota_kk.status_warga !=', 3);
        $this->db->where('tbl_anggota_kk.status_warga !=', 5);
        
        return $this->db->get();
    }


    public function getJmlAll($kk = null, $filter_rw = null, $filter_rt = null, $bantuan = null, $status = null, $nik = null, $nama = null, $fil_kk = null, $bulan = null){
        $this->db->select('
            tbl_kk.*,
            tbl_rt.*,
            tbl_rw.*,
            tbl_status_rumah.*,
            tbl_anggota_kk.*
        ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_anggota_kk','tbl_kk.id_kk = tbl_anggota_kk.id_kk')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status');

        

        if ($filter_rw != null) {
            $this->db->where('tbl_kk.rw', $filter_rw);
        }
        if ($filter_rt != null) {
            $this->db->where('tbl_kk.rt', $filter_rt);
        }
        if($bantuan){
            $this->db->where('tbl_kk.jenis_bantuan', $bantuan);
            $this->db->or_where('tbl_kk.ket_bantuan', $bantuan);
        }
        if($status){
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }
        if($nik){
            $this->db->like('tbl_anggota_kk.nik', $nik);
        }
        if($nama){
            $this->db->like('tbl_anggota_kk.nama_lengkap', $nama);
        }

        if($fil_kk){
            $this->db->like('tbl_kk.no_kk', $fil_kk);
        }
        if($bulan){
            $this->db->where("DATE_FORMAT(tbl_anggota_kk.tgl_input,'%Y-%m') <=", $bulan);
        }

        if($kk){
            $this->db->group_by('tbl_kk.id_kk');
        }

        $this->db->where('tbl_anggota_kk.status_warga !=', 3);
        $this->db->where('tbl_anggota_kk.status_warga !=', 5);
        return $this->db->get();
    }
    
    public function getAllBantuan(){
       return $this->db->select('*')->from('tbl_jenis_bantuan')->get();
    }
    
    public function getAllStatus(){
       return $this->db->select('*')->from('tbl_status_warga')->get();
    }

//PENAMBAHAN FITUR
    public function getAllAnakLaki($kk = null, $filter_rw = null, $filter_rt = null, $bantuan = null, $status = null, $nik = null, $nama = null, $fil_kk = null, $bulan = null)
    {
        $this->db->select('
        tbl_kk.*,
        tbl_rt.*,
        tbl_rw.*,
        tbl_status_rumah.*,
        tbl_anggota_kk.*
    ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_anggota_kk', 'tbl_kk.id_kk = tbl_anggota_kk.id_kk')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status');



        if ($filter_rw != null) {
            $this->db->where('tbl_kk.rw', $filter_rw);
        }
        if ($filter_rt != null) {
            $this->db->where('tbl_kk.rt', $filter_rt);
        }
        if ($bantuan) {
            $this->db->where('tbl_kk.jenis_bantuan', $bantuan);
            $this->db->or_where('tbl_kk.ket_bantuan', $bantuan);
        }
        if ($status) {
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }

        if ($nik) {
            $this->db->like('tbl_anggota_kk.nik', $nik);
        }
        if ($nama) {
            $this->db->like('tbl_anggota_kk.nama_lengkap', $nama);
        }

        if ($fil_kk) {
            $this->db->like('tbl_kk.no_kk', $fil_kk);
        }
        if ($bulan) {
            $this->db->where("DATE_FORMAT(tbl_anggota_kk.tgl_input,'%Y-%m') <=", $bulan);
        }

        if ($kk) {
            $this->db->group_by('tbl_kk.id_kk');
        }

        $this->db->where('tbl_anggota_kk.umur', 'Anak');
        $this->db->where('tbl_anggota_kk.jk', 'L');
        return $this->db->get()->num_rows();
    }
    public function getAllAnakPerempuan($kk = null, $filter_rw = null, $filter_rt = null, $bantuan = null, $status = null, $nik = null, $nama = null, $fil_kk = null, $bulan = null)
    {
        $this->db->select('
        tbl_kk.*,
        tbl_rt.*,
        tbl_rw.*,
        tbl_status_rumah.*,
        tbl_anggota_kk.*
    ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_anggota_kk', 'tbl_kk.id_kk = tbl_anggota_kk.id_kk')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status');



        if ($filter_rw != null) {
            $this->db->where('tbl_kk.rw', $filter_rw);
        }
        if ($filter_rt != null) {
            $this->db->where('tbl_kk.rt', $filter_rt);
        }
        if ($bantuan) {
            $this->db->where('tbl_kk.jenis_bantuan', $bantuan);
            $this->db->or_where('tbl_kk.ket_bantuan', $bantuan);
        }
        if ($status) {
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }

        if ($nik) {
            $this->db->like('tbl_anggota_kk.nik', $nik);
        }
        if ($nama) {
            $this->db->like('tbl_anggota_kk.nama_lengkap', $nama);
        }

        if ($fil_kk) {
            $this->db->like('tbl_kk.no_kk', $fil_kk);
        }
        if ($bulan) {
            $this->db->where("DATE_FORMAT(tbl_anggota_kk.tgl_input,'%Y-%m') <=", $bulan);
        }

        if ($kk) {
            $this->db->group_by('tbl_kk.id_kk');
        }


        $this->db->where('tbl_anggota_kk.umur', 'Anak');
        $this->db->where('tbl_anggota_kk.jk', 'P');
        return $this->db->get()->num_rows();
    }
    public function getAllBalitaLaki($kk = null, $filter_rw = null, $filter_rt = null, $bantuan = null, $status = null, $nik = null, $nama = null, $fil_kk = null, $bulan = null)
    {
        $this->db->select('
        tbl_kk.*,
        tbl_rt.*,
        tbl_rw.*,
        tbl_status_rumah.*,
        tbl_anggota_kk.*
    ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_anggota_kk', 'tbl_kk.id_kk = tbl_anggota_kk.id_kk')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status');



        if ($filter_rw != null) {
            $this->db->where('tbl_kk.rw', $filter_rw);
        }
        if ($filter_rt != null) {
            $this->db->where('tbl_kk.rt', $filter_rt);
        }
        if ($bantuan) {
            $this->db->where('tbl_kk.jenis_bantuan', $bantuan);
            $this->db->or_where('tbl_kk.ket_bantuan', $bantuan);
        }
        if ($status) {
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }

        if ($nik) {
            $this->db->like('tbl_anggota_kk.nik', $nik);
        }
        if ($nama) {
            $this->db->like('tbl_anggota_kk.nama_lengkap', $nama);
        }

        if ($fil_kk) {
            $this->db->like('tbl_kk.no_kk', $fil_kk);
        }
        if ($bulan) {
            $this->db->where("DATE_FORMAT(tbl_anggota_kk.tgl_input,'%Y-%m') <=", $bulan);
        }

        if ($kk) {
            $this->db->group_by('tbl_kk.id_kk');
        }

        $this->db->where('tbl_anggota_kk.umur', 'Balita');
        $this->db->where('tbl_anggota_kk.jk', 'L');
        return $this->db->get()->num_rows();
    }
    public function getAllBalitaPerempuan($kk = null, $filter_rw = null, $filter_rt = null, $bantuan = null, $status = null, $nik = null, $nama = null, $fil_kk = null, $bulan = null)
    {
        $this->db->select('
        tbl_kk.*,
        tbl_rt.*,
        tbl_rw.*,
        tbl_status_rumah.*,
        tbl_anggota_kk.*
    ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_anggota_kk', 'tbl_kk.id_kk = tbl_anggota_kk.id_kk')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status');



        if ($filter_rw != null) {
            $this->db->where('tbl_kk.rw', $filter_rw);
        }
        if ($filter_rt != null) {
            $this->db->where('tbl_kk.rt', $filter_rt);
        }
        if ($bantuan) {
            $this->db->where('tbl_kk.jenis_bantuan', $bantuan);
            $this->db->or_where('tbl_kk.ket_bantuan', $bantuan);
        }
        if ($status) {
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }

        if ($nik) {
            $this->db->like('tbl_anggota_kk.nik', $nik);
        }
        if ($nama) {
            $this->db->like('tbl_anggota_kk.nama_lengkap', $nama);
        }

        if ($fil_kk) {
            $this->db->like('tbl_kk.no_kk', $fil_kk);
        }
        if ($bulan) {
            $this->db->where("DATE_FORMAT(tbl_anggota_kk.tgl_input,'%Y-%m') <=", $bulan);
        }

        if ($kk) {
            $this->db->group_by('tbl_kk.id_kk');
        }

        $this->db->where('tbl_anggota_kk.umur', 'Balita');
        $this->db->where('tbl_anggota_kk.jk', 'P');
        return $this->db->get()->num_rows();
    }
    public function getAllDewasaLaki($kk = null, $filter_rw = null, $filter_rt = null, $bantuan = null, $status = null, $nik = null, $nama = null, $fil_kk = null, $bulan = null)
    {
        $this->db->select('
        tbl_kk.*,
        tbl_rt.*,
        tbl_rw.*,
        tbl_status_rumah.*,
        tbl_anggota_kk.*
    ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_anggota_kk', 'tbl_kk.id_kk = tbl_anggota_kk.id_kk')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status');



        if ($filter_rw != null) {
            $this->db->where('tbl_kk.rw', $filter_rw);
        }
        if ($filter_rt != null) {
            $this->db->where('tbl_kk.rt', $filter_rt);
        }
        if ($bantuan) {
            $this->db->where('tbl_kk.jenis_bantuan', $bantuan);
            $this->db->or_where('tbl_kk.ket_bantuan', $bantuan);
        }
        if ($status) {
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }

        if ($nik) {
            $this->db->like('tbl_anggota_kk.nik', $nik);
        }
        if ($nama) {
            $this->db->like('tbl_anggota_kk.nama_lengkap', $nama);
        }

        if ($fil_kk) {
            $this->db->like('tbl_kk.no_kk', $fil_kk);
        }
        if ($bulan) {
            $this->db->where("DATE_FORMAT(tbl_anggota_kk.tgl_input,'%Y-%m') <=", $bulan);
        }

        if ($kk) {
            $this->db->group_by('tbl_kk.id_kk');
        }

        $this->db->where('tbl_anggota_kk.umur', 'Dewasa');
        $this->db->where('tbl_anggota_kk.jk', 'L');
        return $this->db->get()->num_rows();
    }
    public function getAllDewasaPerempuan($kk = null, $filter_rw = null, $filter_rt = null, $bantuan = null, $status = null, $nik = null, $nama = null, $fil_kk = null, $bulan = null)
    {
        $this->db->select('
        tbl_kk.*,
        tbl_rt.*,
        tbl_rw.*,
        tbl_status_rumah.*,
        tbl_anggota_kk.*
    ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_anggota_kk', 'tbl_kk.id_kk = tbl_anggota_kk.id_kk')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status');



        if ($filter_rw != null) {
            $this->db->where('tbl_kk.rw', $filter_rw);
        }
        if ($filter_rt != null) {
            $this->db->where('tbl_kk.rt', $filter_rt);
        }
        if ($bantuan) {
            $this->db->where('tbl_kk.jenis_bantuan', $bantuan);
            $this->db->or_where('tbl_kk.ket_bantuan', $bantuan);
        }
        if ($status) {
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }

        if ($nik) {
            $this->db->like('tbl_anggota_kk.nik', $nik);
        }
        if ($nama) {
            $this->db->like('tbl_anggota_kk.nama_lengkap', $nama);
        }

        if ($fil_kk) {
            $this->db->like('tbl_kk.no_kk', $fil_kk);
        }
        if ($bulan) {
            $this->db->where("DATE_FORMAT(tbl_anggota_kk.tgl_input,'%Y-%m') <=", $bulan);
        }

        if ($kk) {
            $this->db->group_by('tbl_kk.id_kk');
        }

        $this->db->where('tbl_anggota_kk.umur', 'Dewasa');
        $this->db->where('tbl_anggota_kk.jk', 'P');
        return $this->db->get()->num_rows();
    }
    public function getAllLansiaLaki($kk = null, $filter_rw = null, $filter_rt = null, $bantuan = null, $status = null, $nik = null, $nama = null, $fil_kk = null, $bulan = null)
    {
        $this->db->select('
        tbl_kk.*,
        tbl_rt.*,
        tbl_rw.*,
        tbl_status_rumah.*,
        tbl_anggota_kk.*
    ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_anggota_kk', 'tbl_kk.id_kk = tbl_anggota_kk.id_kk')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status');



        if ($filter_rw != null) {
            $this->db->where('tbl_kk.rw', $filter_rw);
        }
        if ($filter_rt != null) {
            $this->db->where('tbl_kk.rt', $filter_rt);
        }
        if ($bantuan) {
            $this->db->where('tbl_kk.jenis_bantuan', $bantuan);
            $this->db->or_where('tbl_kk.ket_bantuan', $bantuan);
        }
        if ($status) {
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }

        if ($nik) {
            $this->db->like('tbl_anggota_kk.nik', $nik);
        }
        if ($nama) {
            $this->db->like('tbl_anggota_kk.nama_lengkap', $nama);
        }

        if ($fil_kk) {
            $this->db->like('tbl_kk.no_kk', $fil_kk);
        }
        if ($bulan) {
            $this->db->where("DATE_FORMAT(tbl_anggota_kk.tgl_input,'%Y-%m') <=", $bulan);
        }

        if ($kk) {
            $this->db->group_by('tbl_kk.id_kk');
        }

        $this->db->where('tbl_anggota_kk.umur', 'Lansia');
        $this->db->where('tbl_anggota_kk.jk', 'L');
        return $this->db->get()->num_rows();
    }
    public function getAllLansiaPerempuan($kk = null, $filter_rw = null, $filter_rt = null, $bantuan = null, $status = null, $nik = null, $nama = null, $fil_kk = null, $bulan = null)
    {
        $this->db->select('
        tbl_kk.*,
        tbl_rt.*,
        tbl_rw.*,
        tbl_status_rumah.*,
        tbl_anggota_kk.*
    ')
            ->from('tbl_kk')
            ->join('tbl_rt', 'tbl_kk.rt = tbl_rt.id_rt')
            ->join('tbl_rw', 'tbl_kk.rw = tbl_rw.id_rw')
            ->join('tbl_anggota_kk', 'tbl_kk.id_kk = tbl_anggota_kk.id_kk')
            ->join('tbl_status_rumah', 'tbl_kk.status_rumah = tbl_status_rumah.id_status');



        if ($filter_rw != null) {
            $this->db->where('tbl_kk.rw', $filter_rw);
        }
        if ($filter_rt != null) {
            $this->db->where('tbl_kk.rt', $filter_rt);
        }
        if ($bantuan) {
            $this->db->where('tbl_kk.jenis_bantuan', $bantuan);
            $this->db->or_where('tbl_kk.ket_bantuan', $bantuan);
        }
        if ($status) {
            $this->db->where('tbl_anggota_kk.status_warga', $status);
        }

        if ($nik) {
            $this->db->like('tbl_anggota_kk.nik', $nik);
        }
        if ($nama) {
            $this->db->like('tbl_anggota_kk.nama_lengkap', $nama);
        }

        if ($fil_kk) {
            $this->db->like('tbl_kk.no_kk', $fil_kk);
        }
        if ($bulan) {
            $this->db->where("DATE_FORMAT(tbl_anggota_kk.tgl_input,'%Y-%m') <=", $bulan);
        }

        if ($kk) {
            $this->db->group_by('tbl_kk.id_kk');
        }

        $this->db->where('tbl_anggota_kk.umur', 'Lansia');
        $this->db->where('tbl_anggota_kk.jk', 'P');
        return $this->db->get()->num_rows();
    }
    //END PENAMBAHAN FITUR

}
