<?php


class UserController {

    public function __construct() {
        parent::__construct();
        $this->load->model('user');
        $this->load->library('session');
    }
    /*
    function for manage User.
    return all Users.
    created by your name
    created at 28-03-19.
    */
    public function manageUser() {
        $data["users"] = $this->user->getAll();
        $this->load->view('user/manage-user', $data);
    }
    /*
    function for  add User get
    created by your name
    created at 28-03-19.
    */
    public function addUser() {
        $this->load->view('user/add-user');
    }
    /*
    function for add User post
    created by your name
    created at 28-03-19.
    */
    public function addUserPost() {
        $data['id'] = $this->input->post('id');
        $data['name'] = $this->input->post('name');
        $data['loginid'] = $this->input->post('loginid');
        $data['gender'] = $this->input->post('gender');
    $this->user->insert($data);
        $this->session->set_flashdata('success', 'User added Successfully');
        redirect('manage-user');
    }
    /*
    function for edit User get
    returns  User by id.
    created by your name
    created at 28-03-19.
    */
    public function editUser($user_id) {
        $data['user_id'] = $user_id;
        $data['user'] = $this->user->getDataById($user_id);
        $this->load->view('user/edit-user', $data);
    }
    /*
    function for edit User post
    created by your name
    created at 28-03-19.
    */
    public function editUserPost() {
        $user_id = $this->input->post('user_id');
        $user = $this->user->getDataById($user_id);
        $data['id'] = $this->input->post('id');
        $data['name'] = $this->input->post('name');
        $data['loginid'] = $this->input->post('loginid');
        $data['gender'] = $this->input->post('gender');
    $edit = $this->user->update($user_id,$data);
        if ($edit) {
            $this->session->set_flashdata('success', 'User Updated');
            redirect('manage-user');
        }
    }
    /*
    function for view User get
    created by your name
    created at 28-03-19.
    */
    public function viewUser($user_id) {
        $data['user_id'] = $user_id;
        $data['user'] = $this->user->getDataById($user_id);
        $this->load->view('user/view-user', $data);
    }
    /*
    function for delete User    created by your name
    created at 28-03-19.
    */
    public function deleteUser($user_id) {
        $delete = $this->user->delete($user_id);
        $this->session->set_flashdata('success', 'user deleted');
        redirect('manage-user');
    }
    /*
    function for activation and deactivation of User.
    created by your name
    created at 28-03-19.
    */
    public function changeStatusUser($user_id) {
        $edit = $this->user->changeStatus($user_id);
        $this->session->set_flashdata('success', 'user '.$edit.' Successfully');
        redirect('manage-user');
    }

}
