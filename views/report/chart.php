<?php
/** @var yii\web\View $this */

/** @var $regions array */

use yii\bootstrap5\Html;
use yii\helpers\Url;
use miloschuman\highcharts\HighchartsAsset;

HighchartsAsset::register($this)->withScripts(['modules/exporting', 'modules/drilldown']);
?>
<div class="report-page-chart">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h1>Filter</h1>
            </div>
        </div>
            <?= $this->render('_reportFilter',['regions'=>$regions]) ?>
        </div>
        <div class="row mb-3">
            <div id="chart-1" class="col-5 me-5"></div>
            <div id="chart-2" class="col-5"></div>
        </div>
        <div class="row">
            <div id="chart-3" class="col"></div>
        </div>
    </div>

    <?php
    $url_province = Url::to(['/report/province']);
    $url_citymun = Url::to(['/report/city']);
    $url_chart_1 = Url::to(['/report/chartone']);
    $url_chart_2 = Url::to(['/report/charttwo']);
    $url_chart_3 = Url::to(['/report/chartthree']);
    $script = <<<JS
    $(document).ready(()=>{
        //region
        $('#region').on('change',()=>{
            //disable disable for province
            $('#province').prop('disabled',false);
            let citymun = $('#citymun');
            citymun.prop('disabled',true);
            citymun.empty();
            citymun.append('<option ">Select City/Municipality</option>')
  
           //get province
           $.ajax({
               url:'$url_province',
               type:'GET',
               data:{region:$('#region').val()},
               success:function(data){
                   let province_dropdown = $('#province');
                   province_dropdown.empty();
                   //add select
                   province_dropdown.append('<option value="">Select Province</option>');
                   $.each(data,(id,value)=>{
                        //append
                        province_dropdown.append('<option value="'+id+'">'+value+'</option>');
                   });
               }
           }); 
            // ajax for data chart 1
           $.ajax({
                url:'$url_chart_1',
                type:'GET',
                data:{region:$('#region').val()},
                success:function(data) {
                    create_chart_1(JSON.parse(data)); 
                } 
           }) //ajax data chart 1
           //ajax for chart 2
           $.ajax({
                url:'$url_chart_2',
                type:'GET',
                data:{region:$('#region').val()},
                success:function(data) {
                    create_chart_2(JSON.parse(data));
                } 
           }) //ajax data chart 2
           //chart for 3
         $.ajax({
             url:'$url_chart_3',
             type:'GET',
             data:{region:$('#region').val()},
             success:function(data) {
                 create_chart_3(JSON.parse(data));
             } 
         }) //ajax data chart 2
        });//end region event listener
        
        //province
        $('#province').on('change',()=>{
            //disable disable for citymun
            $('#citymun').prop('disabled',false);  
           $.ajax({
               url:'$url_citymun',
               type:'GET',
               data:{region:$('#region').val(),province:$('#province').val()},
               success:function(data){
                   let citymun_drop_down = $('#citymun');
                   citymun_drop_down.empty();
                   //add select
                   citymun_drop_down.append('<option ">Select Province</option>');
                   $.each(data,(id,value)=>{
                        //append
                        citymun_drop_down.append('<option value="'+id+'">'+value+'</option>');
                   });
               }
           });
           $.ajax({
                url:'$url_chart_1',
                type:'GET',
                data:{region:$('#region').val(),province:$('#province').val()},
                success:function(data) {
                    create_chart_1(JSON.parse(data)); 
                } 
           }) //ajax data chart 1
           //ajax for chart 2
           $.ajax({
                url:'$url_chart_2',
                type:'GET',
                data:{region:$('#region').val(),province:$('#province').val()},
                success:function(data) {
                    create_chart_2(JSON.parse(data));
                } 
           }) //ajax data chart 2
           //chart for 3
         $.ajax({
             url:'$url_chart_3',
             type:'GET',
             data:{region:$('#region').val(),province:$('#province').val()},
             success:function(data) {
                 create_chart_3(JSON.parse(data));
             } 
         }) //ajax data chart 2
        });
        
        $('#citymun').on('change',()=>{
           $.ajax({
                url:'$url_chart_1',
                type:'GET',
                data:{region:$('#region').val(),province:$('#province').val(),citymun:$('#citymun').val()},
                success:function(data) {
                    create_chart_1(JSON.parse(data)); 
                } 
           }) //ajax data chart 1
           //ajax for chart 2
           $.ajax({
                url:'$url_chart_2',
                type:'GET',
                data:{region:$('#region').val(),province:$('#province').val(),citymun:$('#citymun').val()},
                success:function(data) {
                    create_chart_2(JSON.parse(data));
                } 
           }) //ajax data chart 2
          //cahrt for 3
         $.ajax({
             url:'$url_chart_3',
             type:'GET',
             data:{region:$('#region').val(),province:$('#province').val(),citymun:$('#citymun').val()},
             success:function(data) {
                 create_chart_3(JSON.parse(data));
             } 
         }) //ajax data chart 2
        }) 
        
        
        
        //Nation Wide
        $.ajax({
        url:'$url_chart_1',
        type:'GET',
        success:function(data) {
                create_chart_1(JSON.parse(data));
        }//success end
        })//ajax end
         $.ajax({
             url:'$url_chart_2',
             type:'GET',
             success:function(data) {
                create_chart_2(JSON.parse(data));
             } 
         }) //ajax data chart 2
         $.ajax({
             url:'$url_chart_3',
             type:'GET',
             success:function(data) {
                 create_chart_3(JSON.parse(data));
             } 
         }) //ajax data chart 2
        
    });//jquery end
    
    //function create chart 1
    function create_chart_1(data){
    Highcharts.chart('chart-1', {
    chart: {
        type: 'column'
    },
    title: {
        align: 'left',
        text: 'Total number of encoded personal information by status'
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total Count Per Status'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {
                enabled: true,
                format: '{point.y}'
            }
        }
    },

    tooltip: {
        headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: ' +
            '<b>{point.y}</b> of total<br/>'
    },
    series: [data]
    });
    }//end create function chart_1    
    create_chart_2('asd');
    function create_chart_2(data){
Highcharts.chart('chart-2', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false
    },
    title: {
        text: 'Ratio Per Status',
        align: 'center',
        verticalAlign: 'top',
        y: 60,
        style: {
            fontSize: '2em'
        }
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        title:"Ratio per status against population",
        pie: {
            dataLabels: {
                enabled: true,
                distance: -50,
                style: {
                    fontWeight: 'bold',
                    color: 'white'
                }
            },
            startAngle: -90,
            endAngle: 90,
            center: ['50%', '100%'],
            size: '110%'
        }
    },
    series: [{
        type: 'pie',
        name: 'Ratio per status',
        innerSize: '50%',
        data:data
    }]
});}//end create function chart_2
    
    function create_chart_3(data){
        Highcharts.chart('chart-3', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Ratio Per Stats',
        align: 'left'
    },
    xAxis: {
        categories: ['0-12','13-18','19-25','26-35','36-50','51-65','65 and above'],
        title: {
            text: null
        },
        gridLineWidth: 1,
        lineWidth: 0
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Population',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        gridLineWidth: 0
    },
    tooltip: {
        valueSuffix: ' Person/s'
    },
    plotOptions: {
        bar: {
            borderRadius: '0%',
            dataLabels: {
                enabled: true
            },
            groupPadding: 0.1
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: data
});
}   
    
    
JS;


    $this->registerJs($script);
    ?>

</div>