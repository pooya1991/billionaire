<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
.baselogo{
  max-width: 220px;
  width: 100%;
}
.search-btn h4{
  margin: 0px;
  color: #ffffff;
}
.search-btn {
  margin: 0px;
  float: right;
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
.search-adv{

  margin-top: 3px;
  cursor:pointer;
  color: #ffffff;
  float: right;
}
.ui-widget-content{
	z-index: 9999999  !important;
}
</style>

    <div class="col-md-12  text-center row">
      <form class="" action="<?php echo base_url();?>search">
            <div class="form-group col-md-5  pull-right">
                <input type="text" name="key" class="form-control baseautocomplete" placeholder="کلیدواژه، عنوان شغلی، شرکت"
                 value=""
                  />
            </div>
            <div class="form-group col-md-4  pull-right">
                <input type="text" name="location" 
                value="" 
                class="form-control locautocomplete" placeholder="همه جا"/>

            </div>
            <div class="form-group col-md-3  pull-right">
              <button type="submit" onclick="" class="btn synbackcolor search-btn ">
              <h4>پیدا کن</h4>
              </button>
              <a class="a-color text-xsmall" href="#"><span class="search-adv fa fa-cog fa-3x"></span></a>
            </div>
        </form>   
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