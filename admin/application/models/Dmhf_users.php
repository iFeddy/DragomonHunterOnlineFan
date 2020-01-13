<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Dmhf_users extends CI_Model {

            public function login($uName, $uPass) {
				
				$condition = "uName = '$uName' and uPass = '$uPass'";
				
                $this->db->select('*');
                $this->db->from('dmhf_users');
                $this->db->where($condition);
                $this->db->limit(1);
				
                $query = $this->db->get();

                if ($query->num_rows() == 1)
				{
					return $query->result();
                }
				else
				{
					return false;
                }
            }
			
    }
?>