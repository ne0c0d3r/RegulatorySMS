        <form action="<?php echo base_url() ?>reports/export_sla_to_csv" method="post" target="_blank">
            <table class="table table-default rmv-all-margin">
                <tr>
                    <td>
                        <label>From date</label>
                        <input class="form-control input-sm datepicker" data-target="txticftodate" data-ref="1" id="txticffromdate" name="txticffromdate">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>To date</label>
                        <input class="form-control input-sm datepicker" data-target="txticffromdate" data-ref="2" id="txticftodate" name="txticftodate">
                    </td>
                </tr>
                <tr>
                    <td>
                        <span class=" pull-right">
                            <button class="btn btn-default btn-xs reload-page" data-dismiss="modal" aria-label="Close"><span class="fa fa-ban"></span> Cancel</button>
                            <button type="submit" class="btn btn-primary btn-xs" id="generateSla"><span class="fa fa-retweet"></span> Generate</button>
                        </span>
                    </td>
                </tr>
            </table>
        </form>
            <script type="text/javascript">
              $(function () {

                $.getScript('<?php echo base_url() ?>js/daterangepicker.js', function(){});

                $('body').on('change', '.datepicker', function(){
                    var id = $(this).attr('id');
                    var e = $(this).data('target');
                    var ref = $(this).data('ref');
                    if (ref == 1) {
                        if (new Date($(this).val()) > new Date($('#' + e).val())) {
                            $('#' + e).val($(this).val());
                            $('#' + id).focusout();
                            $('#' + e).focus();
                        }
                    } else if (ref == 2) {
                        if (new Date($('#' + e).val()) > new Date($(this).val())) {
                            $('#' + e).val($(this).val());
                            $('#' + id).focusout();
                            $('#' + e).focus();
                        }
                    }
                });
                $('.datepicker').daterangepicker({
                  singleDatePicker: true,
                  showDropdowns: false,
                   "drops": "down"
                });


                //$('.timepicker').timepicker();
              });
            </script>
            <script src="<?php echo base_url() ?>js/daterangepicker.js"></script>
