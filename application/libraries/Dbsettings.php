<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Use:
*     $this->load->database();
*     $this->load->library('dbsettings');
*     
* To set value: $this->dbsettings->var_name = 'value';
* To get value:    $this->dbsettings->var_name
* To check if the variable isset: $this->dbsettings->__isset($var_name);
* To unset variable use: $this->dbsettings->__unset($var_name);
* As of PHP 5.1.0 You can use isset($this->dbsettings->var_name), unset($this->dbsettings->var_name);
*
* @version: 0.1 (c) _andrew 27-03-2008
**/
class Dbsettings {
    const TABLE = 'tbl_website_setting';
    //Table where variables will be stored.

    private $data;
    private $ci;

    function __construct()
    {
        $CI =& get_instance();
        $CI->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
        if($CI->cache->file->get('tbl_website_setting')){
	    	$this->data = $CI->cache->file->get('tbl_website_setting');
	    }
	    else
	    {
	        $q = $CI->db->get(self::TABLE);
	      	foreach ($q->result() as $row)
	       	{
	           //$this->data[$row->var_name] = unserialize($row->setting_value);
			   $this->data[$row->var_name] = $row->setting_value;
	       	}
	       $CI->cache->file->save('tbl_website_setting',$this->data,99999999999999999999);	
	       	$q->free_result();
	    }
    }

    function __get($var_name){
        if(isSet($this->data[$var_name]))
		{
		return $this->data[$var_name];
		}
		else
		{
		return "";
		}
    }

    function __set($var_name, $value){
        if (isset($this->data[$var_name])){
            $this->ci->db->where('var_name', $var_name);
            //$this->ci->db->update(self::TABLE, array('setting_value' => serialize($value)));
			$this->ci->db->update(self::TABLE, array('setting_value' => ($value)));
        } else {
            //$this->ci->db->insert(self::TABLE, array('var_name' => $var_name, 'setting_value' => serialize($value)));
			$this->ci->db->insert(self::TABLE, array('var_name' => $var_name, 'setting_value' => ($value)));
        }
        $this->data[$var_name] = $value;
    }

    /**  As of PHP 5.1.0  */
    function __isset($var_name) {
        return isset($this->data[$var_name]);
    }

    /**  As of PHP 5.1.0  */
    function __unset($var_name) {
        $this->ci->db->delete(self::TABLE, array('var_name' => $var_name));    
        unset($this->data[$var_name]);
    }    
}
?>