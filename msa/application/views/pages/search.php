<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script type="text/javascript" language="javascript" >

</script>

<style type="text/css">
.baselogo{
  margin: 10%;
  max-width: 220px;
  width: 90%;
}
.search-btn h4{
  margin: 0px;
}
.a-color ,.a-color:visited,.a-color:hover,.a-color:focus{
  color: #6E6E6E  !important;
  background: none !important;
}
</style>
<div class="row ">
   <div class="col-md-4 col-md-offset-4 text-center row">
      <a href="<?php echo base_url();?>"><img class="baselogo" src="<?php echo base_url();?>/img/512.png"></a>
   </div>

   <div class="col-md-8 col-md-offset-2 text-center row">
      <form class="">
            <div class="form-group col-md-5  pull-right">
                <input type="text" name="key" class="form-control baseautocomplete" placeholder="کلیدواژه، عنوان شغلی، شرکت"/>
            </div>
            <div class="form-group col-md-5  pull-right">
                <input type="text" name="location" class="form-control locautocomplete" placeholder="همه جا"/>
           </sub> </div>
            <div class="form-group col-md-2  pull-right">
              <button type="submit" onclick="" class="btn btn-primary search-btn synbackcolor"><h4>پیدا کن</h4></button>
              <a class="a-color text-xsmall" href="<?php echo base_url();?>">جستجوی پیشرفته</a>
            </div>
        </form>   
   </div>
   <div class="col-md-8 col-md-offset-2 text-center row">
          <p><a class="syntextcolor" href="<?php echo base_url($username);?>"><i class="fa fa-lg fa-arrow-circle-o-up" aria-hidden="true"></i><b> رزومه ی خود را ثبت کنید 
          </b></a> - برای دریافت فرصت های شغلی</p>
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


