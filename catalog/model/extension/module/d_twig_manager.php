<?php
class ModelExtensionModuleDTwigManager extends Model {

    public function __construct($registry){
        parent::__construct($registry);

        if(VERSION < "3.0.0.0"){
            $this->installDatabase();
        }
        
    }


	public function getTheme($route, $theme) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "theme WHERE store_id = '" . (int)$this->config->get('config_store_id') . "' AND theme = '" . $this->db->escape($theme) . "' AND route = '" . $this->db->escape($route) . "'");

		return $query->row;
	}

    public function installDatabase(){
        
        $this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "theme` (
          `theme_id` int(11) NOT NULL AUTO_INCREMENT,
          `store_id` int(11) NOT NULL,
          `theme` varchar(64) NOT NULL,
          `route` varchar(64) NOT NULL,
          `code` mediumtext NOT NULL,
          `date_added` datetime NOT NULL,
          PRIMARY KEY (`theme_id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;");


        $result = $this->db->query("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".DB_DATABASE."' AND TABLE_NAME = '" . DB_PREFIX . "theme' ORDER BY ORDINAL_POSITION")->rows; 
        $columns = array();
        foreach($result as $column){
            $columns[] = $column['COLUMN_NAME'];
        }

        if(in_array('code', $columns)){
             $this->db->query("ALTER TABLE `" . DB_PREFIX . "theme` MODIFY COLUMN `code` mediumtext NOT NULL");
        }

        if(!in_array('date_added', $columns)){
             $this->db->query("ALTER TABLE `" . DB_PREFIX . "theme` ADD `date_added` datetime NOT NULL");
        }

    }
}