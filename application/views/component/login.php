<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style type="text/css">
.masthead{
  background-image:url(<?=base_url();?>images/bg.png);
  
}
.pregister{
  color: #fff;
}
</style>
    <header class="masthead" >
      <div class="header-content">
        <div class="header-content-inner">
            <div class="row">                    
              <div class="col-md-7">
                <div class="col-md-12 " style="text-align: center;">
                  <a href="<?php echo base_url();?>">
                  <img src="<?php echo base_url(); ?>images/logow.png" style="width: 70%;">
                  </a>
                </div>
              </div>
              <div class="col-md-5">
                <div class="panel panel-registertwo">
                  <div class="panel-heading">
                    <div class="row">
                      <div class="col-xs-6" >
                        <a href="#" class="active" id="register-form-link"></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <ul class="pregister">
                    </ul>
                  </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-lg-12">
                        <form id="register-form"  role="form" style="display: block;">
                            <div class="form-group">
                            <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="آدرس ایمیل" value="">
                          </div>
                          <div class="form-group">
                            <input type="password" name="passwd" id="passwd" tabindex="2" class="form-control" placeholder="گذرواژه">
                          </div>
                          <div class="form-group text-right">
                            <input type="checkbox" tabindex="3" class="" name="remember" id="remember">
                            <label for="remember">مرا بخاطر بسپار</label>
                          </div>
                          <div class="form-group">
                            <div class="row">
                              <div class="col-sm-12">
                                <input type="button" style="text-align: center;" name="login-submit" id="login-submit" tabindex="4" class="form-control btn btn-primary  btn-fill" value="ورود" onclick="login()">
                              </div>
                            </div>
                          </div>
                          <div class="form-group">
                            <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="text-center">
                                  <a href="<?php echo base_url();?>signup" tabindex="5" class="forgot-password">ثبت نام</a>
                                </div>
                              </div>
                              <div class="col-lg-6 col-md-6">
                                <div class="text-center">
                                  <a href="<?=base_url();?>signup/forget" tabindex="5" class="forgot-password">گذرواژه را فراموش کردید؟</a>
                                </div>
                              </div>
                              
                            </div>
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
$(function() {

    $('#registertwo-form-link').click(function(e) {
    $("#registertwo-form").delay(100).fadeIn(100);
    $("#register-form").fadeOut(100);
    $('#register-form-link').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
  });
  $('#register-form-link').click(function(e) {
    $("#register-form").delay(100).fadeIn(100);
    $("#registertwo-form").fadeOut(100);
    $('#registertwo-form-link').removeClass('active');
    $(this).addClass('active');
    e.preventDefault();
  });

});
/* autocomplet : this function will be executed every time we change the text*/
function login() {
   var values = {
    email:$("input[name=username]").val(),
    passwd:$("input[name=passwd]").val(),
   };
    $.ajax({
        url: '<?php echo base_url();  ?>login/login',
            type: 'POST',
            dataType: 'json',
            data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
        success:function(data)
        {
          $('ul.pregister').html("");
          var response = data.result;
          if(response.error){
            $.each(response['error_detalis'], function (index, object) {
                  $('ul.pregister').append("<li>"+object+"</li>")
            });
          }else{
            if(response.data){
              location.reload();
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
    
                   
