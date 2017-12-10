<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
.masthead{
  background-image:url(<?=base_url();?>images/bg.png);
  
}

</style>
<header class="masthead" >
  <div class="header-content">
    <div class="header-content-inner">
      <div class="row">
        <div class="col-md-7">
          <div class="col-md-12 " style="text-align: center;">
            <a href="<?php echo base_url();?>">
            <img src="<?php echo base_url(); ?>images/logow.png"  style="width: 70%;padding-top: 70px;">
            </a>
          </div>
        </div>
        <div class="col-md-5">
          <div class="panel panel-registertwo">
            <!-- <div class="panel-heading">
              <div class="row">
                <div class="col-xs-6">
                  <a href="#" id="registertwo-form-link">عضویت شرکت</a>
                </div>
                <div class="col-xs-6" >
                  <a href="#" class="active" id="register-form-link">عضویت شخص</a>
                </div>
              </div>
              <hr>
            </div> -->
          <div class="col-md-12">
            <ul class="pregister">
            </ul>
          </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-lg-12">
                  <form id="register-form"  role="form" style="display: block;">
                    <div class="form-group">
                      <label>گذرواژه جدید را وارد کنید</label>
                    </div>
                    <div class="form-group">
                      <input type="password" name="password" id="password" tabindex="15" class="form-control register" placeholder="گذرواژه">
                    </div>
                    <div class="form-group">
                      <input type="password" name="confirm-password" id="confirm-password" tabindex="16" class="form-control register" placeholder="تکرار گذرواژه">
                    </div>
                    <div class="form-group">
                          <input type="button" name="register-submit" id="register-submit" tabindex="17" class="form-control btn btn-primary  btn-fill" value="ثبت رمز جدید" onclick="forget()">
                    </div>
                    <div class="form-group">
                      <label class="detail"></label>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>

<script type="text/javascript">

/* autocomplet : this function will be executed every time we change the text*/
function forget() {
   var values = {
    passwd:$("input[name=password].register").val(),
    repasswd:$("input[name=confirm-password].register").val(),
    link:'<?=$key?>'
   };
    $.ajax({
        url: '<?php echo base_url();  ?>signup/resetpass',
            type: 'POST',
            dataType: 'json',
            data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
        success:function(data)
        {
          $('label.detail').html("");
          var response = data.result;
          if(response.error){
            $.each(response['error_detalis'], function (index, object) {
                  $('label.detail').append("<li>"+object+"</li>")
            });
          }else{
            if(response.data){
              $('label.detail').html(response.data);
            }
          }
          
        }
      }); 
}

</script>




    <!-- Bootstrap core JavaScript -->
    <script src="<?=base_url();?>assets/jquery/jquery.min.js"></script>
    <script src="<?=base_url();?>assets/popper/popper.min.js"></script>
    <script src="<?=base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="<?=base_url();?>assets/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?=base_url();?>assets/scrollreveal/scrollreveal.min.js"></script>
    <script src="<?=base_url();?>assets/magnific-popup/jquery.magnific-popup.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="<?=base_url();?>assets/js/creative.min.js"></script>

  </body>

</html>
    
                   
