var temp = [];
dataType = DATA.action_type;
dataType.unshift('Action Type');
dataType.push('Total', {type: 'number', role: 'annotation'},{role: 'style'});
temp.push(dataType);
Object.keys(DATA.data_analytic).forEach(function(key) {
    var tmp = []
    tmp.push(key);
    var tp = DATA.data_analytic[key];
    var total = 0;
    Object.keys(tp).forEach(function(ky) {
        total += tp[ky];
        tmp.push(tp[ky]);
    });
    tmp.push(total);
    tmp.push(total);
    tmp.push('#000000');
    temp.push(tmp);
});

google.charts.load("visualization", "1", {packages:["corechart"]});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
    // Some raw data (not necessarily accurate)
    let data = google.visualization.arrayToDataTable(temp);

    let options = {
        isStacked: true,
        title : 'Commission chart',
        vAxis: {title: 'Total Money',maxValue:25},
        hAxis: {title: 'Time'},
        legend: { position: 'top', maxLines: 6 },
        seriesType: 'bars',
        series: {5: {type: 'line',color:"#000000"}},
        pointSize: 2,
    };

    let chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
}