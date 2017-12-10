<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">


.container{
  width:100%;
  display:inline-block;
  vertical-align:middle;
  text-align:center;
}

#myclock{
  text-align: center;
  
}
.todaydate{
    font-size: .8rem;
    margin-bottom: 5px; 
    display: block;
    direction: rtl;
    text-align: center;
}

</style>

  <div id="myclock"></div>
  <div class="todaydate"><?php 
       echo $this->jdf->gregorian_to_jalali(date("Y"),date('m'),date('d'),"/");
   ?>
   </div>



<script language="javascript" type="text/javascript" src="<?=base_url();?>assets/js/jquery.thooClock.js"></script>  
<script language="javascript">

    //clock plugin constructor
    $('#myclock').thooClock({
      size:150,
      dialColor:'#fff',
      minuteHandColor:'#fff',              // color of minute hand
      hourHandColor:'#fff',
      showNumerals:true,
      onEverySecond:function(){
        //callback that should be fired every second
      }
    });



</script>
