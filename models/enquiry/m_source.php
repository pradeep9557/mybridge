<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m_source
 *
 * @author Anup kumar
 */
class m_source extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    
    public function AddSource($FormData)
    {
                  
        return $this->db->insert(DB_PREFIX."e_source_mst", $FormData);
        
    }
    public function EditSource($FormData,$Src_id)
    {
        return $this->db->update(DB_PREFIX.'e_source_mst', $FormData, array('SrcId'=>$Src_id));
        
    }
    public function ShowSourceTable($branches='')
    {
        if($branches!='')          
        $this->db->where_in('esm.BranchID',$branches);          
        $this->db->select('esm.*,bm.BranchCode ,(select Src_Name from '.DB_PREFIX.'e_source_mst  where esm.Parent =SrcId) as pparent');
        $this->db->from(DB_PREFIX.'e_source_mst as esm');
        $this->db->join(DB_PREFIX.'branch_mst as bm','esm.BranchID=bm.BranchID');
        $this->db->order_by("esm.Mode_DateTime",'DESC');
        $result=  $this->db->get()->result_array();
        
        return $result;
    }
    public function showParentList($BranchID,$parent=0)
    {
        $List=array();
        $this->db->select('Src_Name,SrcId');
        $this->db->from(DB_PREFIX.'e_source_mst');
        if($BranchID!=0){
            $this->db->where(array('BranchID'=>$BranchID));
        }
        $this->db->where(array("Parent"=>$parent));
        if(!$parent)
          $List["0"] = "Select Source";
        foreach ($this->db->get()->result_array() as $SourceRow) {
         $List[$SourceRow['SrcId']]=$SourceRow['Src_Name'];   
        }
        //print_r($List);
        return $List;
        
        
    }
        public function SourceData($SrcId)
    {
       
        $this->db->select('*');
        $this->db->from(DB_PREFIX.'e_source_mst');
        $this->db->where(array('SrcId'=>$SrcId));
        return $this->db->get()->result_array()[0];
       
    }
    public function deleteSource($SrcId)
    {
         if($this->db->delete(DB_PREFIX."e_source_mst", array('SrcId'=>$SrcId))){
          return array(TRUE,"Deleted Successfully !!");              
        }else{
          return array(FALSE,"Error while Deleting !!");
        }
    }
    //put your code here
    
}
