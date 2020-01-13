<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class configManager {

    private $apiBuild = "0.0.20";
	private $loginBuild = "1.0.0";
	private $siteTitle = "Dragomon Hunter Fan";
    private $apiTitle = "Dragomon Hunter Fan - Admin Panel";

    public function getData()
        {
            $data = array();
            $data['api']['version'] = $this->apiBuild;
            $data['api']['url_title'] = $this->siteTitle;
			$data['login']['version'] = $this->loginBuild;
            return $data;
        }

}
?>