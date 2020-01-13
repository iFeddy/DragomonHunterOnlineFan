<?php
defined('BASEPATH') OR exit('No direct script access allowed');
set_time_limit(0);

class Database extends CI_Controller {
		
	function __construct()
	{
		parent::__construct();
		if (!(isset($this->session->uID)))
        { 
            redirect('login');
        }
	}
	
	public function index(){
		$this->load->library('configmanager');
		$data = $this->configmanager->getData();
		$this->load->database();
		$this->load->model("dmhf_info");
		
		$this->load->view("common/header", $data);
		$this->load->view("menu/default");
		$this->load->view("database/default");
		$this->load->view("footer/default", $data);
	}

	public function format()
	{   
		$this->load->library('configmanager');
		$data = $this->configmanager->getData();
	
		$this->load->view("common/header", $data);
		$this->load->view("menu/default");
		$this->load->view("database/format");
		$this->load->view("footer/default", $data);
	}
	
	public function format_tables($table)
	{
		$data = array();
		$this->load->database();
		$this->load->model("dmhf_tables");
		
		$engFile = false;
		$fileName = "db/".$table;
		$output = "db/output/".$table;

		$file = fopen($fileName, "rb");
		$ofile = fopen(strtolower($output), "ab+");
		
		if (0 === strpos($table, 't_')) $engFile = true;

		$content = fread($file, filesize($fileName));

		if(!($engFile)) $content = mb_convert_encoding($content, 'UTF-8', 'Big5');
		
		$oRegex = '/([|])(\\r\\n|\\r|\\n)/';
		$oChange = "@dmhf_tables@";
		$content = preg_replace($oRegex, $oChange, $content);

		$oRegex = '/[\r]/';
		$oChange = "";
		$content = preg_replace($oRegex, $oChange, $content);

		$oRegex = '/[\n]/';
		$oChange = "";
		$content = preg_replace($oRegex, $oChange, $content);

		$oRegex = '/(@dmhf_tables@)/';
		$oChange = "\r\n";
		$content = preg_replace($oRegex, $oChange, $content);

		$oRegex = '/(\|)/';
		$oChange = "\t";
		$content = preg_replace($oRegex, $oChange, $content);

		//English Fix
		if($engFile){
			$oRegex = '/(\r\n)(.*)(\r\n)/';
			$oChange = "\r\n";
			$content = preg_replace($oRegex, $oChange, $content, 1);
			
			$oRegex = '/(\r\n)(\$)/';
			$oChange = "\t$";
			$content = preg_replace($oRegex, $oChange, $content);
			

		}else{
			///[\x{4E00}-\x{9FBF}\x{3040}-\x{309F}\x{30A0}-\x{30FF}]/u
			$oRegex = '/[\x{4E00}-\x{9FBF}\x{3040}-\x{309F}\x{30A0}-\x{30FF}\x{5697}-]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$content = preg_replace('/[\x{5697}]/u', $oChange, $content);

			//Empty Strings
			$ending = "\r\n";
			$endsWith = substr_compare($content, "\r\n", -strlen($ending)) === 0;
			$content = substr($content, 0, -strlen($ending));

			//Chinese Fix
			if (0 === strpos($content, "\t")){
				$content = ltrim($content, "\t");
			}
			
			$oRegex = '/[＜]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);
			
			$oRegex = '/[＞]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[‧]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);
			
			$oRegex = '/[．]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);
			
			$oRegex = '/[＿]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);
			
			$oRegex = '/[（]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);
			
			$oRegex = '/[）]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);
			
			$oRegex = '/[！]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);
			
			$oRegex = '/[，]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);
			
			$oRegex = '/[。]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[–]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[「]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[」]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[、]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[※]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[─]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[＋]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[…]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[『]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[』]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[：]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);		

			$oRegex = '/[；]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);	

			$oRegex = '/[０-９]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[Ａ-Ｚ]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[？]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);

			$oRegex = '/[～]/u';
			$oChange = "?";
			$content = preg_replace($oRegex, $oChange, $content);
			}

		$content = str_replace(chr(151), " ", $content);
		$content = str_replace(chr(150), " ", $content);	
		
		file_put_contents(trim($output), $content);

		fclose($ofile);
		fclose($file);
		
		//DB Changes
		$data = $this->_readInfo($table);
		$status = $data['status'];
		if($status == true){
			unset($data['status']);
			$this->dmhf_tables->addVersion($data);
		}		
		echo json_encode(array("status"=> $status));		
	}
	
	public function update()
	{   
		$this->load->library('configmanager');
		$data = $this->configmanager->getData();
		
		$this->load->database();
		$this->load->model('dmhf_tables');
				
		$this->load->view("common/header", $data);
		$this->load->view("menu/default");
		$this->load->view("database/update");
		$this->load->view("footer/default", $data);
	}
	
	protected function _readInfo($table){
		$data = array();
		$data['status'] = true;
		$output = "db/output/".$table;
		$data['filename'] = substr($table, 0, -4);
		$fh = fopen($output,"r");
		$row = 1;

		while (!feof($fh)) {
			if($row == 1){
				$line = fgets($fh);
				$info = explode("\t", $line);
				if (array_key_exists('0', $info)){
					$data['version'] = trim($info[0]);
					$data['status'] = true;
				}else{
					$data['status'] = false;
				}
				if (array_key_exists('1', $info)){
					$data['columns'] = trim($info[1]);
					$data['status'] = true;
				}else{
					$data['status'] = false;
				}
			}
			if($row == 0){
				$data['status'] = false;
			}
			$line = fgets($fh);
			$info = explode("\t", $line);
			for ($i = 0; $i < count($info); $i++)
			{
				if (trim($info[$i]) == null) $info[$i] = "-";
			}
			if(is_numeric($info[0])){
				$row++;
			}
		}
		$data['rows'] = $row - 1;
		return $data;
	}
	
	public function update_biology(){

		$json = array();
		
		$starttime = microtime(true);
		
		$this->load->database();
		$this->load->model('dmhf_tables');
		
		$result1 = $this->doTable("t_biology", "mID");
		$result2 = $this->doTable("c_biology", "mID");
		
		$endtime = microtime(true);	
		$timediff = $endtime - $starttime;
		$json['added'] = $result1['added'] + $result2['added'];
		$json['modified'] = $result1['modified'] + $result2['modified'];
		$json['time'] = number_format($timediff, 2);
		
		echo json_encode($json);
	}
	
	public function update_titles(){

		$json = array();
		
		$starttime = microtime(true);
		
		$this->load->database();
		$this->load->model('dmhf_tables');
		
		$result1 = $this->doTable("t_title", "tID");
		$result2 = $this->doTable("c_title", "tID");
		
		$endtime = microtime(true);	
		$timediff = $endtime - $starttime;
		$json['added'] = $result1['added'] + $result2['added'];
		$json['modified'] = $result1['modified'] + $result2['modified'];
		$json['time'] = number_format($timediff, 2);
		
		echo json_encode($json);
	}

	public function update_quests(){

		$json = array();
		
		$starttime = microtime(true);
		
		$this->load->database();
		$this->load->model('dmhf_tables');
		
		$result1 = $this->doTable("t_mission", "qID");
		$result2 = $this->doTable("c_mission", "qID");
		
		$endtime = microtime(true);	
		$timediff = $endtime - $starttime;
		$json['added'] = $result1['added'] + $result2['added'];
		$json['modified'] = $result1['modified'] + $result2['modified'];
		$json['time'] = number_format($timediff, 2);
		
		echo json_encode($json);
	}

	public function update_achievements(){

		$json = array();
		
		$starttime = microtime(true);
		
		$this->load->database();
		$this->load->model('dmhf_tables');
		
		$result1 = $this->doTable("t_achievement", "aID");
		$result2 = $this->doTable("c_achievement", "aID");
		
		$endtime = microtime(true);	
		$timediff = $endtime - $starttime;
		$json['added'] = $result1['added'] + $result2['added'];
		$json['modified'] = $result1['modified'] + $result2['modified'];
		$json['time'] = number_format($timediff, 2);
		
		echo json_encode($json);
	}

	protected function doTable($table, $index){
		$result = array();
		$added = 0;
		$modified = 0;

		$output = "db/output/".$table.".ini";
		$fh = fopen($output,"r");
		$isChinese = false;
		$row = 1;
		
		$c = $this->dmhf_tables->formatted_cols($table);
		
		if (0 === strpos($table, 'c_')) {
			$isChinese = true;
		}		

		while (!feof($fh)) {
			if($row == 1){
				$line = fgets($fh);
				$row++;
			}

			$line = fgets($fh);
			$info = explode("\t", $line);
			
			for ($i = 0; $i < $c; $i++)
			{
				if (!(array_key_exists($i, $info))) $info[$i] = "-";
				if (!(is_numeric($info[$i]))) $info[$i] = utf8_encode($info[$i]);
				if (trim($info[$i]) == null) $info[$i] = "-";
			}
			
			if(is_numeric($info[0])){
				$hasRow = $this->dmhf_tables->checkRow($table, $index, $info[0]);
				if($hasRow){
					//Moficar datos
					if($isChinese){
						$status = $this->dmhf_tables->update_c_table($table, $index, $info);
					}else{
						$status = $this->dmhf_tables->update_t_table($table, $index, $info);
					}
					if($status) $modified++;
				}else{
					//Agregar Datos
					if($isChinese){
						$status = $this->dmhf_tables->add_c_table($table, $info);
					}else{
						$status = $this->dmhf_tables->add_t_table($table, $info);
					}
					if($status) $added++;
				}
			}
			$row++;	
		}
		$result['modified'] = $modified;
		$result['added'] = $added;
		return $result;
	}
}

?>