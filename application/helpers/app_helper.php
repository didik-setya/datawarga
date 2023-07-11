<?php
function cek_edit_kk(){
    $t = get_instance();
    $id = $t->uri->segment(3);
    
    if($id == null){
        redirect('dashboard');
    } else {
        $id_kk = $t->db->get_where('tbl_kk',['id_kk' => $id])->row()->id_kk;
        if($id == $id_kk){
            return true;
        } else {
            redirect('dashboard');
        }
    }

}

function cek_login(){
    $t = get_instance();
    $admin = $t->session->userdata('username_admin');

    if(!$admin){
        redirect(base_url());
    }
}

function cek_login_auth(){
    $t = get_instance();
    $admin = $t->session->userdata('username_admin');

    if($admin){
        redirect(base_url('dashboard'));
    }
}