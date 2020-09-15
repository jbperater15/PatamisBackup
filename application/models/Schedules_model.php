<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Schedules_model extends CI_Model 
{
	function evaluation_schedule_insert($data){
	    $this->db->insert('evaluation_schedule',$data);
	}

	function fetch_all_schedule_event(){
		$this->db->select('eval_sched_id,evaluation_title,date,time_start,time_end');
	    $this->db->order_by('eval_sched_id');
	    return $this->db->get('evaluation_schedule');
	}

	function update_event($id,$data){
		$this->db->where('eval_sched_id', $id);
 		$query = $this->db->update('evaluation_schedule',$data);
	}

	function delete_event($id){
		$this->db->where('eval_sched_id', $id);
    	$this->db->delete('evaluation_schedule');
	}
}