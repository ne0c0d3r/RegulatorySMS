<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Mod_syncEmpData extends CI_Model{
	
	public function __construct(){
		parent::__construct();
		
	}


	public function syncThisEmployee($spec_userid = '') {
		$sms_userid = $spec_userid;
		if ($spec_userid == '') {
			$sms_userid = $_SESSION['sms_userid'];
		}
		$pisData = $this->_getPisData($sms_userid);
		$isSync = $this->_updateSmsData($pisData, $sms_userid);
	}

	/*public function syncThisEmployee() {
		$sms_userid = $_SESSION['sms_userid'];
		$pisData = $this->_getPisData($sms_userid);
		$isSync = $this->_updateSmsData($pisData, $sms_userid);
	}*/

	private function _getPisData($sms_userid) {
		$pis = $this->load->database("pis", true);
		$result = $pis->query("select * from employee where employeeId = '$sms_userid'")->row();
		return $result;
	}

	private function _updateSmsData($data, $sms_userid) {
		//var_dump($data);
		$isExist = $this->db->query("select * from sms_users where employeeId = '$sms_userid'")->result();
		if (count($isExist)) {
			// insert new record
			$return = $this->db->query("UPDATE sms_users SET 
				employeeId='$data->employeeId',firstName='$data->firstName',middleName='$data->middleName',lastName='$data->lastName',
					nameExt='$data->nameExt',organizationShortName='$data->organizationShortName',siteGroupName='$data->siteGroupName',companyShortName='$data->companyShortName',
						plantSiteName='$data->plantSiteName',divisionName='$data->divisionName',groupName='$data->groupName',departmentShortName='$data->departmentShortName',
							sectionName='$data->sectionName',positionName='$data->positionName',levelShortName='$data->levelShortName',rankName='$data->rankName',
								nickName='$data->nickName',address1='$data->address1',address2='$data->address2',personalEmail='$data->personalEmail',
									telNo='$data->telNo',mobileNo='$data->mobileNo',birthDate='$data->birthDate',birthPlace='$data->birthPlace',
										gender='$data->gender',nationality='$data->nationality',religion='$data->religion',civilStatus='$data->civilStatus',
											taxStatus='$data->taxStatus',blood='$data->blood',dateHired='$data->dateHired',dateRegularization='$data->dateRegularization',
												tin='$data->tin',sss='$data->sss',pagibig='$data->pagibig',philhealth='$data->philhealth',
													passport='$data->passport',driverLicense='$data->driverLicense',domainName='$data->domainName',photo='$data->photo',
														empStatus='$data->status',companyEmail='$data->companyEmail',companyMobile='$data->companyMobile',local='$data->local',
															isImmediate='$data->superior' where employeeId = '$sms_userid'");			
			return $return;
		} else {
			// update existing record
			$isRemove = $this->db->query("delete from sms_users where employeeId = '$sms_userid'");
			if ($isRemove) {
				$return = $this->db->query("INSERT INTO sms_users (employeeCode, employeeId, firstName, middleName, 
						lastName, nameExt, organizationShortName, siteGroupName, 
							companyShortName, plantSiteName, divisionName, groupName, 
								departmentShortName, sectionName, positionName, levelShortName, 
									rankName, nickName, address1, address2, 
										personalEmail, telNo, mobileNo, birthDate, 
											birthPlace, gender, nationality, religion, 
												civilStatus, taxStatus, blood, dateHired, 
													dateRegularization, tin, sss, pagibig, 
														philhealth, passport, driverLicense, domainName, 
															photo, empStatus, companyEmail, companyMobile, 
																local, isImmediate) VALUES 
					(NULL, '$data->employeeId', '$data->firstName', '$data->middleName', 
						'$data->lastName', '$data->nameExt', '$data->organizationShortName', '$data->siteGroupName', 
							'$data->companyShortName', '$data->plantSiteName', '$data->divisionName', '$data->groupName', 
								'$data->departmentShortName', '$data->sectionName', '$data->positionName', '$data->levelShortName', 
									'$data->rankName', '$data->nickName', '$data->address1', '$data->address2', 
										'$data->personalEmail', '$data->telNo', '$data->mobileNo', '$data->birthDate', 
											'$data->birthPlace', '$data->gender', '$data->nationality', '$data->religion', 
												'$data->civilStatus', '$data->taxStatus', '$data->blood', '$data->dateHired', 
													'$data->dateRegularization', '$data->tin', '$data->sss', '$data->pagibig', 
														'$data->philhealth', '$data->passport', '$data->driverLicense', '$data->domainName', 
															'$data->photo', '$data->status', '$data->companyEmail', '$data->companyMobile', 
																'$data->local', '$data->superior')");
				return $return;
			}
			return false;
		}
		return false;
	}
}






