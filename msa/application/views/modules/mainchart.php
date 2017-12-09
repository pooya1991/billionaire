<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div id="mainchart"></div>
<pre>
<?php
$chartdata="";
if(is_array($data))
for ($i=0; $i < count($data['close']) ; $i++) { 
    $chartdata[] = array(
        'date' => $data['date'][$i],
        'price' => $data['close'][$i]
     );
}

?>
</pre>
<script type="text/javascript">


 Highcharts.stockChart('mainchart', {

        chart: {
            height: 400,
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

        rangeSelector: {
            inputEnabled:false,
            label:false,
            buttons: 
                [   {
                        type: 'day',
                        count: 1,
                        text: 'امروز'
                    }, {
                        type: 'week',
                        count: 1,
                        text: 'هفته'
                    }, {
                        type: 'month',
                        count: 1,
                        text: '1ماه'
                    }, {
                        type: 'month',
                        count: 3,
                        text: '3ماه'
                    }, {
                        type: 'year',
                        count: 1,
                        text: '1y'
                }],
            buttonPosition:
            {
                align:'right'
            },
            buttonTheme: { // styles for the buttons
                fill: '#0f3045',
                stroke: 'none',
                'stroke-width': 0,
                r: 2,
                style: {
                    color: '#7b92a1',
                    fontWeight: 'bold'
                },
                states: {
                    hover: {
                    },
                    select: {
                        fill: '#7b92a1',
                        style: {
                            color: 'white'
                        }
                    }
                    // disabled: { ... }
                }
            },
           
            labelStyle: {
                color: '#244052'
                },

        },
        navigator: {
                        enabled: false
                    },
        scrollbar: {
                enabled: false
            },
            
        yAxis: {
            visible: true,
            gridLineColor:'#3a5568',
            labels: {

                align:'left',
                style:{
                        color:'#7b92a1'
                       }
                   }

        },
        xAxis: {
            gridLineColor:'#3a5568',
            labels: {
                style:{
                        color:'#7b92a1'
                       }
                   }

        },

        series: [{
            name: 'price',
            data: [
            <?php
                if(is_array($chartdata))
                foreach ($chartdata as $key => $value) {
                    echo '['.$value['date'].','.$value['price'].'],';
                }
            ?>
            ],
            type: 'area',
            threshold: null,
            tooltip: {
                valueDecimals: 1
            }
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    chart: {
                        height: 300
                    },
                    subtitle: {
                        text: null
                    },
                    navigator: {
                        enabled: false
                    }
                }
            }]
        }
    });
 Highcharts.setOptions({
        lang: {
            months: ['فروردين', 'ارديبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
            shortMonths: ['فروردين', 'ارديبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'],
            weekdays: ["یکشنبه", "دوشنبه", "سه شنبه", "چهارشنبه", "پنج‌شنبه", "جمعه", "شنبه"]
        }
    });

        </script>
