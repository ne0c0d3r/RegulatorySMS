        <?php 
          $message = $this->session->flashdata('message');
          $alerttype = $this->session->flashdata('alerttype');
          $get = $this->input->get();
          //print_r($get);
          $isAdminMode = false;
          if (count($get) > 0) {
            if ($get['level'] == 'admin') {
              $isAdminMode = false;
            }
          }
        ?>
        <div class="rmv-all-padding rmv-all-margin">
          <div class="row rmv-all-padding rmv-all-margin std-bg-linear-grad">
            <div class="col-md-12 " style="height: 50px !important">
              
            </div>

            <div class="col-md-1 col-sm-1">
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12" style="background: white;min-height: 60px !important">
              <a class="navbar-brand color-white logo_green" href="<?php echo base_url() ?>">
                </a>
            </div>
            <div class="col-md-8 col-sm-5">
            </div>
          </div>

          <div class="row rmv-all-margin mid-row" style="box-shadow: 10px 10px 5px #888888;">
            <div class="col-md-1 col-sm-1" style="height: 100% !important">
            </div>
            <div class="col-sm-12 col-xs-12 to-show">
              <h4>Service Management System for Regulatory Department</h4>
              Development Server
              <br>
              <br>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12" >
              <?php if (!$isAdminMode) { ?>
                
              <h4 class="form-signin-heading">Please Sign-in </h4>
              <?php echo form_open('login/authenticate') ?>
                <div class="alert-wrapper col-md-12 col-xs-12 ">
                  <div class="col-md-offset-5 col-xs-offset-3">
                    <div class="col-md"></div>
                    <div class="alert <?php echo $alerttype ?> text-center <?php echo (isset($message)) ? '' : 'alert-hide' ?> padding5 font8 col-md-4 " style="margin: 0 auto;">
                      <button type="button" class="close font10" data-dismiss="alert">&times;</button>
                      <?php echo $message ?>
                    </div>
                  </div>
                </div>
                

                <div class="input-group margin3">
                  <span class="input-group-addon" id="basic-addon1" style="">
                    <!-- <span class="fa fa-user text-success"></span> -->
                    <span class="glyphicon glyphicon-user glyphicon text-success"></span>
                  </span>
                  <input type="text" name="username" id="username" class="form-control input-sm" placeholder="Username" aria-describedby="basic-addon1" required autofocus autocomplete="off">
                </div>

                <div class="input-group margin3">
                  <span class="input-group-addon" id="basic-addon1">
                    <span class="fa fa-key text-success"></span>
                  </span>
                  <input type="password" name="password" id="password" class="form-control input-sm" placeholder="Password" aria-describedby="basic-addon1" required autocomplete="off">
                </div>

                <div class="input-group margin3">
                  <span class="input-group-addon" id="basic-addon1">
                    <span class="text-success">@</span>
                  </span>
                    <select class="form-control input-sm " name="domain_name" id="domain_name">
                      <option value="globalpower.com.ph">globalpower.com.ph</option>
                      <option value="cebu.globalpower.com.ph">cebu.globalpower.com.ph</option>
                      <option value="toledo.globalpower.com.ph">toledo.globalpower.com.ph</option>
                      <option value="panaypower.globalpower.com.ph">panaypower.globalpower.com.ph</option>
                    </select>
                </div>
                <br>
                <button class="btn btn-xs btn-primary margin3 pull-right submit-btn" type="submit">
                  Sign-in
                  <span class="glyphicon glyphicon-log-in"></span>&nbsp;
                </button>
              </form>
              <?php } else { ?>
                <br>
                <br>
                <br>
                <center>
                Sorry for inconvenience, Regulatory SMS is under maintenance.<br>
                Duration : 1PM to 6PM, 10/10/2019<br>
                Implementaion of RFC 2019-039
                </center>
              <?php } ?>
            </div>          
            <div class="col-md-4 col-sm-5 to-hide">
              <h3>Service Management System for Regulatory Affairs Department</h3>
              Development Server
            </div>
            <div class="col-md-4 col-sm-5 to-hide">
              <span class=" sms_logo"></span>
            </div>
          </div>

          <div class="row rmv-all-padding rmv-all-margin light-bg-linear-grad" style="height: 300px !important">

            <div class="col-md-1 col-sm-1" style="">
              
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12 to-hide" style="background: white;height: 50px !important;">
              
            </div>
            <div class="col-md-8 col-sm-5" style="">
              
            </div>
            <div class="col-md-12 ">
              
            </div>
          </div>
        </div>
        

