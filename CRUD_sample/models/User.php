<?php

class User {

    /*
    return all Users.
    created by your name
    created at 28-03-19.
    */
    public function getAll() {
        return $this->db->get('user')->result();
    }
    /*
    function for create User.
    return User inserted id.
    created by your name
    created at 28-03-19.
    */
    public function insert($data) {
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }
    /*
    return User by id.
    created by your name
    created at 28-03-19.
    */
    public function getDataById($id) {
        $this->db->where('id', $id);
        return $this->db->get('user')->result();
    }
    /*
    function for update User.
    return true.
    created by your name
    created at 28-03-19.
    */
    public function update($id,$data) {
        $this->db->where('id', $id);
        $this->db->update('user', $data);
        return true;
    }
    /*
    function for delete User.
    return true.
    created by your name
    created at 28-03-19.
    */
    public function delete($id) {
        $this->db->where('id', $id);
        $this->db->delete('user');
        return true;
    }
    /*
    function for change status of User.
    return activated of deactivated.
    created by your name
    created at 28-03-19.
    */
    public function changeStatus($id) {
        $table=$this->getDataById($id);
             if($table[0]->status==0)
             {
                $this->update($id,array('status' => '1'));
                return "Activated";
             }else{
                $this->update($id,array('status' => '0'));
                return "Deactivated";
             }
    }

}
