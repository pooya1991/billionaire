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

    for (i = 0; i < 100; i += 1) {
        // Start out with a darkened base color (negative brighten), and end
        // up with a much brighter color
        colors.push(Highcharts.Color(base).brighten((i - <?=count($stocks);?>) / <?=count($stocks)*2;?>).get());
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
        pointFormat: '<h6>{series.name}:</h6><br><b >{point.y} IRR</b><br> {point.percentage:.1f}%'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            colors: pieColors,
            dataLabels: {
                enabled: false,
                format: '<b>{point.name}</b><br>{ point.percentage:.1f} %',
                distance: -50,
                filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 10
                }
            }
        }
    },
    series: [{
        name: 'Stock',
        data: [
              <?php
                if(is_array($stocks)){
                   foreach ($stocks as $key => $value) {
                  echo '
                    { name: "'.$value['title_fa'].'", y:'.$value['amount']*$value['price'].' },
                  ';
                    } 
                }else{
                    echo '
                    { name: "خالی", y:1 }';
                }
                

                ?>
 
        ]
    }]
});
</script>