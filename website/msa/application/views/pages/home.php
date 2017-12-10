<?php
defined('BASEPATH') OR exit('No divect script access allowed');
?>



<style type="text/css">

::-webkit-scrollbar
{
  width: 12px;  /* for vertical scrollbars */
  height: 12px; /* for horizontal scrollbars */
}

::-webkit-scrollbar-track
{
  background: rgba(0, 0, 0, 0.1);
}

::-webkit-scrollbar-thumb
{
  background: rgba(0, 0, 0, 0.5);
}

.flipButton {
  text-align:right;
  float: right;
  padding: 10px;
  cursor: pointer;
}
.flip-container {
  -webkit-perspective: 1000;
  -moz-perspective: 1000;
  -o-perspective: 1000;
  perspective: 1000;
  clear: both;
}

/*  .flip-container:hover .flipper,  */

  .flip-container.hover .flipper {
    -webkit-transform: rotateY(180deg);
    -moz-transform: rotateY(180deg);
    -o-transform: rotateY(180deg);
    transform: rotateY(180deg);
  }

.flip-container, .front, .back {
  background: #244052;
  width: 100%;
}

.flipper {
  -webkit-transition: 0.5s;
  -webkit-transform-style: preserve-3d;

  -moz-transition: 0.5s;
  -moz-transform-style: preserve-3d;
  
  -o-transition: 0.5s;
  -o-transform-style: preserve-3d;

  transition: 0.5s;
  transform-style: preserve-3d;

  position: relative;
}

.front, .back {
  -webkit-backface-visibility: hidden;
  -moz-backface-visibility: hidden;
  -o-backface-visibility: hidden;
  backface-visibility: hidden;
  position: absolute;
  top: 0;
  left: 0;
}

.front {
  background: red;
  z-index: 2;
}

.back {
  -webkit-transform: rotateY(180deg);
  -moz-transform: rotateY(180deg);
  -o-transform: rotateY(180deg);
  transform: rotateY(180deg);.
  clear: both;
  
}

.front .name {
  font-size: 2em;
  display: inline-block;
  background: rgba(33, 33, 33, 0.9);
  color: #f8f8f8;
  font-family: Courier;
  padding: 5px 10px;
  border-radius: 5px;
  bottom: 10px;
  left: 14%;
  position: absolute;
  text-shadow: 0.1em 0.1em 0.05em #333;
/*
  -webkit-transform: rotate(-20deg);
  -moz-transform: rotate(-20deg);
  -o-transform: rotate(-20deg);
  transform: rotate(-20deg);
*/
}


.back-title {
  font-weight: bold;
  color: #00304a;
  position: absolute;
  top: 180px;
  left: 0;
  right: 0;
  text-align: center;
  text-shadow: 0.1em 0.1em 0.05em #acd7e5;
  font-family: Courier;
  font-size: 2em;
 
}
 

.animate
{
  transition: all 0.1s;
  -webkit-transition: all 0.1s;
}

.action-button
{
  /*position: relative;*/
  padding: 10px 40px;
  margin: 0px 10px 10px 0px;
  /*float: left;*/
  border-radius: 10px;
  font-family: 'Pacifico', cursive;
  font-size: 20px;
  color: #FFF;
  text-decoration: none;  
}

.blue
{
  background-color: #3498DB;
  border-bottom: 5px solid #2980B9;
  text-shadow: 0px -2px #2980B9;
}

.red
{
  background-color: #E74C3C;
  border-bottom: 5px solid #BD3E31;
  text-shadow: 0px -2px #BD3E31;
}

.green
{
  background-color: #82BF56;
  border-bottom: 5px solid #669644;
  text-shadow: 0px -2px #669644;
}

.yellow
{
  background-color: #F2CF66;
  border-bottom: 5px solid #D1B358;
  text-shadow: 0px -2px #D1B358;
}

.action-button:active
{
  transform: translate(0px,5px);
  -webkit-transform: translate(0px,5px);
  border-bottom: 1px solid;
} 
.ssearchresult{
  display: none;
   width: calc(100% - 14px);
    background: #244052;
    height: auto;
    overflow: hidden;
    -webkit-box-shadow: 3px 3px 5px 0px rgba(0,0,0,0.35);
    -moz-box-shadow: 3px 3px 5px 0px rgba(0,0,0,0.35);
    box-shadow: 3px 3px 5px 0px rgba(0,0,0,0.35);
    margin: 2px;
    position: absolute;
    z-index: 10;
    color: #fff;
}
.searchitems {
    width: calc(100% );
    background: #244052;
    height: auto;
    overflow: hidden;
    padding: 5px;
    z-index: 10;
    color: #fff;
    display: block;
}
.searchitemsinfo {
    word-wrap: break-word;
    font-size: 0.8em;
    text-align: center;
    padding-top: 10px;
}
.searchitems:hover {
    text-decoration: none;
    background: #42535f;
    cursor: pointer;
    border-right: 1px solid;
    display: block;
}
.searchitemscontent {
    color: #7a7a7a;
    font-size: 0.9em;
}
.addwatch {
  background-color: #354d5d !important;
  padding: 1px;

}
.addwatch li{
  font-size: 0.8em;
  color: #fff;
  padding: 5px;

}
.addwatch li:hover{
    text-decoration: none;
    background: #42535f;
    cursor: pointer;
    border-right: 1px solid;
    display: block;

}
</style>

<div id="page-wrapper" style="padding-top: 55px;">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="panel panel-primary ">
                  <div class="panel-heading">
                    <button type="button" class="btn icon btn-transparent">
                        <i class="fa fa-refresh btn-icon" aria-hidden="true"></i></button>
                    <button type="button" class="btn icon  btn-transparent">
                        <i class="fa fa-bars btn-icon" aria-hidden="true"></i></button>
                    <input class=" btn-transparent btn" type="text" name="search" placeholder="جستجوی سفارش" style="width: calc(100% - 78px);">
                  </div>
                  <div class="panel-body">

                  </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-12">
               <div class="panel panel-primary ">
                  <div class="panel-heading">
                    <input class="stockautocomplete btn-transparent btn" type="text" name="stockautocomplete" onkeyup="ssearch()" placeholder="جستجوی نماد" style="width: calc(100% );">
                    <div class="ssearchresult">
                      
                    </div>
                    
                  </div>
                  <div class="panel-body ">
                        <div class="card">
                          <div class="card-block">
                            <h5 class="card-title" style="float: right;margin: 0px;"><?=$pageinfo['InstrumentName'];?> <label class="label "><?=$pageinfo['InstrumentTitle'];?></label></h5>
                            
                            <button type="button" class="btn btn-padding btn-warning btn-transparent" onclick="showsellbox()">فروش</button>
                        <button type="button" class="btn btn-padding btn-info btn-transparent" onclick="showbuybox()">خرید</button>
                          </div>
                        </div>
                        <div class="card panel-transparent">
                          <div class="card-block">
                            <div style="padding: 5px">
                              <h5 class="" style="float: right;margin: 0px;margin-right: 10px; direction: ltr !important;">
                                <label style="font-size: .8rem; " class="label ">  (<?=$pageinfo['ReferencePriceVariationPercent'];?>%) <?=$pageinfo['ReferencePriceVariation'];?>
                                </label> 
                                <?=$pageinfo['LastTradePrice'];?>
                                 
                              </h5>
                              <div class="dropdown" id="addwatch">
                                <button type="button" class="btn icon  btn-transparent dropdown-toggle" data-toggle="dropdown" >اضافه کردن به دیدبان <span class="caret"></span></button>

                                <ul  class="dropdown-menu addwatch">
                                  <?php
                                  if(is_array($watchlists))
                                  foreach ($watchlists as $key => $value) {
                                    echo '<li  onclick="addtowhatchlist('.$value['watchlist_id'].')">'.$value['title'].'</li>';
                                  }
                                  ?>
                                  <li class="text-info" onclick="watchlistmodel()">+ ایجاد دیدبان جدید</li>
                                </ul>
                              </div> 
                            </div>
                            <div class="table-responsive no-border ">
                              <table class="table " style="direction: rtl;">
                                <thead>
                                    <th>آخرین معامله</th>
                                    <th>نوع بازار</th>
                                    <th>قیمت پایانی</th>
                                    <th>ارزش معاملات</th>
                                    <th>حجم مبنا</th>
                                    <th>حجم (تعداد)</th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=$pageinfo['LastTradeDate'];?></td>
                                        <td>سهام <?=$pageinfo['ExchangeName'];?></td>
                                        <td><?=$pageinfo['ClosingPrice'];?> <br> <span>%<?=$pageinfo['ClosingPriceVariation'];?></span></td>
                                        <td><?=$pageinfo['TotalTradeValue'];?></td>
                                        <td><?=$pageinfo['BaseQuantity'];?></td>
                                        <td><?=$pageinfo['TotalNumberOfSharesTraded'];?> <br> (<?=$pageinfo['TotalNumberOfTrades'];?>)</td>
                                    </tr>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>

<?php
$sumbuy=$pageinfo['qo1']+$pageinfo['qo2']+$pageinfo['qo3'];
$sumsell=$pageinfo['qd1']+$pageinfo['qd2']+$pageinfo['qd3'];
$totalsum=$sumbuy+$sumsell;


?>

                <div class="card ">
                    <div class="card-block">
                      <h5 class="block-title" style="float: right;margin: 0px;">بهترین عرضه و تقاضا</h5>
                    </div>
                     <div class="card panel-transparent">
                      <div class="card-block" >
                        <div class="row" style="margin: 0px;">
                            <div  style="width: 90%;  margin: 15px auto 20px auto;">
                                <div style="width: 50%; float: right;">
                                    <div class="progress 2sidebar"  style=" background-color: #7b92a1 !important;">
                                      <div class="progress-bar progress-bar-info" role="progressbar" style="width:<?=(($sumsell-$totalsum)/$totalsum*100)+100;?>%">
                                      </div>
                                    </div>
                                </div>
                                <div style="width: 50%;float: right;">
                                    <div class="progress progress-rtl " style=" background-color: #7b92a1 !important;">
                                      <div class="progress-bar progress-bar-warning" role="progressbar" style="width:<?=(($sumbuy-$totalsum)/$totalsum*100)+100;?>%">
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12" style="padding: 15px">
                                <div class="table-responsive no-border " >
                                  <table class="table " style="direction: rtl;">
                                    <thead>
                                        <th>تعداد</th>
                                        <th>حجم</th>
                                        <th></th>
                                        <th>قیمت</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="15px"><?=$pageinfo['zo1'];?></td>
                                            <td><?=$pageinfo['qo1'];?></td>
                                            <td style="min-width:50px; "> 
                                                <div class="progress progress-rtl">
                                                  <div class="progress-bar progress-bar-warning" role="progressbar" style="width:<?=(($pageinfo['qo1']-$sumbuy)/$sumbuy*100)+100;?>%">
                                                  </div>
                                                </div>
                                            </td>
                                            <td><?=$pageinfo['po1'];?></td>
                                        </tr>
                                        <tr>
                                            <td width="15px"><?=$pageinfo['zo2'];?></td>
                                            <td><?=$pageinfo['qo2'];?></td>
                                            <td style="min-width:50px; "> 
                                                <div class="progress progress-rtl">
                                                  <div class="progress-bar progress-bar-warning" role="progressbar" style="width:<?=(($pageinfo['qo2']-$sumbuy)/$sumbuy*100)+100;?>%">
                                                  </div>
                                                </div>
                                            </td>
                                            <td><?=$pageinfo['po2'];?></td>
                                        </tr>
                                        <tr>
                                            <td width="15px"><?=$pageinfo['zo3'];?></td>
                                            <td><?=$pageinfo['qo3'];?></td>
                                            <td style="min-width:50px; "> 
                                                <div class="progress progress-rtl">
                                                  <div class="progress-bar progress-bar-warning" role="progressbar" style="width:<?=(($pageinfo['qo3']-$sumbuy)/$sumbuy*100)+100;?>%">
                                                  </div>
                                                </div>
                                            </td>
                                            <td><?=$pageinfo['po3'];?></td>
                                        </tr>
                                        
                                    </tbody>
                                  </table>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-12 col-sm-12" style="padding: 15px">
                                <div class="table-responsive no-border ">
                                      <table class="table " style="direction: rtl;">
                                        <thead>
                                            <th>تعداد</th>
                                            <th>حجم</th>
                                            <th></th>
                                            <th>قیمت</th>
                                        </thead>
                                        <tbody>
                                          <tr>
                                            <td width="15px"><?=$pageinfo['zd1'];?></td>
                                            <td><?=$pageinfo['qd1'];?></td>
                                            <td style="min-width:50px; "> 
                                                <div class="progress progress-rtl">
                                                  <div class="progress-bar progress-bar-info" role="progressbar" style="width:<?=(($pageinfo['qd1']-$sumsell)/$sumsell*100)+100;?>%">
                                                  </div>
                                                </div>
                                            </td>
                                            <td><?=$pageinfo['pd1'];?></td>
                                          </tr>
                                          <tr>
                                              <td width="15px"><?=$pageinfo['zd2'];?></td>
                                              <td><?=$pageinfo['qd2'];?></td>
                                              <td style="min-width:50px; "> 
                                                  <div class="progress progress-rtl">
                                                    <div class="progress-bar progress-bar-info" role="progressbar" style="width:<?=(($pageinfo['qd2']-$sumsell)/$sumsell*100)+100;?>%">
                                                    </div>
                                                  </div>
                                              </td>
                                              <td><?=$pageinfo['pd2'];?></td>
                                            </tr>
                                            <tr>
                                                <td width="15px"><?=$pageinfo['zd3'];?></td>
                                                <td><?=$pageinfo['qd3'];?></td>
                                                <td style="min-width:50px; "> 
                                                    <div class="progress progress-rtl">
                                                      <div class="progress-bar progress-bar-info" role="progressbar" style="width:<?=(($pageinfo['qd3']-$sumsell)/$sumsell*100)+100;?>%">
                                                      </div>
                                                    </div>
                                                </td>
                                                <td><?=$pageinfo['pd3'];?></td>
                                            </tr>
                                            </tbody>
                                          </table>
                                        </div>
                                    </div>
                            </div>
                        </div>
                      </div>
                    </div>
                    <div class="card ">
                      <div class="card-block">
                        <h5 class="block-title" style="float: right;margin: 0px;"> روند قیمت </h5>
                      </div>
                        <div class="card panel-transparent">
                          <div class="card-block">
                             <?=(isset($mainchart)) ? $mainchart : "" ;?>
                          </div>
                        </div>
                    </div>
                    
                  </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="panel panel-primary ">
                  <div class="panel-heading">
                    <div class="card ">
                      <div class="card-block">
                       <h5 class="block-title" style="float: right;margin: 0px;margin-bottom: 10px;"> دیدبان من </h5>
                      </div>
                      <div class="card-block">
                        <select class=" btn-transparent btn" style="width: calc(100% ); direction: rtl; text-align: center;">
                            <?php
                            if(is_array($watchlists))
                                  foreach ($watchlists as $key => $value) {
                                    echo '<option  onclick="changetowhatchlist('.$value['watchlist_id'].')">'.$value['title'].'</option>';
                                  }
                              ?>

                        </select> 
                      </div>
                      <div class="panel-body">
                        <div class="card panel-transparent">
                          <div class="card-block">
                            <div class="table-responsive no-border ">
                              <table class="table table-hover watchlist" >
                                <thead>
                                    <th>نماد</th>
                                    <th>حجم</th>
                                    <th>آخرین قیمت</th>
                                    <th>پیشینه قیمت</th>
                                    <th>تقاضا</th>
                                    <th>عرضه</th>
                                    <th>کمینه قیمت</th>
                                </thead>
                                <tbody>
                                    <?php
                                      if(is_array($watchlist_details))
                                      foreach ($watchlist_details as $key => $value) {
                                        echo '
                                        <tr>
                                          <td class="t-label"><label class="text-warning" style=" padding-left: 3px;"> ■ </label> '.$value['title_fa'].' </td>
                                          <td>0</td>
                                          <td>3,820</td>
                                          <td>0</td>
                                          <td>3,700</td>
                                          <td>3,889</td>
                                          <td></td>
                                        </tr>
                                        ';
                                    }
                                  ?>

                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    <div class="card ">
                      <div class="card-block">
                        <h5 class="block-title" style="float: right;margin: 0px;"> وضعیت بازار </h5>
                      </div>
                        <div class="card panel-transparent">
                          <div class="card-block">
                            <div class="flipButton" >
                              <i class=" fa  fa-clone  fa-lg fa-fw"></i>
                            </div>
                            <div class="flip-container" >
                              <div class="flipper"> 
                                <!-- Front side -->
                                <div class="col-md-6 " style="float: left;">
                                  <div class="info-block">
                                      <h6>شاخص بورس</h6>
                                      <p>85,895.0</p>
                                      <a class="text-info">192.2 (%0.22)</a>
                                  </div>
                                  <div class="info-block">
                                      <h6>شاخص فرابورس</h6>
                                      <p>961.0</p>
                                      <a class="text-info" >0.7 (%0.7)</a>
                                  </div>
                                  <div class="info-block">
                                      <label>مانده کل:</label>
                                      <label>بلوکه شده:</label>
                                      <label>قابل برداشت:</label>                                                              
                                  </div>
                                </div>
                                <div class="col-md-6 "  style="float: right; padding-top: 50px;">
                                    <?=(isset($clock)) ? $clock : "" ;?>
                                </div>
                                <!-- End Front side -->
                                <!-- Back side -->
                                <div class="back">
                                  <div class="col-md-6 " style="float: left;">
                                    <div class="info-block">
                                        <h6>شاخص بورس</h6>
                                        <p>85,895.0</p>
                                        <a class="text-info">192.2 (%0.22)</a>
                                    </div>
                                    <div class="info-block">
                                        <h6>شاخص فرابورس</h6>
                                        <p>961.0</p>
                                        <a class="text-info" >0.7 (%0.7)</a>
                                    </div>
                                    <div class="info-block">
                                        <label>مانده کل:</label>
                                        <label>بلوکه شده:</label>
                                        <label>قابل برداشت:</label>                                                              
                                    </div>
                                  </div>
                                  <div class="col-md-6 "  style="float: right; margin: 0px !important;padding: 0px;padding-top: 20px;">
                                       <?=(isset($circlechart)) ? $circlechart : "" ;?>
                                  </div>
                                </div>
                                <!-- End Back side -->
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->



<!-- Modal -->
<div class="modal fade" id="watchlistmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body card">
        <h6 style="text-align: center !important;">اضافه کردن دیدبان جدید</h6>
        <div class="content">
          <div style="padding: 60px 40px; text-align: center;">
            <div class="form-group">
                <input style="background: #0b2332 !important; color: #fff; border-color: #FFF;" placeholder="نام دیدبان" class="form-control" type="text" name="watchname" required="required" />
            </div>
            <label class="control-label" style="font-size: 0.8em;">با ایجاد دیدبان شما قادر خواهید بود سهم سهام مورد نظر را دنبال کنید.</label>
          </div>
        </div>
        <div class="model-footer ">
          <button class="btn btn-primary saverisk" onclick="addwatchlist()"> موافقم </button>
          <button class="btn btn-default " onclick="cancelmodal()"> انصراف </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="buyboxmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body card">
        <div class="container ">
  
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="sellboxmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body card">
        <div class="container ">
  
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  function showbuybox(argument) {
    $('#buyboxmodal').modal('show');
  }

  function showsellbox(argument) {
    $('#buyboxmodal').modal('show');
  }

function watchlistmodel(argument) {
    $('#watchlistmodel').modal('show');
  }
function cancelmodal(argument) {
    $('.modal').modal('hide');
  }

$(document).ready(function(){
    $('.flipButton').bind("click", function() {
      $(this).next().toggleClass('hover');
    });

    

});
var typingTimer;                //timer identifier
var doneTypingInterval = 500;  
//on keyup, start the countdown
function ssearch(){
  clearTimeout(typingTimer);
  typingTimer = setTimeout(doneTyping, doneTypingInterval);
}

function doneTyping() {
  $("div.ssearchresult").html("");
  $('div.ssearchresult').css('display','none');
 var values = {
    userkey:'<?=$this->session->userdata('billogged_in')['userkey'];?>',
    keyword:$("input[name=stockautocomplete]").val()
  };
  $.ajax({
      url: '<?php echo base_url();  ?>actions/ssearch',
          type: 'POST',
          dataType: 'json',
          data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
      success:function(data)
      {
        var result = data.result;
        if(result.error){
          $.each(result['error_detalis'], function (index, object) {
                response('ارتباط قطع می باشد');
          });
           $('div.ssearchresult').css('display','none');
        }else{
          if(result.data){
            var founder="";
            $.each(result.data, function (index, object) {
              if(object!="")
                founder+='<a class="searchitems" href="'+object.link+'"><div class="row" style="margin: 0px;"><div class="col-md-10 col-sm-8"><div class="searchitemsheader">'+object.title_fa+'</div><div class="searchitemscontent">'+object.name+'</div></div><div class="col-md-2 col-sm-4 searchitemsinfo">'+object.market+'</div></div></a>';
            });
            $('div.ssearchresult').css('display','block');
            $('div.ssearchresult').html(founder);
          }
        }
      }
    });
 
}


function addwatchlist() {
  
 var values = {
    userkey:'<?=$this->session->userdata('billogged_in')['userkey'];?>',
    keyword:$("input[name=watchname]").val()
  };
  $.ajax({
      url: '<?php echo base_url();  ?>actions/addwatchlist',
          type: 'POST',
          dataType: 'json',
          data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
      success:function(data)
      {
        var result = data.result;
        if(result.error){
          $.each(result['error_detalis'], function (index, object) {
          });
          $("input[name=watchname]").val("");
        }else{
          if(result.data){
                $('ul.addwatch li:eq(0)').before('<li onclick="addtowhatchlist('+result.data.watchid+')">'+result.data.title+'</li>');
            }; 
            $("input[name=watchname]").val(""); 
             $('.modal').modal('hide');          
          }
        }
    });
}
function addtowhatchlist(wid) {
  
 var values = {
    userkey:'<?=$this->session->userdata('billogged_in')['userkey'];?>',
    wathid:wid,
    symbol:'<?=$pageinfo['SymbolId'];?>'
  };
  $.ajax({
      url: '<?php echo base_url();  ?>actions/addtowatchlist',
          type: 'POST',
          dataType: 'json',
          data: {<?php echo $this->security->get_csrf_token_name(); ?>:'<?php echo $this->security->get_csrf_hash(); ?>',data:values},
      success:function(data)
      {
        var result = data.result;
        if(result.error){
          $.each(result['error_detalis'], function (index, object) {
          });
        }else{
          if(result.data){
                $('table.watchlist tbody tr:eq(0)').before('<tr><td class="t-label"><label class="text-warning" style=" padding-left: 3px;"> ■ </label> '+result.data+' </td><td> '+result.data+' </td><td> '+result.data+' </td><td> '+result.data+' </td><td> '+result.data+' </td><td> '+result.data+' </td><td></td></tr>');
            };            
          }
        }
    });
}


</script>