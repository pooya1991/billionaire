<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="circlechart" style="min-width:100px !important"></div>


<script type="text/javascript">

// Make monochrome colors
var pieColors = (function () {
    var colors = [],
        base = Highcharts.getOptions().colors[0],
        i;

    for (i = 0; i < 10; i += 1) {
        // Start out with a darkened base color (negative brighten), and end
        // up with a much brighter color
        colors.push(Highcharts.Color(base).brighten((i - 3) / 7).get());
    }
    return colors;
}());

// Build the chart
Highcharts.chart('circlechart', {

    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie',
        height: 200,

        backgroundColor:'none'
    },
    title: {
        text: ''
    },
    subtitle: {
        text: ''
    },
    credits:{
        enabled:false
    },
    tooltip: {
        pointFormat: '<b>{series.name}:</b><br><b>{point.y}ريال</b><br> {point.percentage:.1f}%'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            colors: pieColors,
            dataLabels: {
                enabled: false,
                format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
                distance: -50,
                filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                }
            }
        }
    },
    series: [{
        name: 'سبد',
        data: [
            { name: 'فخوز', y: 56.33 },
            { name: 'ایاپ', y: 24.03 },
            { name: 'های وب', y: 10.38 },
            { name: 'بیلیونر', y: 4.77 },
            { name: 'طلا', y: 0.91 },
            { name: 'خودرو سازان', y: 30.91 }
        ]
    }]
});
</script>