$(document).ready(function () {
    loadPagination(); //load list

    $('.txtSearchBar').keypress(function(e) {
        //$('.pagination-table').click();
        var searchStr = $(this).val();
        if(e.keyCode == 13){
            var recordLimit = $('.pagination-table').data('limit');
            var module = $('.pagination-table').data('module');
            if (module == 'position') {
                $('.paging-wrapper').empty();
                $.getJSON(full_url + 'position/getPositionSearchCount/' + decodeURIComponent(searchStr), function(e){
                    $('.paging-wrapper').append("<ul id='' class='pagination-table pagination-sm rmv-all-margin font8' data-count='" + e.return + "' data-module='position' data-limit='" + recordLimit + "'></ul>");
                    loadPagination();
                });
            } else if (module == 'ticket') {
                $('.paging-wrapper').empty();
                $.getJSON(full_url + 'ticket/getTicketSearchCount/' + decodeURIComponent(searchStr), function(e){
                     $('.paging-wrapper').append('<ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="' + e.return + '" data-module="ticket" data-limit="' + recordLimit + '"></ul>');
                    loadPagination();
                });
            } else if (module == 'employee_assign') {
                $('.paging-wrapper').empty();
                $.getJSON(full_url + 'Employee/getEmployeeSearchCount/' + decodeURIComponent(searchStr), function(e){
                     $('.paging-wrapper').append('<ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="' + e.return + '" data-module="employee_assign" data-limit="' + recordLimit + '"></ul>');
                    loadPagination();
                });
            } else if (module == 'logs') {
                $('.paging-wrapper').empty();
                $.getJSON(full_url + 'logs/getLogsCount/' + decodeURIComponent(searchStr), function(e){
                     $('.paging-wrapper').append('<ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="' + e.return + '" data-module="logs" data-limit="' + recordLimit + '"></ul>');
                    loadPagination();
                });
            } else if (module == 'help') {
                $('.paging-wrapper').empty();
                $.getJSON(full_url + 'help/getHelpCount/' + decodeURIComponent(searchStr), function(e){
                     $('.paging-wrapper').append('<ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="' + e.return + '" data-module="help" data-limit="' + recordLimit + '"></ul>');
                    loadPagination();
                });
            } else if (module == 'department') {
                $('.paging-wrapper').empty();
                $.getJSON(full_url + 'department/getDepartmentSearchCount/' + decodeURIComponent(searchStr), function(e){
                     $('.paging-wrapper').append('<ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="' + e.return + '" data-module="department" data-limit="' + recordLimit + '"></ul>');
                    loadPagination();
                });
            } else if (module == 'site') {
                $('.paging-wrapper').empty();
                $.getJSON(full_url + 'site/getSiteSearchCount/' + decodeURIComponent(searchStr), function(e){
                     $('.paging-wrapper').append('<ul id="" class="pagination-table pagination-sm rmv-all-margin font8" data-count="' + e.return + '" data-module="site" data-limit="' + recordLimit + '"></ul>');
                    loadPagination();
                });
            }
        }
    });

    // loading data and pagination
    
});

function loadPagination(){
/*        alert(getTotalpage($('.pagination-table').data('count')));
        alert($('.pagination-table').data('limit'));
        alert(getTotalpage($('.pagination-table').data('count'), $('.pagination-table').data('limit')));*/
        $('.pagination-table').twbsPagination({
            totalPages: getTotalpage($('.pagination-table').data('count'), $('.pagination-table').data('limit')),
            visiblePages: 5,
            onPageClick: function (event, page) {
                initializeView();
                var module = $('.pagination-table').data('module');
                var count = $('.pagination-table').data('count');
                var limit = $('.pagination-table').data('limit');                
                var offset = 0;
                if (page > 1) {offset = (page-1) *limit;}
                var tabId = $('.table-body').attr('id');

                $("#" + tabId).loading({
                    stoppable:true
                });

                if (module == 'position') {
                    var searchStr = $('#txtSearch').val().replace(" ","-space-");
                    var url = full_url + 'position/getPositionPerPage/' + offset + '/' + limit + '/' + searchStr;
                } else if (module == 'ticket') {
                    var searchStr = $('#txtSearch').val();
                    var url = full_url + 'ticket/getTicketPerPage/' + offset + '/' + limit + '/' + searchStr;
                } else if (module == 'employee_assign') {
                    var searchStr = $('#txtSearch').val();
                    var url = full_url + 'employee/getEmployeePerPage/' + offset + '/' + limit + '/' + searchStr;
                } else if (module == 'logs') {
                    var searchStr = $('#txtSearch').val();
                    var url = full_url + 'logs/getLogsPerPage/' + offset + '/' + limit + '/' + searchStr;
                } else if (module == 'help') {
                    var searchStr = $('#txtSearch').val();
                    var url = full_url + 'help/getHelpPerPage/' + offset + '/' + limit + '/' + searchStr;
                } else if (module == 'department') {
                    var searchStr = $('#txtSearch').val();
                    var url = full_url + 'department/getDepartmentPerPage/' + offset + '/' + limit + '/' + searchStr;
                } else if (module == 'site') {
                    var searchStr = $('#txtSearch').val();
                    var url = full_url + 'site/getSitePerPage/' + offset + '/' + limit + '/' + searchStr;
                } else if (module == 'holiday') {
                    var searchStr = "";
                    var url = full_url + 'holiday/getHolidayPerPage/' + offset + '/' + limit + '/' + searchStr;
                } else {
                    $("#" + tabId).append('invalid module');
                    var url = '';
                }

                if (url != '') {
                    $.ajax({
                        url:url,
                        type:'post',
                        success:function(data){
                            $("#" + tabId).empty();
                            $("#" + tabId).append(data);                            
                            $("#" + tabId).loading('stop');
                        }
                    });
                }

            }
        });
    }


    function getTotalpage(count, showRows){
        var numPage = parseInt(count/showRows);
/*        alert(numPage)
        alert(count)
        alert((count % showRows))
        alert(showRows)*/
        if (count > showRows) {
            //alert('1')
            if (numPage > 1) {
                //alert('2')
                if ((count % showRows) != 0) {
                    //alert('3')
                    if (showRows > numPage) {
                        return numPage+1;
                    }
                }    
                return numPage;
            } 
            return numPage+1;
        } else {
            return 1;
        }
    }