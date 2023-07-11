<?php
defined('BASEPATH')or exit('No direct script access allowed');
class Master extends CI_Controller {
    public function __construct(){
        parent::__construct();
        cek_login();
        $this->load->model('M_dashboard','model');
    }

    public function index(){
        redirect('master/rw');
    }

    public function rw(){
        $data = [
            'data' => $this->model->getData('tbl_rw')->result(),
            'admin' => $this->db->get_where('tbl_admin',['username' => $this->session->userdata('username_admin')])->row(),
            'title' => 'Management RW'
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('master/rw');
        $this->load->view('templates/footer');
    }

    public function rt(){
        $data = [
            'rw' => $this->model->getData('tbl_rw')->result(),
            'admin' => $this->db->get_where('tbl_admin',['username' => $this->session->userdata('username_admin')])->row(),
            'data' => $this->model->getDataRTAll(null)->result(),
            'title' => 'Management RT'
        ];

        if(isset($_GET['filter'])){
            $data['data'] = $this->model->getDataRTAll($_GET['filter'])->result();
        }

        $this->load->view('templates/header', $data);
        $this->load->view('master/rt');
        $this->load->view('templates/footer');
    }

    public function status_rumah(){
        $data = [
            'title' => 'Management Status Rumah',
            'admin' => $this->db->get_where('tbl_admin',['username' => $this->session->userdata('username_admin')])->row(),
            'data' => $this->model->getData('tbl_status_rumah')->result(),
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('master/status_rumah');
        $this->load->view('templates/footer');
    }

    public function jenis_bantuan(){
        $data = [
            'title' => 'Management Jenis Bantuan',
            'admin' => $this->db->get_where('tbl_admin',['username' => $this->session->userdata('username_admin')])->row(),
            'data' => $this->model->getData('tbl_jenis_bantuan')->result(),
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('master/jenis_bantuan');
        $this->load->view('templates/footer');
    }

    public function status_warga(){
        $data = [
            'title' => 'Management Status Warga',
            'admin' => $this->db->get_where('tbl_admin',['username' => $this->session->userdata('username_admin')])->row(),
            'data' => $this->model->getData('tbl_status_warga')->result(),
        ];
        $this->load->view('templates/header', $data);
        $this->load->view('master/status_warga');
        $this->load->view('templates/footer');
    }







    private function validation_rw(){
        $this->form_validation->set_rules('rw','No RW', 'required|trim|numeric|is_unique[tbl_rw.no_rw]');
        if($this->form_validation->run() == false){
            $params = [
                'success' => false,
                'type' => 'validation',
                'err_rw' => form_error('rw')
            ];
            echo json_encode($params);
            die;
        } else {
            $rw = $this->input->post('rw');
            if($rw < 0 || $rw == 0){
                $params = [
                    'success' => false,
                    'type' => 'result',
                    'msg' => 'No RW tidak valid'
                ];
                echo json_encode($params);
                die;
            } else {
                return true;
            }
        }
    }

    public function add_rw(){
        $this->validation_rw();
        $data = ['no_rw' => $this->input->post('rw')];
        $this->model->add('tbl_rw', $data);

        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'type' => 'result',
                'msg' => 'Data RW baru berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'type' => 'result',
                'msg' => 'Data RW baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function edit_rw(){
        $this->validation_rw();
        $data = ['no_rw' => $this->input->post('rw')];
        $id = $this->input->post('id_rw');
        $where = 'id_rw';
        $db = 'tbl_rw';
        $this->model->edit($where, $id, $db, $data);

        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'type' => 'result',
                'msg' => 'Data RW berhasil di edit'
            ];
        } else {
            $params = [
                'success' => false,
                'type' => 'result',
                'msg' => 'Data RW gagal di edit'
            ];
        }
        echo json_encode($params);

    }

    public function delete(){
        if($_POST['id_type'] == 'rw'){
            $id = $_POST['id_delete'];
            $this->db->delete('tbl_rw',['id_rw' => $id]);
            if($this->db->affected_rows() > 0){
                $params = [
                    'success' => true,
                    'msg' => 'Data RW berhasil di hapus'
                ];
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Data RW gagal di hapus'
                ];
            }
        } else if($_POST['id_type'] == 'rt'){
            $id = $_POST['id_delete'];
            $this->db->delete('tbl_rt',['id_rt' => $id]);
            if($this->db->affected_rows() > 0){
                $params = [
                    'success' => true,
                    'msg' => 'Data RT berhasil di hapus'
                ];
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Data RT gagal di hapus'
                ];
            }
        } else if($_POST['id_type'] == 'status_rumah'){
            $id = $_POST['id_delete'];
            $this->db->delete('tbl_status_rumah',['id_status' => $id]);
            if($this->db->affected_rows() > 0){
                $params = [
                    'success' => true,
                    'msg' => 'Data status rumah berhasil di hapus'
                ];
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Data status rumah gagal di hapus'
                ];
            }
        } else if($_POST['id_type'] == 'bantuan'){
            $id = $_POST['id_delete'];
            $this->db->delete('tbl_jenis_bantuan',['id_jenis' => $id]);
            if($this->db->affected_rows() > 0){
                $params = [
                    'success' => true,
                    'msg' => 'Data jenis bantuan berhasil di hapus'
                ];
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Data jenis bantuan gagal di hapus'
                ];
            }
        } else if($_POST['id_type'] == 'status_warga'){
            $id = $_POST['id_delete'];
            $this->db->delete('tbl_status_warga',['id_status' => $id]);
            if($this->db->affected_rows() > 0){
                $params = [
                    'success' => true,
                    'msg' => 'Data status_warga berhasil di hapus'
                ];
            } else {
                $params = [
                    'success' => false,
                    'msg' => 'Data status_warga gagal di hapus'
                ];
            }
        }

        echo json_encode($params);
    }


    public function validation_rt(){
        $rw = $this->input->post('rw');
        $rt = $this->input->post('rt');
        $data = $this->db->get_where('tbl_rt',['id_rw' => $rw, 'no_rt' => $rt])->num_rows();

        if($data > 0){
            $params = [
                'success' => false,
                'msg' => 'Data RT sudah ada'
            ];
            echo json_encode($params);
            die;
        } else {
            if($rt < 0 || $rt == 0){
                $params = [
                    'success' =>  false,
                    'msg' => 'No Rt tidak valid'
                ];
                echo json_encode($params);
                die;
            } else {
                return true;
            }
        }
    }

    public function add_rt(){
        $this->validation_rt();
        $data = [
            'id_rw' => $this->input->post('rw'),
            'no_rt' => $this->input->post('rt')
        ];
        $this->model->add('tbl_rt', $data);

        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'type' => 'result',
                'msg' => 'Data RT baru berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'type' => 'result',
                'msg' => 'Data RT baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function edit_rt(){
        $this->validation_rt();

        $data = [
            'id_rw' => $this->input->post('rw'),
            'no_rt' => $this->input->post('rt')
        ];
        $id = $this->input->post('id_rt');
        $where = 'id_rt';
        $db = 'tbl_rt';
        $this->model->edit($where, $id, $db, $data);

        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'type' => 'result',
                'msg' => 'Data RT berhasil di edit'
            ];
        } else {
            $params = [
                'success' => false,
                'type' => 'result',
                'msg' => 'Data RT gagal di edit'
            ];
        }
        echo json_encode($params);

    }



    public function validation_status_rumah(){
        $this->form_validation->set_rules('status','Status Rumah','required|trim|is_unique[tbl_status_rumah.nama_status]');
        if($this->form_validation->run() == false){
            $params = [
                'success' => false,
                'msg' => form_error('status')
            ];
            echo json_encode($params);
            die;
        } else {
            return true;
        }
    }

    public function add_status_rumah(){
        $this->validation_status_rumah();
        $data = ['nama_status' => $this->input->post('status')];
        $this->model->add('tbl_status_rumah', $data);

        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'type' => 'result',
                'msg' => 'Data status rumah baru berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'type' => 'result',
                'msg' => 'Data status rumah baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);    
    }
    public function edit_status_rumah(){
        $this->validation_status_rumah();
        $data = ['nama_status' => $this->input->post('status')];
       
        $id = $this->input->post('id_status');
        $where = 'id_status';
        $db = 'tbl_status_rumah';
        $this->model->edit($where, $id, $db, $data);

        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'type' => 'result',
                'msg' => 'Data status tumah baru berhasil di edit'
            ];
        } else {
            $params = [
                'success' => false,
                'type' => 'result',
                'msg' => 'Data status tumah baru gagal di edit'
            ];
        }
        echo json_encode($params);    
    }



    public function validation_bantuan(){
        $this->form_validation->set_rules('jenis','Jenis Bantuan', 'required|trim|is_unique[tbl_jenis_bantuan.jenis_bantuan]');
        if($this->form_validation->run() == false){
            $params = [
                'success' => false,
                'msg' => form_error('jenis')
            ];
            echo json_encode($params);
            die;
        } else {
            return true;
        }
    }

    public function add_jenis_bantuan(){
        $this->validation_bantuan();
        $data = ['jenis_bantuan' => $this->input->post('jenis')];
        $this->model->add('tbl_jenis_bantuan', $data);

        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'type' => 'result',
                'msg' => 'Data jenis bantuan baru berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'type' => 'result',
                'msg' => 'Data jenis bantuan baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function edit_jenis_bantuan(){
        $this->validation_bantuan();
        $data = ['jenis_bantuan' => $this->input->post('jenis')];
        
        $id = $this->input->post('id_jenis');
        $where = 'id_jenis';
        $db = 'tbl_jenis_bantuan';
        $this->model->edit($where, $id, $db, $data);

        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'type' => 'result',
                'msg' => 'Data jenis bantuan berhasil di edit'
            ];
        } else {
            $params = [
                'success' => false,
                'type' => 'result',
                'msg' => 'Data jenis bantuan gagal di edit'
            ];
        }
        echo json_encode($params);
    }



    public function validation_status_warga(){
        $this->form_validation->set_rules('status','Status Warga', 'required|trim|is_unique[tbl_status_warga.status_warga]');
        if($this->form_validation->run() == false){
            $params = [
                'success' => false,
                'msg' => form_error('status')
            ];
            echo json_encode($params);
            die;
        } else {
            return true;
        }
    }

    public function add_status_warga(){
        $this->validation_status_warga();
        $data = ['status_warga' => $this->input->post('status')];
        $this->model->add('tbl_status_warga', $data);

        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'type' => 'result',
                'msg' => 'Data status warga baru berhasil di tambahkan'
            ];
        } else {
            $params = [
                'success' => false,
                'type' => 'result',
                'msg' => 'Data status warga baru gagal di tambahkan'
            ];
        }
        echo json_encode($params);
    }

    public function edit_status_warga(){
        $this->validation_status_warga();
        $data = ['status_warga' => $this->input->post('status')];
       
        $id = $this->input->post('id_status');
        $where = 'id_status';
        $db = 'tbl_status_warga';
        $this->model->edit($where, $id, $db, $data);

        if($this->db->affected_rows() > 0){
            $params = [
                'success' => true,
                'type' => 'result',
                'msg' => 'Data status warga berhasil di edit'
            ];
        } else {
            $params = [
                'success' => false,
                'type' => 'result',
                'msg' => 'Data status warga gagal di edit'
            ];
        }
        echo json_encode($params);
    }
}