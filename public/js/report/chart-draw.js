/*Line chart*/
var format;
var title;
var arrayData = [];
var totalValue = 0;
var labelData = [];
var title = data.title;
console.log(data);
if (data.opt == 1) {
    if(data.data_analytic.length == 0){
         $(".chart-responsive div#chart_div").html("<b>No Data</b>");
    } else { 
        data.data_analytic.forEach(function(element) {
            arrayData.push([ new Date( moment(element.date).unix() * 1000), +element.totalPrice ])
        });

        google.charts.load("visualization", "1", {packages:["corechart"]});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var obj = arrayData;
            var data = new google.visualization.DataTable();
            data.addColumn({type: 'date', label: 'Start'});
            data.addColumn({type: 'number', label: 'Value'});
            data.addRows(obj)
            var options = {
                curveType: "function",
                animation:{ duration: 1000, easing: 'out', startup: true },
                title: title,
                hAxis: {
                    format: 'd-MM-y'
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
    }
} else if (data.opt == 2) {
    if(data.data_analytic.length == 0 ){
        $(".chart-responsive div#chart_div").html("<b>No Data</b>");
    } else {
        format = "M/yy"
        title = data.title;
        data.data_analytic.forEach(function(element) {
            totalValue += +element.totalPrice;
            arrayData.push([ new Date( moment(element.first_day).unix() * 1000), +element.totalPrice,'<span style="padding:10px;"><b>'+element.first_day+' '+element.last_day+'</b> Value:'+element.totalPrice +'</span>'] );
        });
        arrayData.unshift(['Date', 'Value',{type: 'string', role: 'tooltip', 'p': {'html': true}}]);
        google.charts.load('current', {'packages':['corechart']}); 
        google.charts.setOnLoadCallback(drawChart); 
        function drawChart() { 
                var data = google.visualization.arrayToDataTable(arrayData); 
                var options = { 
                        title: title, 
                        curveType: 'function', 
                        animation:{ duration: 1000, easing: 'out', startup: true },
                        tooltip: {isHtml: true},
                        hAxis: {format:'MM-y'},
        //		vAxis: {
        //			
        //			viewWindowMode:'maximized',
        //		} 
                        pointSize: 5,
                }; 

                var chart = new google.visualization.LineChart(document.getElementById('chart_div')); 
                chart.draw(data, options); 
        }
    }
   
} else if (data.opt == 3) {
    format = "M/yy"
    title = data.title;
    if(data.data_analytic.length == 0 ){
        $(".chart-responsive div#chart_div").html("<b>No Data</b>");
    } else {
        data.data_analytic.forEach(function(element) {
            totalValue += +element.totalPrice;
            arrayData.push([ new Date( moment(element.first_day).unix() * 1000), +element.totalPrice,'<span style="padding:10px;"><b>'+element.first_day+' '+element.last_day+'</b> Value:'+element.totalPrice +'</span>'] );
        });
        arrayData.unshift(['Date', 'Value',{type: 'string', role: 'tooltip', 'p': {'html': true}}]);
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = google.visualization.arrayToDataTable(arrayData);
            var options = {
                title: title,
                curveType: 'function',
                animation:{ duration: 1000, easing: 'out', startup: true },
                tooltip: {isHtml: true},
                hAxis: {format:'MM-y'},
                //		vAxis: {
                //
                //			viewWindowMode:'maximized',
                //		}
                pointSize: 5,
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    }
    
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