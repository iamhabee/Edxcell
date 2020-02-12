<?php if ( !defined('BASEPATH') ) {
    exit('No direct script access allowed');
}

    class Note extends Admin_Controller
    {
        /*
        | -----------------------------------------------------
        | PRODUCT NAME: 	INILABS SCHOOL MANAGEMENT SYSTEM
        | -----------------------------------------------------
        | AUTHOR:			INILABS TEAM
        | -----------------------------------------------------
        | EMAIL:			info@inilabs.net
        | -----------------------------------------------------
        | COPYRIGHT:		RESERVED BY INILABS IT
        | -----------------------------------------------------
        | WEBSITE:			http://inilabs.net
        | -----------------------------------------------------
        */
        public $notdeleteArray = [1];

        public function __construct()
        {
            parent::__construct();
            $this->load->model("Note_m");
        		$this->load->model("section_m");
        		$this->load->model("subject_m");
            $this->load->library('updatechecker');
            $this->data['notdeleteArray'] = $this->notdeleteArray;
            $language = $this->session->userdata('lang');
            $this->lang->load('note', $language);
        }

        public function index()
        {
            $subject = array();
            $this->data['notes']   = $this->Note_m->get_order_by_note();
            foreach ($this->data['notes'] as $key) {
              // $subjectID[$key->id] = $key->subjectID;
              $subject[$key->id]  = $this->subject_m->get_order_by_subject(['subjectID'=> $key->subjectID]);

            }
            // echo "<pre>";
            // var_dump($subject);
            // echo "</pre>";

            $this->data['subjects'] = $subject;
            $this->data["subview"] = "Note/index";
            $this->load->view('_layout_main', $this->data);
        }

        // public function add()
        // {
        //     $this->data['headerassets'] = [
        //         'css' => [
        //             'assets/datepicker/datepicker.css',
        //             'assets/select2/css/select2.css',
        //             'assets/select2/css/select2-bootstrap.css'
        //         ],
        //         'js'  => [
        //             'assets/datepicker/datepicker.js',
        //             'assets/select2/select2.js'
        //         ]
        //     ];
        //     if ( $_POST ) {
        //         $rules = $this->rules();
        //         $this->form_validation->set_rules($rules);
        //         if ( $this->form_validation->run() == false ) {
        //             $this->data['form_validation'] = validation_errors();
        //             $this->data["subview"]         = "Note/add";
        //             $this->load->view('_layout_main', $this->data);
        //         } else {
        //             if ( config_item('demo') == false ) {
        //                 $updateValidation = $this->updatechecker->verifyValidUser();
        //                 if ( $updateValidation->status == false ) {
        //                     $this->session->set_flashdata('error', $updateValidation->message);
        //                     redirect(base_url('Note/add'));
        //                 }
        //             }
        //
        //             $array["description"] = $this->input->post("description");
        //             $array["date"] = date("Y-m-d", strtotime($this->input->post("date")));
        //             $array["topic"] = $this->input->post("topic");
        //             $array["subject"] = $this->input->post("subject");
        //             $array["class"] = $this->input->post("class");
        //             $array["uid"] = $this->input->post("uid");
        //
        //             $this->Note_m->insert_Note($array);
        //             $this->session->set_flashdata('success', $this->lang->line('menu_success'));
        //             redirect(base_url("Note/index"));
        //         }
        //     } else {
        //         $this->data["subview"] = "Note/add";
        //         $this->load->view('_layout_main', $this->data);
        //     }
        // }

        public function add() {
          if(($this->data['siteinfos']->school_year == $this->session->userdata('defaultschoolyearID')) || ($this->session->userdata('usertypeID') == 1)) {
            $this->data['headerassets'] = array(
              'css' => array(
                'assets/datepicker/datepicker.css',
                'assets/select2/css/select2.css',
                'assets/select2/css/select2-bootstrap.css'
              ),
              'js' => array(
                'assets/datepicker/datepicker.js',
                'assets/select2/select2.js'
              )
            );

            $this->data['classes'] = $this->classes_m->get_classes();
            $classesID = $this->input->post("classesID");

            if($classesID != 0) {
              $this->data['subjects'] = $this->subject_m->general_get_order_by_subject(array('classesID' => $classesID));
              $this->data['sections'] = $this->section_m->general_get_order_by_section(array("classesID" => $classesID));
            } else {
              $this->data['subjects'] = [];
              $this->data['sections'] = [];
            }

            if($_POST) {
              $rules = $this->rules();
              $this->form_validation->set_rules($rules);
              if ($this->form_validation->run() == FALSE) {
                $this->data["subview"] = "note/add";
                $this->load->view('_layout_main', $this->data);
              } else {
                $array = array(
                  "title" => $this->input->post("title"),
                  "description" => $this->input->post("description"),
                  "createdDate" => date("Y-m-d"),
                  'subjectID' => $this->input->post('subjectID'),
                  "usertypeID" => $this->session->userdata('usertypeID'),
                  "userID" => $this->session->userdata('loginuserID'),
                  "classesID" => $this->input->post("classesID"),
                  "schoolyearID" => $this->session->userdata('defaultschoolyearID'),
                  // 'assignusertypeID' => 0,
                  // 'assignuserID' => 0
                );

                // $array['originalfile'] = $this->upload_data['file']['original_file_name'];
                // $array['file'] = $this->upload_data['file']['file_name'];
                $array['sectionID'] = json_encode($this->input->post('sectionID'));

                $this->Note_m->insert_note($array);
                $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                redirect(base_url("note/index"));
              }
            } else {
              $this->data["subview"] = "note/add";
              $this->load->view('_layout_main', $this->data);
            }
          } else {
            $this->data["subview"] = "error";
            $this->load->view('_layout_main', $this->data);
          }
        }

        // public function add_note_cat()
        // {
        //     $this->data['headerassets'] = [
        //         'css' => [
        //             'assets/datepicker/datepicker.css',
        //             'assets/select2/css/select2.css',
        //             'assets/select2/css/select2-bootstrap.css'
        //         ],
        //         'js'  => [
        //             'assets/datepicker/datepicker.js',
        //             'assets/select2/select2.js'
        //         ]
        //     ];
        //     if ( $_POST ) {
        //         $rules = $this->rules();
        //         $this->form_validation->set_rules($rules);
        //         if ( $this->form_validation->run() == false ) {
        //             $this->data['form_validation'] = validation_errors();
        //             $this->data["subview"]         = "Note/add";
        //             $this->load->view('_layout_main', $this->data);
        //         } else {
        //             if ( config_item('demo') == false ) {
        //                 $updateValidation = $this->updatechecker->verifyValidUser();
        //                 if ( $updateValidation->status == false ) {
        //                     $this->session->set_flashdata('error', $updateValidation->message);
        //                     redirect(base_url('Note/add'));
        //                 }
        //             }
        //
        //             $array["description"] = $this->input->post("description");
        //             $array["date"] = date("Y-m-d", strtotime($this->input->post("date")));
        //             $array["topic"] = $this->input->post("topic");
        //             $array["subject"] = $this->input->post("subject");
        //             $array["class"] = $this->input->post("class");
        //             $array["uid"] = $this->input->post("uid");
        //
        //             $this->Note_m->insert_Note($array);
        //             $this->session->set_flashdata('success', $this->lang->line('menu_success'));
        //             redirect(base_url("Note/index"));
        //         }
        //     } else {
        //         $this->data["subview"] = "Note/add_note_cat";
        //         $this->load->view('_layout_main', $this->data);
        //     }
        // }

        // protected function rules()
        // {
        //     $rules = [
        //         [
        //             'field' => 'description',
        //             'label' => $this->lang->line("description"),
        //             'rules' => 'trim|required|xss_clean|max_length[60]|callback_unique_exam'
        //         ],
        //         [
        //             'field' => 'date',
        //             'label' => $this->lang->line("exam_date"),
        //             'rules' => 'trim|required|max_length[10]|xss_clean|callback_date_valid'
        //         ],
        //         [
        //             'field' => 'subject',
        //             'label' => $this->lang->line("subject"),
        //             'rules' => 'trim|required|max_length[50]|xss_clean'
        //         ],
        //         [
        //             'field' => 'topic',
        //             'label' => $this->lang->line("topic"),
        //             'rules' => 'trim|required|max_length[50]|xss_clean'
        //         ]
        //     ];
        //     return $rules;
        // }

        protected function rules() {
          $rules = array(
            array(
              'field' => 'title',
              'label' => $this->lang->line("note_title"),
              'rules' => 'trim|required|xss_clean|max_length[128]'
            ),
            array(
              'field' => 'description',
              'label' => $this->lang->line("note_description"),
              'rules' => 'trim|required|xss_clean'
            ),
            array(
              'field' => 'classesID',
              'label' => $this->lang->line("note_classes"),
              'rules' => 'trim|required|numeric|max_length[11]|xss_clean|callback_unique_classes'
            ),
            array(
              'field' => 'subjectID',
              'label' => $this->lang->line("note_subject"),
              'rules' => 'trim|required|numeric|max_length[11]|xss_clean|callback_unique_subject'
            ),
            array(
              'field' => 'sectionID',
              'label' => $this->lang->line("note_section"),
              'rules' => 'xss_clean|callback_unique_section'
            ),
            // array(
            //   'field' => 'file',
            //   'label' => $this->lang->line("note_file"),
            //   'rules' => 'trim|max_length[512]|xss_clean|callback_fileupload'
            // )
          );
          return $rules;
        }
        public function edit()
        {
            $this->data['headerassets'] = [
                'css' => [
                    'assets/datepicker/datepicker.css',
                    'assets/select2/css/select2.css',
                    'assets/select2/css/select2-bootstrap.css'
                ],
                'js'  => [
                    'assets/datepicker/datepicker.js',
                    'assets/select2/select2.js'
                ]
            ];

            $id = htmlentities(escapeString($this->uri->segment(3)));
            if ( (int) $id ) {
                $this->data['note'] = $this->note_m->get_note($id);
                if ( $this->data['note'] ) {
                    if ( $_POST ) {
                        $rules = $this->rules();
                        $this->form_validation->set_rules($rules);
                        if ( $this->form_validation->run() == false ) {
                            $this->data["subview"] = "Note/edit";
                            $this->load->view('_layout_main', $this->data);
                        } else {
                            $array["exam"] = $this->input->post("exam");
                            $array["date"] = date("Y-m-d", strtotime($this->input->post("date")));
                            $array["note"] = $this->input->post("note");

                            $this->exam_m->update_exam($array, $examID);
                            $this->session->set_flashdata('success', $this->lang->line('menu_success'));
                            redirect(base_url("exam/index"));
                        }
                    } else {
                        $this->data["subview"] = "exam/edit";
                        $this->load->view('_layout_main', $this->data);
                    }
                } else {
                    $this->data["subview"] = "error";
                    $this->load->view('_layout_main', $this->data);
                }
            } else {
                $this->data["subview"] = "error";
                $this->load->view('_layout_main', $this->data);
            }

        }

	public function delete() {
		$examID = htmlentities(escapeString($this->uri->segment(3)));
		if((int)$examID && !in_array($examID, $this->notdeleteArray)) {
			$this->exam_m->delete_exam($examID);
			$this->session->set_flashdata('success', $this->lang->line('menu_success'));
			redirect(base_url("exam/index"));
		} else {
			redirect(base_url("exam/index"));
		}
	}

        // public function unique_exam()
        // {
        //     $examID = htmlentities(escapeString($this->uri->segment(3)));
        //     if ( (int) $examID ) {
        //         $exam = $this->exam_m->get_order_by_exam([ 'examID' => $examID, 'examID !=' => $examID ]);
        //         if ( count($exam) ) {
        //             $this->form_validation->set_message("unique_exam", "The %s already exists");
        //             return false;
        //         }
        //     } else {
        //         $exam = $this->exam_m->get_order_by_exam([ 'examID' => $examID ]);
        //         if ( count($exam) ) {
        //             $this->form_validation->set_message("unique_exam", "The %s already exists");
        //             return false;
        //         }
        //     }
        //     return true;
        // }

        public function date_valid( $date )
        {
            if ( strlen($date) < 10 ) {
                $this->form_validation->set_message("date_valid", "The %s is not valid dd-mm-yyyy");
                return false;
            } else {
                $arr  = explode("-", $date);
                $dd   = $arr[0];
                $mm   = $arr[1];
                $yyyy = $arr[2];
                if ( checkdate($mm, $dd, $yyyy) ) {
                    return true;
                } else {
                    $this->form_validation->set_message("date_valid", "The %s is not valid dd-mm-yyyy");
                    return false;
                }
            }

        }

        public function unique_data( $data )
        {
            if ( $data != '' ) {
                if ( $data == '0' ) {
                    $this->form_validation->set_message('unique_data', 'The %s field is required.');
                    return false;
                }
            }
            return true;
        }

        public function unique_subject() {
      		if($this->input->post('subjectID') == 0) {
      			$this->form_validation->set_message("unique_subject", "The %s field is required");
      	     	return FALSE;
      		}
      		return TRUE;
      	}

        public function unique_classes() {
      		if($this->input->post('classesID') == 0) {
      			$this->form_validation->set_message("unique_classes", "The %s field is required");
      	     	return FALSE;
      		}
      		return TRUE;
      	}

      	public function unique_section() {
      		$count = 0;
      		$sections = $this->input->post('sectionID');
      		$classesID = $this->input->post('classesID');
      		if(count($sections) && $sections != FALSE && $classesID) {
      			foreach($sections as $sectionkey => $section) {
      				$setSection = $section;
      				$getDBSection = $this->section_m->general_get_single_section(array('sectionID' => $section, 'classesID' => $classesID));
      				if(!count($getDBSection)) {
      					$count++;
      				}
      			}
            if($count == 0) {
            				return TRUE;
            			} else {
            				$this->form_validation->set_message("unique_section", "The %s is not match in class");
            	     		return FALSE;
            			}
            		}
            		return TRUE;
            	}
    }
