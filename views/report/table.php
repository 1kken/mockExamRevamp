<?php
/** @var yii\web\View $this */

/** @var $regions array */

use yii\helpers\Url;

?>
<h1>Person Master List</h1>

<div class="report-page-table">
    <div class="container">
        <div class="row">
            <div class="col text-center">
                <h1>Filter</h1>
            </div>
        </div>
        <?= $this->render('_reportFilter', ['regions' => $regions]) ?>
    </div>
</div>
<div class="row">
    <div class="col">
        <div id="masterlist">
        </div>
    </div>
</div>
<button type="button" id="print" class="btn btn-success mt-2">Print</button>

<?php
$url_province = Url::to(['/report/province']);
$url_citymun = Url::to(['/report/city']);
$url_get_master_list = Url::to(['/person/masterlist']);
$js = <<<JS
const table = new Tabulator("#masterlist", {
    printHeader:"<div class='d-flex justify-content-center'><h1> Person Master List</h1></div>",
    'layout':'fitColumns',
    pagination:"local",
    paginationSize:6,
    paginationSizeSelector:[3, 6, 8, 10],
    height:"311px",
    columns:[
    {title:"Name", field:"name"},
    {title:"Date Of Birth", field:"birthdate", hozAlign:"center"},
    {title:"Age",field:"age", hozAlign:"center"},
    {title:"Sex",field:"sex", hozAlign:"center"},
    {title:"Contact Info",field:"contact_info", hozAlign:"center"},
    {title:"Region",field:"region", hozAlign:"center"},
    {title:"Province",field:"province", hozAlign:"center"},
    {title:"City/Municipality",field:"citymun", hozAlign:"center"},
    {title:"District",field:"district", hozAlign:"center"},
    {title:"Status",field:"status", hozAlign:"center"}
    ]
});
    $(document).ready(()=>{
        //region
        $('#region').on('change',()=>{
            //disable disable for province
            $('#province').prop('disabled',false);
            let citymun = $('#citymun');
            citymun.prop('disabled',true);
            citymun.empty();
            citymun.append('<option value="" ">Select City/Municipality</option>')
  
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
                 getMasterList();   
               }
           });
           
           //Get user with region 
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
                   citymun_drop_down.append('<option value="" ">Select City/Municipality</option>');
                   $.each(data,(id,value)=>{
                        //append
                        citymun_drop_down.append('<option value="'+id+'">'+value+'</option>');
                   });
                   getMasterList();   
               }
           });
        })
    });
    $('#citymun').on('change',()=>{
        getMasterList();   
    });
    getMasterList();   
    //ajax function
    function getMasterList(){
        $.ajax({
            url:'$url_get_master_list',
            type:'GET',
            data:{region:$('#region').val(),province:$('#province').val(),citymun:$('#citymun').val()},
            success:function(data){
                table.setData(data);
            }
        });
    }
    
    //print button
document.getElementById("print").addEventListener("click", function(){
   table.print(false, true);
});
JS;
$this->registerJs($js);
?>


        
        
