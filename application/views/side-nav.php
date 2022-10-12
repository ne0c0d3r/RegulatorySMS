            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav in font8" id="side-menu">
                        <li class="sidebar-search">

                            <div class="">
                                <center>
                                <!-- <img src="<?php echo base_url() ?>resources/images/female-icon.png" height="60" > -->
                                <?php
                                $imageUrl = @get_headers('http://pis.globalpower.com.ph/uploads/EmployeePhoto/' . $_SESSION['sms_userid'] . '.jpg');
                                //var_dump($imageUrl);
                                //echo $imageUrl[0];
                                if ($imageUrl[0] == 'HTTP/1.1 404 Not Found') { ?>
                                    <div class="<?php echo (strtoupper($_SESSION['sms_gender']) == 'MALE')? 'male-avatar':'' ?> img-circle" ></div>
                                    <div class="<?php echo (strtoupper($_SESSION['sms_gender']) == 'FEMALE')? 'female-avatar':'' ?> img-circle" ></div>
                                    <div class="<?php echo (strtoupper($_SESSION['sms_gender']) == '')? 'male-avatar':'' ?> img-circle" ></div>
                                <?php } else { ?>
                                    <img src="http://pis.globalpower.com.ph/uploads/EmployeePhoto/<?php echo $_SESSION['sms_userid'] ?>.jpg" width="60" >
                                <?php
                                }

                                ?>

                                <br>
                                <!-- <span class="text-danger">You are signed in as </span><br> -->
                                <span class="text-success bold-text font8"><?php echo $_SESSION['sms_userid'] . ' / ' . $_SESSION['pis_domainName'] ?></span><br>
                                <span class="text-muted font9"><?php echo $_SESSION['sms_name'] ?></span><br>
                                <span class="text-primary bold-text font9"><?php echo $_SESSION['sms_userlvl'] ?></span><br>

                                <?php
                                $empAssgined = $this->db->query("select * from employee_assign where employeeId = '" . $this->session->userdata('sms_userid') . "'")->result();
                                /*var_dump($empAssgined);*/
                                if (count($empAssgined) > 1) { ?>
                                    <span class="text-danger bold-text">Switch as: </span> 
                                    <?php
                                    foreach ($empAssgined as $empAssginedList) { 
                                        if ($this->session->userdata('sms_userlvl') != $empAssginedList->assignment) {
                                        ?>
                                        <a href="<?php echo base_url() ?>login/switchLevel/<?php echo $empAssginedList->assignment ?>" class="text-warning">[<?php echo $empAssginedList->assignment ?>] </a>
                                        <?php
                                        }
                                    }
                                }

                                if ($this->session->userdata('sms_userlvl') == 'Administrator') { ?>
                                    <select class="form-control input-sm toolbar-text text-center" id="viewAsUser">
                                        <option>- View as -</option>
                                        <?php 
                                        if (isset($empData)) {
                                            foreach ($empData as $assignList) { ?>
                                                <option value="<?php echo $assignList->domainName ?>">
                                                  <?php 
                                                    echo $assignList->lastName . ', ' . $assignList->firstName . ' ' . $assignList->middleName;
                                                  ?>
                                                </option>
                                            <?php } 
                                        } ?>
                                    </select>    
                                <?php 
                                }


                                ?>
                                <hr width="95%" class="rmv-all-margin" style="color: red">
                                <br>
                                <a href="<?php echo base_url() ?>logout" class="btn btn-danger btn-xs submit-btn">
                                    <span class="color-white">
                                        <span class="glyphicon glyphicon-log-out"></span>
                                        Logout
                                    </span>
                                </a>
                                </center>
                                
                            </div>
                            <!-- /input-group -->
                        </li>
                        <?php if ($_SESSION['sms_userlvl'] != 'User') { ?>
                        <li>
                            <a href="<?php echo base_url() ?>dashboard"><i class="fa fa-tachometer text-info"></i> Dashboard</a>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo base_url() ?>"><i class="glyphicon glyphicon-inbox text-info"></i> My Ticket <span class="badge pull-right text-info" id="forActionCount"></span></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>employee"><i class="fa fa-user text-info"></i> Employees</a>
                        </li>
                        <?php if ($_SESSION['sms_userlvl'] == 'Dispatcher' || $_SESSION['sms_userlvl'] == 'Administrator') { ?>
                        <li>
                            <a href="<?php echo base_url() ?>services"><i class="glyphicon glyphicon-tasks text-info"></i> Services</a>
                        </li>
                        <?php } ?>
                        <?php if ($_SESSION['sms_userlvl'] == 'Administrator' || $_SESSION['sms_userlvl'] == 'Dispatcher') { ?>
                        <li>
                            <a href="#"><i class="fa fa-gears text-info"></i> Settings<span class="glyphicon glyphicon-triangle-bottom pull-right"></span></a>
                            <ul class="nav nav-second-level collapse">
<!--                                 <li>
                                    <a href="<?php echo base_url() ?>#"><span class="glyphicon glyphicon-tag"></span>&nbsp;Category</a>
                                </li> -->
                                <li>
                                    <a href="<?php echo base_url() ?>site"><span class="glyphicon glyphicon-map-marker text-info"></span> Site</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>department"><span class="fa fa-group text-info"></span> Department</a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url() ?>position"><span class="glyphicon glyphicon-briefcase text-info"></span> Position</a>
                                </li>
                                    <li>
                                        <a href="<?php echo base_url() ?>status"><span class="glyphicon glyphicon-stats text-info"></span> Status</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() ?>employee_assign"><span class="glyphicon glyphicon-list-alt text-info"></span> Employee Assignment</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() ?>requesttype"><span class="glyphicon glyphicon-scale text-info"></span> Request Type</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() ?>holiday"><span class="glyphicon glyphicon-bookmark text-info"></span> Holiday</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url() ?>icf"><span class="fa fa-question text-info"></span> Feedback Questions</a>
                                    </li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php } ?>
                        <?php if ($_SESSION['sms_userlvl'] != 'User') { ?>
                        <li>
                            <a href="<?php echo base_url() ?>reports"><span class="fa fa-file-text text-info"></span> Reports</a>
                        </li>     
                        <?php } ?>                       
                        <?php if ($_SESSION['sms_userlvl'] == 'Administrator') { ?>              
                        <li>
                            <a href="<?php echo base_url() ?>logs"><i class="glyphicon glyphicon-list text-info"></i> Logs</a>
                        </li>
                        <?php } ?>
                        <li>
                            <a href="<?php echo base_url() ?>help"><i class="glyphicon glyphicon-question-sign text-info"></i> Help</a>
                        </li>
                    </ul>
                    <!-- <div class="sidenav-footer text-info to-hide"> -->
                    <div class="sidenav-footer text-info to-hide">
                        <br>
                        <span>Help us improve Regulatory Service Management System by sending your comments to <u>GPMISSysDev@globalpower.com.ph</u></span>
                    </div>
                </div>
                <!-- /.sidebar-collapse -->


            </div>
            <!-- /.navbar-static-side -->