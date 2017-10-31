/*Line chart*/
var format;
var title;
var arrayData = [];
var totalValue = 0;

if (data.opt == 1) {
    format = "d/M/yy"
    title = data.title;
    data.data_analytic.forEach(function(element) {
        totalValue += +element.totalPrice;
        arrayData.push([ new Date( moment(element.date).unix() * 1000), +element.totalPrice ])
    });
} else if (data.opt == 2) {
    format = "d/M/yy"
    title = data.title;
    data.data_analytic.forEach(function(element) {
        totalValue += +element.totalPrice;
        arrayData.push([ new Date( moment(element.date).unix() * 1000), +element.totalPrice] )
    });
    console.log(arrayData);
} else if (data.opt == 3) {
    format = "d/M"
    title = data.title;
} else {
    format = "d/M"
    title = 'FromDay ' + data.date_custom.from_date + ' ToDay ' + data.date_custom.to_date
}

google.charts.load("visualization", "1", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
    var obj = arrayData;
    var data = new google.visualization.DataTable();
    data.addColumn({type: 'date', label: 'Date'});
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
/*Pie Chart*/
var dataPackage = [];
var total = 0;
data.total.totalPackageForPieChart.map(function (item,index) {
    dataPackage[index] = [item.name,+item.totalPerson];
    total += +item.totalPerson;
});
dataPackage.unshift(['Package','Package']);

google.charts.load("current", {packages:["corechart"]});
google.charts.setOnLoadCallback(pieChart);

function pieChart() {
    var data = google.visualization.arrayToDataTable(dataPackage);

    var options = {
        title: 'Total Person : ' + total,
        is3D: true,
    };

    var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
    chart.draw(data, options);

}