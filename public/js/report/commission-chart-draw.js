google.charts.load("visualization", "1", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    // Some raw data (not necessarily accurate)
    var data = google.visualization.arrayToDataTable([
        ['Month', 'Bolivia', 'Ecuador', 'Madagascar', 'Papua New Guinea', 'Rwanda', 'Total', {type: 'number', role: 'annotation'},{role: 'style'}],
        ['Application',5,2,2,8,0,17,17,'#000000'],
        ['Friend',4,3,5,6,2,20,20,'#000000'],
        ['Newspaper',  6,      1,        0,             2,           0,      9, 9,'#000000'],
        ['Radio',  8,      0,        8,             1,           1,      18, 18,'#000000'],
        ['No Referral',  2,      2,        3,             0,          6,      13, 13,'#000000']
    ]);

    var options = {
        isStacked: true,
        title : 'Monthly Coffee Production by Country',
        vAxis: {title: 'Cups',maxValue:25},
        hAxis: {title: 'Month'},
        legend: { position: 'top', maxLines: 6 },
        seriesType: 'bars',
        series: {5: {type: 'line',color:"#000000"}},
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}