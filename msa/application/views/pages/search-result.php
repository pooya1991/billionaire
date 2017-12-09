<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" language="javascript" >

</script>

<style type="text/css">
.baselogo{
  max-width: 220px;
  width: 100%;
}
.search-btn h4{
  margin: 0px;
}
.a-color ,.a-color:visited,.a-color:hover,.a-color:focus{
  color: #6E6E6E  !important;
  background: none !important;
}
li{
  list-style: none;
}
.search-tools{
  margin-top: 25px;
}
.dropdown-header{
  padding-left: 0px;
  padding-right: 0px;
  font-size: 1em;
  padding-bottom: 10px;
}
.media-right{
  vertical-align: middle;
}
</style>
<div class="col-md-2 pull-right">
  <div class="col-md-12 col-sm-8  text-center row">
      <a href="<?php echo base_url();?>"><img class="baselogo" src="<?php echo base_url();?>/img/512.png"></a>
   </div>

   <div class="search-tools col-md-12" style="clear: both;">
      <ul>
        <li class="dropdown-header">آخرین جسوجو های من</li>
        <!-- <li><a href="#"></a></li> -->
        <li><a>پاک کردن جستوجوها</a></li>
      </ul>
    </div>
<!--     <div class="search-tools col-md-12">
        <ul>
          <li class="dropdown-header">نوع فعالیت</li>
          <li><a>تمام وقت (0)</a></li>
          <li><a> قرارداری (0)</a></li>
          <li><a>کارآموزی (0)</a></li>
          <li><a>موقت (0)</a></li>
          <li><a>پاره وقت (0)</a></li>
          <li><a>کمیسیون (0)</a></li>
        </ul>
    </div> -->
<!--     <div class="search-tools col-md-12">
        <ul>
          <li class="dropdown-header">سطح سنجش</li>
          <li><a>متوسط (0)</a></li>
          <li><a>تازه وارد (0)</a></li>
          <li><a>حرفه ای (0)</a></li>
        </ul>
    </div> -->
</div>
<div class="col-md-10 ">
    <div class="col-md-12  text-center row">
      <form class="">
            <div class="form-group col-md-4  pull-right">
                <input type="text" name="key" class="form-control baseautocomplete" placeholder="کلیدواژه، عنوان شغلی، شرکت"
                 value="<?php echo (isset($keyword['key']))? $keyword['key']:"";  ?>"
                  />
            </div>
            <div class="form-group col-md-4  pull-right">
                <input type="text" name="location" 
                value="<?php echo (isset($keyword['location']))? $keyword['location']:"";  ?>" 
                class="form-control locautocomplete" placeholder="همه جا"/>
           </sub> </div>
            <div class="form-group col-md-4  pull-right">
              <button type="submit" onclick="" class="btn btn-primary search-btn synbackcolor"><h4>پیدا کن</h4></button>
              <a class="a-color text-xsmall" href="<?php echo base_url();?>">جستجوی پیشرفته</a>
            </div>
        </form>   
   </div>
   <div class="col-md-12 text-right row">
          <p><a class="syntextcolor" href="<?php echo base_url($username);?>"><i class="fa fa-lg fa-arrow-circle-o-up" aria-hidden="true"></i><b> رزومه ی خود را ثبت کنید 
          </b></a> - برای دریافت فرصت های شغلی</p>
   </div>
   <div class="search-body col-md-12 ">

    <?php 

    if(isset($users))
    if(is_array($users))
    foreach ($users as $key => $value) {

      echo'
     <div class="media col-md-12">
      <div class="media-header">
           <h3> <a href="'.base_url().$value['username'].'">
            '.$value["firstname"].' '.$value["lastname"].
            '</a> <a href="'.base_url('search?key=').$value['job'].'">- 
            '.$value["job"].'</a>
            </h3>
      </div>
      <div class="media-right">
        <img src="'.$value['pic'].'" class="media-object" style="width:115px; border: 1px solid #4F345A ;">
      </div>
      <div class="media-body">
        <h5><a href=""> '.$value["gender"].' </a><a href=""> '.$value["birthday"].' ساله </a><a href=""> '.$value["visitor"].' بازدید </a></h5>
        <h5><a href="'.base_url('search?key=&location=').$value['livecity'].'"> '.$value["livecity"].' </a></h5>
        <p>'.$value["description"].'</p>
        <p>'.$value["last_online"].'</p>
      </div>
    </div>

      ';
    }

    ?>
 
    <!-- *******pages number********** -->
    <div class="col-md-12 text-center">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <?php
          if(isset($numberofresult))
            if($numberofresult>$numberofsearch){
              for ($i=0; $i <$numberofresult/$numberofsearch ; $i++) { 
                $plable = ($i >= 1) ? $i : "ابتدا" ;
                echo '<li class="page-item"><a class="page-link" href="'.base_url().'search?key='.$keyword['key'].'&location='.$keyword['location'].'&page='.$i.'">'. $plable.'</a></li>';
              }
            }
              
          ?>
        </ul>
      </nav>
    </div>

   </div>
</div>


<script type="text/javascript">
$(function() {
$( ".baseautocomplete" ).autocomplete({
    source: function( request, response ) {
         var values = {
          keyword:$("input[name=key]").val()
         };
        $.ajax({
            url: '<?php echo base_url();  ?>search/allsearch',
                type: 'POST',
                dataType: 'json',
                data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
            success:function(data)
            {
              var result = data.result;
              if(result.error){
                $.each(result['error_detalis'], function (index, object) {
                      result(object);
                });
              }else{
                if(result.data){
                  response(result.data);
                }
              }
            }
          });
    },
    minLength: 3,
    max:6,
});

$( ".locautocomplete" ).autocomplete({
    source: function( request, response ) {
         var values = {
          keyword:$("input[name=location]").val()
         };
        $.ajax({
            url: '<?php echo base_url();  ?>search/location',
                type: 'POST',
                dataType: 'json',
                data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
            success:function(data)
            {
              var result = data.result;
              if(result.error){
                $.each(result['error_detalis'], function (index, object) {
                      result(object);
                });
              }else{
                if(result.data){
                  response(result.data);
                }
              }
            }
          });
    },
    minLength: 3,
    max:6,
});

});
</script>


