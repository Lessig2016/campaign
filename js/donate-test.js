var PLEDGE_URL = "https://pledge-test.lessigforpresident.com";
var RECEIPT_URL = "/thank-you-test";

function step2(amount){
  $(".step-1-container").hide("slow");
  $("#step-1").removeClass("active");
  $("#step-2").addClass("active");
  //$("#pledgeBox").animate({height: "auto"}, 500);
  if( amount > 0 ) {
    $("#amount_input").val(amount);
    $("#amount_input").parent().hide();
  }
  $(".step-2-container").show("slow");
}
    
function step3(){
  $("#step-2").removeClass("active");
  $("#step-3").addClass("active");
}
    
function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function get_browser_info(){
    var ua=navigator.userAgent,tem,M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) || []; 
    if(/trident/i.test(M[1])){
        tem=/\brv[ :]+(\d+)/g.exec(ua) || []; 
        return {name:'IE',version:(tem[1]||'')};
        }   
    if(M[1]==='Chrome'){
        tem=ua.match(/\bOPR\/(\d+)/)
        if(tem!=null)   {return {name:'Opera', version:tem[1]};}
        }   
    M=M[2]? [M[1], M[2]]: [navigator.appName, navigator.appVersion, '-?'];
    if((tem=ua.match(/version\/(\d+)/i))!=null) {M.splice(1,1,tem[1]);}
    return {
      name: M[0],
      version: M[1]
    };
}

var ALREADY_BANKED = 1000000;
var GOAL_DOLLARS = 5000000;

    $(function() {
      var date = new Date();
      date.setTime(date.getTime()+(24*60*60*1000));
      document.cookie = ("last_team_key={{team.key()}};" +
                         "expires=" + date.toGMTString() +
                         ";domain=.lessigforpresident.com;path=/");
      var browserInfo = get_browser_info()
      if (browserInfo.name == 'Firefox') {
        console.log("detected FF version: " + browserInfo.version);
        if (browserInfo.version < 17) {
          $('#pledgeBox .info').after('<div class="alert-danger row">Sorry, we are not supporting older Firefox versions at the moment. Please try another browser for now.</div>');
        } else {
          console.log('Firefox version was OK: ' + browserInfo.version);
        }
      }
    });
