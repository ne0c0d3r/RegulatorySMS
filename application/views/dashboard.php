
        <link rel="stylesheet" href="<?php echo base_url() ?>css/morris.css">
        <script src="<?php echo base_url() ?>js/jquery.min.js"></script>

        <div id="page-wrapper" style="min-height: 582px;">
            <div class="row" >

                <div class="col-md-6 rmv-all-padding">
                    <div class="panel panel-success font8">
                        <div class="panel-heading" style="height:55px;">
                            <i class="fa fa-line-chart"></i> Tickets per Day    
                            <span class="pull-right">
                                <input type="text" name="daterange" class="form-control pull-right" />
                            </span>
                            <script>
                            $(document).ready(function(){
                                $('input[name="daterange"]').daterangepicker({
                                    opens: 'left'
                                }, function(start, end, label) {
                                    initMorris(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'));
                                });
                            });
                            </script>
                        </div>
                        <div class="panel-body">
                            <div id="morris-area-chart"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 rmv-all-padding">
                    <div class="panel panel-warning font8">
                        <div class="panel-heading">
                            <i class="fa fa-line-chart"></i> Status 
                        </div>
                        <div class="panel-body">
                            <div id="status-bar-chart"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 rmv-all-padding">
                    <div class="panel panel-danger font8">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart"></i> Assigned Tasks
                        </div>
                        <div class="panel-body">
                            <div id="morris-bar"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 rmv-all-padding font8">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <i class="fa fa-pie-chart"></i> Services Created
                        </div>
                        <div class="panel-body">
                            <div id="morris-donut"></div>
                        </div>
                    </div>
                </div>

            </div>

          
        </div>
        <!-- /#page-wrapper -->

