<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Employee_assign extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->Mod_session->check_session();
		$this->load->model(array('Mod_employee', 'Mod_site', 'Mod_services'));
	}

	public function index(){
		$this->load->library('util');
		$data['util'] = $this->util;

		$data['assignEmpData'] = $this->Mod_employee->listOfAssignedEemployee();
		$data['empData'] = $this->Mod_employee->getEmployee();
		$data['siteData'] = $this->Mod_site->getSites();
		$data['defServicesData'] = $this->Mod_services->getServices();

		$this->load->view('header');
		$this->load->view('navigation');
		$this->load->view('employee_assign/assignment-main.php', $data);
		$this->load->view('footer');
	}

	public function addAssignedEmployee(){
		$postData = $this->input->post();
		//print_r($postData);
		$isValid = $this->Mod_employee->validateAssignData($postData);
		if($isValid) {
			$return = $this->Mod_employee->addAssignedEmployee($postData);
			if ($return) {
				$this->session->set_flashdata(array('message' => 'Successfully added', 'alerttype' => 'alert-success'));
				redirect('employee_assign');
			}
			echo 'error';
		}
		$this->session->set_flashdata(array('message' => 'Error: Duplicate entry or service and site are not assigned', 'alerttype' => 'alert-danger'));
		redirect('employee_assign');
	}

	public function updateAssignedEmployee($assignid){
		$postData = $this->input->post();
		//print_r($postData);
		$return = $this->Mod_employee->updateAssignedEmployee($postData, $assignid);
		if ($return) {
			$this->session->set_flashdata(array('message' => 'Successfully updated', 'alerttype' => 'alert-success'));
			redirect('employee_assign');
		}
		$this->session->set_flashdata(array('message' => 'Error upon update or duplicate entry', 'alerttype' => 'alert-danger'));
		redirect('employee_assign');
	}


	public function remove_assigned($assignid){
		$return = $this->Mod_employee->remove_assigned($assignid);
		if ($return) {
			$this->session->set_flashdata(array('message' => 'Successfully deleted', 'alerttype' => 'alert-success'));
		} else {
			$this->session->set_flashdata(array('message' => 'Error deletion', 'alerttype' => 'alert-danger'));
		}
		redirect('employee_assign');
	}

	public function getMatchCounsel($servicesid, $siteid, $selected = ''){
		$this->load->library('util');
    	$empIdMatched = $this->Mod_employee->getMatchCounsel($servicesid, $siteid);
    	foreach (json_decode($empIdMatched) as $empIdMatchedList) { ?>
    		<option value='<?php echo $empIdMatchedList ?>' <?php echo ($selected == $empIdMatchedList) ? 'selected':'' ?>><?php echo $this->util->getName($empIdMatchedList) ?> </option>
    	<?php }
  	}

  	public function single_retrieve($assignid) {
  		$result = $this->Mod_employee->single_retrieve_assigned($assignid);
  		echo json_encode($result);
  	}

  	/*public function syncThisEmployee($spec_userid = ''){
  		$this->load->model('Mod_syncEmpData');
  		$this->Mod_syncEmpData->syncThisEmployee($spec_userid);
  	}*/
}