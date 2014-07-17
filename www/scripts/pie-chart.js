/**
 * Draw a pie chart using D3.
 *
 * url - the URL of the CSV file to import
 * code - the HXL code to pick from the CSV
 */

var width = 300,
height = 300,
radius = Math.min(width, height) / 2;

// Choose a cycle of colours for the pie chart
var color = d3.scale.ordinal()
    .range(["red", "orange", "yellow", "green", "blue", "magenta"]);

// Callback related to filling a pie slice (??)
var arc = d3.svg.arc()
    .outerRadius(radius - 10)
    .innerRadius(0);

// Function to draw a pie slice
var pie = d3.layout.pie()
    .sort(null)
    .value(function(d) { return d.count; });

// Create the SVG element in the document
var svg = d3.select("#chart").append("svg")
    .attr("width", width)
    .attr("height", height)
    .append("g")
    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

// Process the CSV file
d3.csv(url, function(error, data) {

    // Iterate through the rows
    // TODO with HXL, first row will be headers
    data.forEach(function(d) {
        d.count = +d.count;
    });

    var g = svg.selectAll(".arc")
        .data(pie(data))
        .enter().append("g")
        .attr("class", "arc");

    g.append("path")
        .attr("d", arc)
        .style("fill", function(d) { return color(d.data[code]); });

    g.append("text")
        .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
        .attr("dy", ".35em")
        .style("text-anchor", "middle")
        .text(function(d) { return d.data[code]; });

});
