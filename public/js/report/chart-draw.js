var format;
var title;
if (type == 1) {
    format = "HH:mm"
    title = 'In Day'
} else if (type == 2) {
    format = "d"
    title = 'In Week'
} else if (type == 3) {
    format = "d/M"
    title = 'In Month'
} else {
    format = "d/M"
    title = 'FromDay ' + '{!! $from_date !!}' + ' ToDay ' + '{!! $to_date !!}'
}

var arrayData = [];
var totalValue = 0;

data.forEach(function(element) {
    totalValue += +element.totalPrice;
    arrayData.push([ new Date( moment(element.date).unix() * 1000), +element.totalPrice ])
});

google.charts.load("visualization", "1", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var obj = arrayData;
    var data = new google.visualization.DataTable();
    data.addColumn({type: 'datetime', label: 'Date'});
    data.addColumn({type: 'number', label: 'Buy'});
    data.addRows(obj)
    var options = {
        curveType: "function",
        vAxis: {maxValue: 100},
        title: title,
        hAxis: {
            format: format
            //format: "HH:mm:ss"
            //format:'MMM d, y'
        },
        explorer: {
            actions: ['dragToZoom', 'rightClickToReset'],
            axis: 'vertical'
        },
        focusTarget:'category',
        aggregationTarget : 'category',
        pointSize: 5,
    };

    var chart = new google.visualization.LineChart(
        document.getElementById('chart_div'));
    chart.draw(data, options);
}

dataPackage.unshift( ['Task', 'Hours per Day']);
google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(pieChart);
function pieChart() {
    var data = google.visualization.arrayToDataTable(dataPackage);

    var options = {
        title: 'My Daily Activities',
        is3D: true,
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
    chart.draw(data, options);
}