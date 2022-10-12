/*        $.getJSON(full_url + "Dashboard/getstats", function(data){
          new Morris.Line({
            element: 'morris-area-chart',
            data: data,
            xkey: 'date',
            ykeys: ['value'],
            labels: ['Tickets'],
            lineColors: ['orange'],
            resize: true
          });
        })
*/
$.getJSON(full_url + "Dashboard/ticketGroupBySite", function(data) {
    console.log(data)
    new Morris.Line({
        element: 'morris-area-chart',
        data: data,
        xkey: 'DATE',
        ykeys: ['A', 'B', 'C', 'D'],
        labels: ['Panay', 'Cebu', 'Head Office', 'Other Sites'],
        resize: true
    });
});
$.getJSON(full_url + "Dashboard/getServicesCount", function(data) {
    new Morris.Donut({
        element: 'morris-donut',
        data: data,
        colors: ['red', 'orange', 'dark', 'blue', 'black', 'grey', 'yellow'],
        resize: true
    });
});
$.getJSON(full_url + "Dashboard/getTicketPerCounsel", function(data) {
    Morris.Bar({
        element: 'morris-bar',
        data: data,
        xkey: 'label',
        ykeys: ['value'],
        labels: ['Tickets'], 
        resize: true,
        xLabelAngle: 35
    });
});
$.getJSON(full_url + "Dashboard/getTicketStatusGroup", function(data) {
    Morris.Bar({
        element: 'status-bar-chart',
        data: data,
        xkey: 'statuslabel',
        ykeys: ['value'],
        labels: ['Tickets'],
        resize: true,
        xLabelAngle: 35,
        barColors: ['green']
    });
});