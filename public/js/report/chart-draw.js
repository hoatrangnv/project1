/*Line chart*/
var format;
var title;
var arrayData = [];
var totalValue = 0;
var labelData = [];
var title = data.title;
if (data.opt == 1) {
    data.data_analytic.forEach(function(element) {
        totalValue += +element.totalPrice;
        arrayData.push([ new Date( moment(element.date).unix() * 1000), +element.totalPrice ])
    });
    
    google.charts.load("visualization", "1", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var obj = arrayData;
        var data = new google.visualization.DataTable();
        data.addColumn({type: 'date', label: 'Start'});
        data.addColumn({type: 'number', label: 'Buy'});
        data.addRows(obj)
        var options = {
            curveType: "function",
            vAxis: {maxValue: 100},
            title: title,
            hAxis: {
                format: 'd-MMM-y'

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
    
} else if (data.opt == 2) {
    format = "M/yy"
    title = data.title;
    data.data_analytic.forEach(function(element) {
        totalValue += +element.totalPrice;
        arrayData.push([ new Date( moment(element.first_day_week).unix() * 1000), +element.totalPrice,'<span style="padding:10px;"><b>'+element.first_day_week+' '+element.last_day_week+'</b> Buy:'+element.totalPrice +'</span>'] );
        labelData.push([ new Date( moment(element.first_day_week).unix() * 1000), new Date( moment(element.last_day_week).unix() * 1000),"1"]);
    });
    arrayData.unshift(['Date', 'Process',{type: 'string', role: 'tooltip', 'p': {'html': true}}]);
    google.charts.load('current', {'packages':['corechart']}); 
    google.charts.setOnLoadCallback(drawChart); 
    function drawChart() { 
            var data = google.visualization.arrayToDataTable(arrayData); 
            var options = { 
                    title: title, 
                    curveType: 'function', 
                    animation:{ duration: 1000, easing: 'out', startup: true },
                    tooltip: {isHtml: true}, 
                    hAxis: {format:'MMM-y'}, 
    //		vAxis: {
    //			
    //			viewWindowMode:'maximized',
    //		} 
                    pointSize: 5,
            }; 

            var chart = new google.visualization.LineChart(document.getElementById('chart_div')); 
            chart.draw(data, options); 
    }
} else if (data.opt == 3) {
    format = "d/M"
    title = data.title;
} else {
    format = "d/M"
    title = 'FromDay ' + data.date_custom.from_date + ' ToDay ' + data.date_custom.to_date
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

function opt_day(){
    
}