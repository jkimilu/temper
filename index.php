<?
include "header.html";
?>
<script type="text/javascript">

    $(document).ready(function()
    {
        


        //get data for data.php url
        var json;
        $.getJSON("data.php",function(data){


            Highcharts.chart('container', {
                chart: {
                    type: 'spline',
                },
                title: {
                    text: 'Temper OnBoarding Process'
                },

                subtitle: {
                    text: 'Retention Curve'
                },

                xAxis: {
                    categories: [],
                    title: {
                        text: 'Step in the onboarding'
                    }
                },
                yAxis: {
                    categories: [],
                    title: {
                        text: '% Users in onboarding step'
                    },
                    labels: {
                        formatter: function () {
                            return this.value + '%';
                        }
                    }
                },
                tooltip: {
                    crosshairs: true,
                    shared: true
                },
                plotOptions: {
                    spline: {
                        marker: {
                            radius: 4,
                            lineColor: '#666666',
                            lineWidth: 1
                        }
                    }
                },
                series: data //from data.php
            });

        });

    });
</script>

<!-- display data and chart -->
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h4>User Registration Data</h4>
            <? include "tabularized.php"; ?>
        </div>
        <div class="col-md-8">
            <h4>Chart</h4>
            <!--plotting the chart -->
            <div id="container" style="height:600px;" class=""></div>
            <h4>Chart Data/JSON</h4>
            <? include "data.php"; ?>
        </div>
    </div>
</div>





<? include "footer.html"?>