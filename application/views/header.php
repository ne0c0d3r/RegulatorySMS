<!DOCTYPE html>
<!-- saved from url=(0076) -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php 
    $sms_name = '';
    if ($this->session->userdata('sms_logged_in')) {
        $sms_name = '/ ' . $this->session->userdata('sms_name');
    } ?>
    <title>Regulatory-SMS <?php echo $sms_name; ?> </title>
    <link rel="icon" href="<?php echo base_url() ?>resources/images/logo_green.ico">

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url() ?>css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu  -->
    <link href="<?php echo base_url() ?>css/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="<?php echo base_url() ?>css/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url() ?>css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="<?php echo base_url() ?>css/morris.css" rel="stylesheet">

    <!-- Loading CSS -->
    <link href="<?php echo base_url() ?>css/jquery-loading.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="<?php echo base_url() ?>css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/custom-style.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/magnific-popup.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/bootstrap-multiselect.css" rel="stylesheet" type="text/css">
    <link href="<?php echo base_url() ?>css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css">
    
    <link href="<?php echo base_url() ?>css/daterangepicker.css" rel="stylesheet" type="text/css">
    <script type="text/javascript">
        var full_url = "<?php echo base_url() ?>";
        var base_url = "<?php echo base_url() ?>";
        <?php if (isset($_SESSION['pis_domainName'])) { ?>
            var pis_domainName = "<?php echo $_SESSION['pis_domainName'] ?>";
        <?php } ?>
    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- plugins -->
    <script src="<?php echo base_url() ?>js/plugin/jscolor.js"></script>

</head>

<body>

    <!-- modal for reports/forms -->
    <div class="modal fade modal-report" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header std-bg-color">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h5 class="modal-title"><span class="fa fa-pie-chart"></span> <span class="title-text">Reports</span></h5>
          </div>
          <div class="modal-body font8 rmv-all-padding ">
            <div id="report-panel"></div>

          </div>
          <div class="modal-footer">
              <!-- <button type="button" class="btn btn-default btn-xs" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Close</button> -->
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div>

    <div id="wrapper">