<?php 
	class m_loginimg_library extends CI_Model {
 
    public function save_data($data)
    {
         
        $this->db->insert('nexgen_image_library', $data);
        return $this->db->insert_id();
    }

    public function get_files()
	{
	    return $this->db->select()->from('nexgen_image_library')->get()->result();
	}
 
}
?>