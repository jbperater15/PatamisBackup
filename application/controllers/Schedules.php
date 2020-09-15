<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Schedules extends CI_Controller {
    
    function __construct(){ 
        parent::__construct(); 
        $this->load->model('roles_model');
        $this->load->model('schedules_model');        
    } 
     
    public function index(){
        $this->load->view('layout/header');
        $this->load->view('schedules/calendar.php');
        $this->load->view('schedules/sched_ins_modal.php');
        $this->load->view('layout/footer');
    }

    function load_event(){
        $event_data = $this->schedules_model->fetch_all_schedule_event();
          foreach($event_data->result_array() as $row)
          {
           $data[] = array(
            'id'    => $row['eval_sched_id'],
            'title' => $row['evaluation_title'],
            'start' => $row['date'].'T'.$row['time_start'],
            'end'   =>  $row['date'].'T'.$row['time_end']
           );
          } 
        echo json_encode($data);
    }

    public function evaluation_schedule_insert() {
      $evaluation_title=$this->input->post('evaluation_title');
      $date=$this->input->post('date');
      $time_start=$this->input->post('time_start');
      $time_end=$this->input->post('time_end');
      $creation_date = date('Y-m-d H-i-s');
      $data = array(
        'eval_sched_id'     =>NUll,
          'evaluation_title'=>$evaluation_title,
          'project_id'      => '0',
          'date'            =>$date,
          'time_start'      =>$time_start,
          'time_end'        =>$time_end,
          'created_by'      => '0',
          'creation_date'   => $creation_date,
          'updated_by'      => '0',
          'update_date'     => '0'
      );
      $this->schedules_model->evaluation_schedule_insert($data);
      redirect('Schedules/index');
    }

    function update_event(){
      $evaluation_id=$this->input->post('evaluation_id');
      $evaluation_title=$this->input->post('evaluation_title');
      $date=$this->input->post('date');
      $time_start=$this->input->post('time_start');
      $time_end=$this->input->post('time_end');
      $update_date = date('Y-m-d H-i-s');
      $data = array(
        //'eval_sched_id'      =>NUll,
          'evaluation_title'   =>$evaluation_title,
          //'project_id'       => '0',
          'date'               =>$date,
          'time_start'         =>$time_start,
          'time_end'           =>$time_end,
          //'created_by'       => '0',
          //'creation_date'    => $creation_date,
          //'updated_by'       => '0',
          'update_date'        => $update_date
      );
      $this->schedules_model->update_event($evaluation_id,$data);
      redirect('Schedules/index');
    }

    function delete_event(){
      $id=$this->input->get('id');
      $this->schedules_model->delete_event($id);
      redirect('Schedules/index');
    }

    
}