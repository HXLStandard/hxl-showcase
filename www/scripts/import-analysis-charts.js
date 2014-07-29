/**
 * JavaScript module to set up charts on analysis page.
 */

// Should be defined earlier
var chart_tags;
var filters;

// Load the Google stuff
google.load("visualization", "1", {packages:["corechart"]});

// Set the callback
google.setOnLoadCallback(drawCharts);

/**
 * Main callback - try to load all requested charts.
 *
 * Uses the variable 'chart_tags', which should have been
 * set earlier (e.g. on the web page itself).
 */
function drawCharts() {
    chart_tags.forEach(drawChart);
}

/**
 * Draw an individual chart.
 */
function drawChart(tag) {
    // grab the CSV
    $.get(makeDataURL(tag), function(csvString) {
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

/**
 * Construct an AJAX query URL using current filters.
 *
 * Uses the global variable 'filters', which should have been set earlier (e.g. on the web page).
 *
 * @param tag The tag that we want to get for visualisation.
 * @return The query string, starting with "?"
 */
function makeDataURL(tag) {
    var request = '?' + 'tag=' + escape(tag);
    for (var key in filters) {
        request += '&' + escape(key) + '=' + escape(filters[key]);
    }
    return request;
}