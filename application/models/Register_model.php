<?php
/*
  ###########################################################
  # PRODUCT NAME:   OFF POS
  ###########################################################
  # AUTHER:   Doorsoft
  ###########################################################
  # EMAIL:   info@doorsoft.co
  ###########################################################
  # COPYRIGHTS:   RESERVED BY Door Soft
  ###########################################################
  # WEBSITE:   http://www.doorsoft.co
  ###########################################################
  # This is Register_model Model
  ###########################################################
 */
class Register_model extends CI_Model {

    /**
     * checkAccess
     * @access public
     * @param string
     * @return boolean
     */
    public function checkAccess($records){
        $result = false;
        foreach($records as $single_record){
            if($single_record->menu_id==1 || ($single_record->menu_id>=14 && $single_record->menu_id<=18))
            {
                $result = true;
            }
        }
        return $result;
    }
    
    /**
     * checkRegister
     * @access public
     * @param int
     * @param int
     * @return object
     */
    public function checkRegister($user_id, $outlet_id)
    {
      $this->db->select("register_status as status");
      $this->db->from('tbl_register');
      $this->db->where("user_id", $user_id);
      $this->db->where("outlet_id", $outlet_id);
      $this->db->order_by('id', 'DESC');
      return $this->db->get()->row(); 
    }
}

