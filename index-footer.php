<!-- END MAIN CONTENT -->
<div class="clearfix"></div>
</div>
<!-- END WRAPPER -->
<!-- Javascript -->
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendor/metisMenu/metisMenu.js"></script>
<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="assets/vendor/jquery-sparkline/js/jquery.sparkline.min.js"></script>
<script src="assets/vendor/bootstrap-progressbar/js/bootstrap-progressbar.min.js"></script>
<script src="assets/vendor/chartist/js/chartist.min.js"></script>
<script src="assets/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.min.js"></script>
<script src="assets/vendor/chartist-plugin-axistitle/chartist-plugin-axistitle.min.js"></script>
<script src="assets/vendor/chartist-plugin-legend-latest/chartist-plugin-legend.js"></script>
<script src="assets/vendor/toastr/toastr.js"></script>
<script src="assets/scripts/common.js"></script>
<script>

    $(function () {
       $('#enablequiz').click(function () {
           var x = $('input[name=itemquestion]').val();
           $('input[name=itemstatus]').val(x);
       });
    });

    $(function () {
        $('input[name=sname]').keyup(function () {
            var x = $(this).val();
            $.get("student-table.php", {search:x, mode:"keyup"}).done(function (data) {
                $("#tablestudents").html(data);
            });
        });
    });

    $(function () {
        $('select[name=sdepartment]').change(function () {
            var x = $(this).val();
            $.get("student-table.php", {search:x, mode:"lol"}).done(function (data) {
                $("#tablestudents").html(data);
            });
        });
    });

    $(function () {
        $(document).on("click", ".click-row", function () {
            var x = $(this).data("idnum");
            var y = $(this).data("name");
            var z = $(this).data("dept");
            $('input[name=id2number]').val(x);
            $('input[name=student2name]').val(y);
            $("select[name=department2]").val(z);
        });
    });

    $(function () {
        $('input[name=selectstud]').click(function () {
            var x = $('input[name=selectstud]:checked').val();
            if(x == "selected"){
                $("#test label").addClass("custom-bgcolor-green");
                $("#test *").prop("disabled", false).removeClass("disabledlol");
            }
            else{
                $("#test label").removeClass("custom-bgcolor-green");
                $("#test *").attr("disabled", "disabled").addClass("disabledlol");
            }
        });
    });

    $(function () {
        $("#test *").attr("disabled", "disabled").off('load').addClass("disabledlol");
    });

    $(function () {
       $.get("student-table.php").done(function (data) {
           $("#tablestudents").html(data);
       });
    });

    $(function () {
        $.get("tallypoints.php").done(function (data) {
            $("#txthint2").html(data);
        });
    });

    $(function () {
        var x = $('#quiztitle').text();
        $.get("viewquiz-questions.php", {qtitle:x}).done(function (data) {
            $("#viewquestions").html(data);
        })
    });

    function getEverything(value){
        $(function () {
            $.get("questionitem.php", { qtitle: value }).done(function (data) {
                $("#questionitem").html(data);
            })
        });
    }

    $(function () {
       $('select[name=class]').change(function () {
           var x = $(this).val();
           $.get("getable.php", { class: x }).done(function (data) {
               $("#txthint").html(data);
           });
       });
    });

    $(function () {

        // sparkline charts
        var sparklineNumberChart = function() {

            var params = {
                width: '140px',
                height: '30px',
                lineWidth: '2',
                lineColor: '#20B2AA',
                fillColor: false,
                spotRadius: '2',
                spotColor: false,
                minSpotColor: false,
                maxSpotColor: false,
                disableInteraction: false
            };

            $('#number-chart1').sparkline('html', params);
            $('#number-chart2').sparkline('html', params);
            $('#number-chart3').sparkline('html', params);
            $('#number-chart4').sparkline('html', params);
        };

        sparklineNumberChart();


        // traffic sources
        var dataPie = {
            series: [45, 25, 30]
        };

        var labels = ['Direct', 'Organic', 'Referral'];
        var sum = function(a, b) {
            return a + b;
        };

        new Chartist.Pie('#demo-pie-chart', dataPie, {
            height: "270px",
            labelInterpolationFnc: function(value, idx) {
                var percentage = Math.round(value / dataPie.series.reduce(sum) * 100) + '%';
                return labels[idx] + ' (' + percentage + ')';
            }
        });


        // progress bars
        $('.progress .progress-bar').progressbar({
            display_text: 'none'
        });

        // line chart
        var data = {
            labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            series: [
                [200, 380, 350, 480, 410, 450, 550],
            ]
        };

        var options = {
            height: "200px",
            showPoint: true,
            showArea: true,
            axisX: {
                showGrid: false
            },
            lineSmooth: false,
            chartPadding: {
                top: 0,
                right: 0,
                bottom: 30,
                left: 30
            },
            plugins: [
                Chartist.plugins.tooltip({
                    appendToBody: true
                }),
                Chartist.plugins.ctAxisTitle({
                    axisX: {
                        axisTitle: 'Day',
                        axisClass: 'ct-axis-title',
                        offset: {
                            x: 0,
                            y: 50
                        },
                        textAnchor: 'middle'
                    },
                    axisY: {
                        axisTitle: 'Reach',
                        axisClass: 'ct-axis-title',
                        offset: {
                            x: 0,
                            y: -10
                        },
                    }
                })
            ]
        };

        new Chartist.Line('#demo-line-chart', data, options);


        // sales performance chart
        var sparklineSalesPerformance = function() {

            var lastWeekData = [142, 164, 298, 384, 232, 269, 211];
            var currentWeekData = [352, 267, 373, 222, 533, 111, 60];

            $('#chart-sales-performance').sparkline(lastWeekData, {
                fillColor: 'rgba(90, 90, 90, 0.1)',
                lineColor: '#5A5A5A',
                width: '' + $('#chart-sales-performance').innerWidth() + '',
                height: '100px',
                lineWidth: '2',
                spotColor: false,
                minSpotColor: false,
                maxSpotColor: false,
                chartRangeMin: 0,
                chartRangeMax: 1000
            });

            $('#chart-sales-performance').sparkline(currentWeekData, {
                composite: true,
                fillColor: 'rgba(60, 137, 218, 0.1)',
                lineColor: '#3C89DA',
                lineWidth: '2',
                spotColor: false,
                minSpotColor: false,
                maxSpotColor: false,
                chartRangeMin: 0,
                chartRangeMax: 1000
            });
        }

        sparklineSalesPerformance();

        var sparkResize;
        $(window).on('resize', function() {
            clearTimeout(sparkResize);
            sparkResize = setTimeout(sparklineSalesPerformance, 200);
        });


        // top products
        var dataStackedBar = {
            labels: ['Q1', 'Q2', 'Q3'],
            series: [
                [800000, 1200000, 1400000],
                [200000, 400000, 500000],
                [100000, 200000, 400000]
            ]
        };

        new Chartist.Bar('#chart-top-products', dataStackedBar, {
            height: "250px",
            stackBars: true,
            axisX: {
                showGrid: false
            },
            axisY: {
                labelInterpolationFnc: function(value) {
                    return (value / 1000) + 'k';
                }
            },
            plugins: [
                Chartist.plugins.tooltip({
                    appendToBody: true
                }),
                Chartist.plugins.legend({
                    legendNames: ['Phone', 'Laptop', 'PC']
                })
            ]
        }).on('draw', function(data) {
            if (data.type === 'bar') {
                data.element.attr({
                    style: 'stroke-width: 30px'
                });
            }
        });
    });
</script>
</body>
</html>