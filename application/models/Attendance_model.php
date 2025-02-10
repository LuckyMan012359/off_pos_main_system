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
  # This is Attendance_model Model
  ###########################################################
 */
class Attendance_model extends CI_Model {

    /**
     * generateReferenceNo
     * @access public
     * @param no
     * @return string
     */
    public function generateReferenceNo() {
        $reference_no = $this->db->query("SELECT count(id) as reference_no
               FROM tbl_attendance")->row('reference_no');
        $reference_no = str_pad($reference_no + 1, 6, '0', STR_PAD_LEFT);
        return $reference_no;
    }
}

