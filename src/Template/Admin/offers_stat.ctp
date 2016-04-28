<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>OffersCharts</title>
        <link rel="stylesheet" href="/offerz_new/css/admin/style.css" type="text/css">
        <script src="/offerz_new/js/admin/amcharts.js" type="text/javascript"></script>
        <script src="/offerz_new/js/admin/serial.js" type="text/javascript"></script>
<script type='text/javascript'>
<?php
$js_array = json_encode($user_data);
echo "var users = ". $js_array . ";\n";
?>
var chartData=[];
var i = 0;
users.forEach(function(entry) {
    
	var temp=new Object();
	temp["user_name"]=entry[0];
	temp["accepted_offers"]=entry['offer_accepted'];
	temp["decline_offers"]=entry['offer_declined'];
	
	chartData[i]=Object.assign(temp);
	i=i+1;
	
});
console.log(chartData);


 var chart;

            AmCharts.ready(function () {
                // SERIAL CHART
                chart = new AmCharts.AmSerialChart();
                chart.dataProvider = chartData;
                chart.categoryField = "user_name";
                chart.startDuration = 1;
                chart.depth3D = 20;
                chart.angle = 45;
                chart.marginRight = -45;

                // AXES
                // category
                var categoryAxis = chart.categoryAxis;
                categoryAxis.axisAlpha = 1;
                categoryAxis.gridAlpha = 1;
                categoryAxis.gridPosition = "start";
				
				categoryAxis.gridColor = "#ff56ff";
				categoryAxis.axisThickness = 5;

                // value
                var valueAxis = new AmCharts.ValueAxis();
                valueAxis.axisAlpha = 1;
                valueAxis.gridAlpha = 1;
                valueAxis.gridColor = "black";
                valueAxis.fillColor = "cyan";
                valueAxis.color = "#af34fa";
                valueAxis.axisColor = "#af34fa";
                valueAxis.axisFillColor = "#af34fa";
                valueAxis.axisThickness = 5;
                valueAxis.axisX = 1;
                valueAxis.axisY = 1;
                valueAxis.dashLength = 5;
                valueAxis.fillAlpha = 5;
                valueAxis.inside = true;
                valueAxis.tickLength = 10;
                chart.addValueAxis(valueAxis);

                // GRAPH
                var graph = new AmCharts.AmGraph();
                graph.valueField = "accepted_offers";
                graph.colorField = "#04D215";
                graph.balloonText = "<b>Accepted Offers: [[value]]</b>";
                graph.type = "column";
                graph.lineAlpha = 0.5;
                graph.lineColor = "#04D215";
                graph.topRadius = 1;
                graph.fillAlphas = 0.9;
                chart.addGraph(graph);
				
				//graph 2nd
				var graph2 = new AmCharts.AmGraph();
                graph2.valueField = "decline_offers";
                graph2.colorField = "#FF0F00";
                graph2.balloonText = "<b>Declined Offers:  [[value]]</b>";
                graph2.type = "column";
                graph2.lineAlpha = 0.5;
                graph2.lineColor = "#FF0F00";
                graph2.topRadius = 1;
                graph2.fillAlphas = 0.9;
                chart.addGraph(graph2);
                // CURSOR
                var chartCursor = new AmCharts.ChartCursor();
                chartCursor.cursorAlpha = 0;
                chartCursor.zoomable = false;
                chartCursor.categoryBalloonEnabled = false;
                chartCursor.valueLineEnabled = false;
                chartCursor.valueLineBalloonEnabled = false;
                chartCursor.valueLineAlpha = 1;
                chart.addChartCursor(chartCursor);

                chart.creditsPosition = "top-right";

                // WRITE
                chart.write("chartdiv");
            });
        </script>
    </head>

    <body>
        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
    </body>

</html>