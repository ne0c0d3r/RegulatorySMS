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
        $this->username = $this->db->escape_str($values['username']);
        $this->password = $this->db->escape_str($values['password']);
        $this->domainname = $this->db->escape_str($values['domain_name']);
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
            if (count($query->row()) > 0) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    /*public function updatePIS(){
        $pis = $this->load->database("pis", true);
        $pisloc = $this->load->database("pisloc", true);
        $userData = $pisloc->query("select * from employee")->result();

        foreach ($userData as $userList) {
            $isUpdate = $pis->query("update employee set domainName = '" . $userList->domainName . "', email = '" . $userList->email . "' where firstName = '" . $userList->firstName . "' and lastName = '" . $userList->lastName . "' ");
            echo $isUpdate . '<br>';
        }

    }
*/
}
