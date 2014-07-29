google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawCharts);

var chart_tags = [
    'country',
    'adm1',
    'adm2',
    'adm3',
    'adm4',
    'adm5',
    'sector',
    'org'
];

function drawChart(tag) {
    // grab the CSV
    $.get('?tag=' + tag, function(csvString) {
        // transform the CSV string into a 2-dimensional array
        var arrayData = $.csv.toArrays(csvString, {onParseValue: $.csv.hooks.castToScalar});

        // this new DataTable object holds all the data
        var data = new google.visualization.arrayToDataTable(arrayData);

        // this view can select a subset of the data at a time
        var view = new google.visualization.DataView(data);
        view.setColumns([0,1]);

        // set chart options
        var options = {
            hAxis: {title: data.getColumnLabel(0), minValue: data.getColumnRange(0).min, maxValue: data.getColumnRange(0).max},
            vAxis: {title: data.getColumnLabel(1), minValue: data.getColumnRange(1).min, maxValue: data.getColumnRange(1).max},
            chartArea: { left: 0, top: 0, height: 600, width: 600}
        };

        // create the chart object and draw it
        var chart = new google.visualization.PieChart(document.getElementById(tag + '_chart'));
        chart.draw(view, options);
    });
}

function drawCharts() {
    chart_tags.forEach(drawChart);
}

