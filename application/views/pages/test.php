
<script type="text/javascript">

//  OmsClientTokenHubProxy._hubConnection = $.hubConnection("https://shahr-online.com/realtime");

// public static GetToken(userId: string, password: string, captcha: string) {
//             var def = $.Deferred();
//             OmsClientTokenHubProxy._proxy.invoke("GetToken", userId, password, captcha).done(result => {

//                 if (Common.Util.ProcessError(result, def)) {
//                     OmsClientTokenHubProxy._hubConnection.stop();
//                     def.resolve(result);
//                 }
//             });
//             return def.promise();
//         }


//       OmsClientTokenHubProxy.GetToken('hosi50028', '6spss').done(token => {
//                    
//            });
// OmsClientTokenHubProxy._proxy.invoke("GetToken", userId, password, captcha).done();


// var connection = $.connection('https://shahr-online.com/realtime');
// connection.received(function(data) {
//     console.log(data);
// });
// connection.error(function(error) {
//     console.warn(error);
// });
var connection = $.hubConnection('http://shahr-online.com/realtime');
 var OmsClientTokenHubProxy=connection.start();
// alert(JSON.stringify(connection));
       // OmsClientTokenHubProxy.GetToken('hosi50028', '6spss').done(token => {
                   
       //     });
       // OmsClientTokenHubProxy.OmsClientTokenHub();
	
// connection.error(function(error) {
//     console.warn(error);
// });
// var OmsClientTokenHubProxy = $.connection.OmsClientTokenHub();
// $connection.invoke('GetToken','hosi50028', '6spss').done(function(data){
// 	console.log(data);
//  }).fail(function(data){ console.log(data); });
// $.connection.hub.start().done(function (data) {
//     console.log(data);
    
// });

// var OmsClientTokenHub= connection.OmsClientTokenHub();
// //var OmsClientTokenHub = connection.createHubProxy('OmsClientTokenHub');

// OmsClientTokenHub.invoke('GetToken','hosi50028', '6spss').done(function(){

//  }).fail(function(){ console.log('Could not connect'); });



 
// // receives broadcast messages from a hub function, called "broadcastMessage"
// proxy.on('broadcastMessage', function(message) {
//     console.log(message);
// });
 
// // atempt connection, and handle errors
// connection.start({ jsonp: true })
// .done(function(){ console.log('Now connected, connection ID=' + connection.id); })
// .fail(function(){ console.log('Could not connect'); });
// }
</script>