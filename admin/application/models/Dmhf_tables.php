<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    class Dmhf_tables extends CI_Model {

            public function rows($table) {
				
                $this->db->select('*');
                $this->db->from($table);
				
                $query = $this->db->get();

                if ($query->num_rows() > 0)
				{
					return $query->num_rows();
                }
				else
				{
					return false;
                }
            }
		
			public function newRows($table) {

				$condition = "filename = '$table'";

				if(strtolower($table) == "c_item"){
					$condition = "filename = 'c_item' or filename = 'c_itemmall'";
				}
				if(strtolower($table) == "t_item"){
					$condition = "filename = 't_item' or filename = 't_itemmall'";
				}
				if(strtolower($table) == "t_enchant"){
					$condition = "filename = 't_enchant' or filename = 't_itemmallenchant'";
				}
				
                $this->db->select('SUM(rows) as total');
                $this->db->from('dmhf_table_version');
				$this->db->where($condition);
				
                $query = $this->db->get();

                if ($query->num_rows() > 0)
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
			
			public function addVersion($csvData){
				$table = 'dmhf_table_version';
				
				$this->db->select('*');
                $this->db->from($table);
				 $query = $this->db->get();

                if ($query->num_rows() > 0)
				{
					$this->db->where("filename", $csvData['filename']);
					$this->db->delete($table);
					$this->db->insert($table, $csvData);
					return true;
				}else{				
					$this->db->insert($table, $csvData);
					return true;
				}
			}
			
			public function checkRow($table, $column, $id){
								
				$this->db->select('*');
				$this->db->from($table);
				$this->db->where("$column = $id");
				$this->db->limit(1);
				
				$query = $this->db->get();

                if ($query->num_rows() == 1)
				{
					return true;
				}
				else
				{				
					return false;
				}
			}

			public function formatted_cols($table){
				$this->db->select('*');
				$this->db->from('dmhf_table_version');
				$this->db->where("filename = '$table'");
				$query = $this->db->get();
				foreach($query->result() as $row)
				{
					return $row->columns;
				}
			
			}
						
			public function add_t_table($table, $data){
				array_push($data, $this->createURL($data[1]));
				
				$dataInsert = $this->createDataInsert($data);			
				$this->db->query("INSERT INTO $table VALUES $dataInsert");

				return true;
			}
			
			public function add_c_table($table, $data){
				$dataInsert = $this->createDataInsert($data);
				$this->db->query("INSERT INTO $table VALUES $dataInsert");
				return true;
			}
			
			public function update_t_table($table, $index, $data){
				
				$this->db->select('*');
				$this->db->from($table);
				$this->db->where("$index = $data[0]");
				$this->db->limit(1);
				
				$query = $this->db->get();

				foreach($query->result() as $row)
				{
					$i = 0;
					$array =json_decode(json_encode($row), true);
					foreach ($array as $clave => $valor) {
						$array[$i] = $valor;
						unset($array[$clave]);
						$i++;
					}
					//Array para comparar creado
					array_pop($array); // lastModified
					array_pop($array); // prettyUrl
					$areEqual = ($array === $data);
					if($areEqual){
						return false;
					}else{
						//Modificar
						array_push($data, $this->createURL($data[1]));
						$dataInsert = $this->createDataInsert($data);
						$this->db->query("REPLACE INTO $table VALUES $dataInsert");
						return true;
					}
					
				}
				return false;
			}
			
			public function update_c_table($table, $index, $data){
				
				$this->db->select('*');
                $this->db->from($table);
				$this->db->where("$index = '$data[0]'");
				$this->db->limit(1);
				
				$query = $this->db->get();

				foreach($query->result() as $row)
				{	
					$i = 0;
					$array = json_decode(json_encode($row), true);
					
					foreach ($array as $clave => $valor) {
						$array[$i] = $valor;
						unset($array[$clave]);
						$i++;
					}
					array_pop($array);
					$areEqual = ($array === $data);
					if($areEqual){
						return false;
					}else{
						//Modificar
						$data = array_map("utf8_encode", $data);
						$dataInsert = $this->createDataInsert($data);
						$this->db->query("REPLACE INTO $table VALUES $dataInsert");
						return true;
					}
				}
				
				return false;
			}
			
			protected function createDataInsert($data){
				$string = "(";
				foreach ($data as &$valor) {
					$valor = addslashes($valor);
					if(strlen($valor) == 0) $valor = "-";
					if(is_numeric($valor)){
						$string .= "$valor,";
					}else{
						$string.="'$valor',";
					}
				}
				$time = $this->actualTime();
				$string .= "'$time')";
				return $string;
			}
			
			protected function actualTime(){
				date_default_timezone_set("America/Argentina/Buenos_Aires");
				$mysqldate = date( 'Y-m-d H:i:s');				
				return $mysqldate;
			}
			
			protected function createURL($string)
			{
				$unwanted_array = array(    'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
                            'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
                            'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
                            'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                            'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
				$string = strtr( $string, $unwanted_array );

				$result = preg_replace("/[^a-zA-Z0-9 ]+/", "", $string);
				$result2 = preg_replace("/[ ]+/", "-", strtolower($result));
				$result3 = rtrim($result2, '-');
				return $result3;
			}
			
    }
?>