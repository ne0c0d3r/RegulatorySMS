<?php

class Mod_login extends CI_Model {

    var $usertype;
    var $email;
    var $department;
    var $approver;
    var $username;
    var $domainname;
    var $password;
    var $userId;
    var $user_rule;
    var $currentUser;
    var $departmentName;
    var $employeeid;


    public function authenticate($values) {
        $this->load->database();
        $this->username = $values['username'];
        $this->password = $values['password'];
        $this->domainname = $values['domain_name'];
        $ldapconnect = $this->ldap_connect();
        if ($ldapconnect) {
            $isValidPisUser = $this->pis_authentication();
            if ($isValidPisUser) {
                return true;
            }
        }else{
            return false;
        }
    }
    
    public function ldap_connect() {
        $ldapSvr = 'maksvrdc04';
        switch ($this->domainname ) {
            case 'globalpower.com.ph':
                $ldapSvr = 'maksvrdc04';
                break;
            case 'panaypower.globalpower.com.ph':
                $ldapSvr = 'pandc1';
                break;
            case 'cebu.globalpower.com.ph':
                $ldapSvr = 'phcebdc01';
                break;
            case 'toledo.globalpower.com.ph':
                $ldapSvr = 'phtoldc02';
                break;
            
            default:
                # code...
                break;
        }

        $ad = ldap_connect("ldap://" . $ldapSvr . "." . $this->domainname)
                or die("Couldn't connect to AD!");
        ldap_set_option($ad, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($ad, LDAP_OPT_PROTOCOL_VERSION, 3);

        if($ad){
            $bd = ldap_bind($ad, $this->username . "@" . $this->domainname, $this->password);
            if ($bd) {
                return $bd;
            } else {
                return false;
            }
        }else{
            return false;
        }
    }

    private function pis_authentication(){
        $pis = $this->load->database("pis", true);
        $myquery = "SELECT * FROM `employee` WHERE domainName ='" . $this->username . "'";
        $query = $pis->query($myquery); 
        if ($query) {
            $this->getValues($query->row());
            $this->setSession($query->row());
            $this->session->set_userdata($this->user_rule);

            return true;
        } else {
            return false;
        }
    }

    private function getValues($query) {
        $this->employeeid = $query->employeeId;
        $this->email = $query->email;
        $this->departmentCode = $query->departmentCode;
        $this->departmentName = $this->getDeptName($query->departmentCode);
        $this->currentUser = $query->lastName . ', ' . $query->firstName . ' ' . $query->middleName;
    }

    private function getDeptName($dept) {
        $pis = $this->load->database("pis", true);
        $rs = $pis->query('select department.* from department where departmentCode = ' . $dept)->row();
        return $rs->departmentName;
    }

    private function setSession() {
        $this->user_rule = array(
            'username' => $this->username,
            'isloggedOnPortal' => TRUE,
            'password' => $this->password,
            'department' => $this->department,
            'usertype' => $this->usertype,
            'userId' => $this->userId,
            'email' => $this->email,
            'currentUser' => $this->currentUser,
            'employeeid' => $this->employeeid,
            'departmentName' => $this->departmentName
        );
    }

}
