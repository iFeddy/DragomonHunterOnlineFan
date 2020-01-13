<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Dmhf_info extends CI_Model {

            public function totalRows() {
				
                $query = $this->db->query("SELECT SUM(TABLE_ROWS) as total FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'dmhf';");		

                if ($query->num_rows() == 1)
				{
					foreach($query->result() as $row)
					{
						return $row->total;
					}
                }
				else
				{
					return false;
                }
            }
			
			public function totalSize() {
				
                $query = $this->db->query("SELECT SUM(round(((data_length + index_length) / 1024 / 1024), 2)) as total FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'dmhf';");		

                if ($query->num_rows() == 1)
				{
					foreach($query->result() as $row)
					{
						return $row->total;
					}
                }
				else
				{
					return false;
                }
            }
			
			 public function totalTables() {
				
                $query = $this->db->query("SELECT COUNT(*) as total FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'dmhf';");		

                if ($query->num_rows() == 1)
				{
					foreach($query->result() as $row)
					{
						return $row->total;
					}
                }
				else
				{
					return false;
                }
            }
			
    }
?>