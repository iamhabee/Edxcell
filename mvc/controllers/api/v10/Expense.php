<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

class Expense extends Api_Controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('expense_m');
    }

    public function index_get() 
    {
        $schoolyearID = $this->session->userdata('defaultschoolyearID');
        $this->retdata['alluser'] = getAllUserObjectWithStudentRelationNameForApi(array('schoolyearID' => $schoolyearID));
        $this->retdata['expenses'] = $this->expense_m->get_order_by_expense(array('schoolyearID' => $schoolyearID));
        
        $this->response([
            'status'    => true,
            'message'   => 'Success',
            'data'      => $this->retdata
        ], REST_Controller::HTTP_OK);
    }
}
