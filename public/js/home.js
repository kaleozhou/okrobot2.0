window.setInterval(refresh,1000);
// 对Date的扩展，将 Date 转化为指定格式的String   
// 月(M)、日(d)、小时(h)、分(m)、秒(s)、季度(q) 可以用 1-2 个占位符，   
// 年(y)可以用 1-4 个占位符，毫秒(S)只能用 1 个占位符(是 1-3 位的数字)   
// 例子：   
// (new Date()).Format("yyyy-MM-dd hh:mm:ss.S") ==> 2006-07-02 08:09:04.423   
// (new Date()).Format("yyyy-M-d h:m:s.S")      ==> 2006-7-2 8:9:4.18   
Date.prototype.Format = function(fmt)   
{ //author: meizz   
  var o = {   
    "M+" : this.getMonth()+1,                 //月份   
    "d+" : this.getDate(),                    //日   
    "h+" : this.getHours(),                   //小时   
    "m+" : this.getMinutes(),                 //分   
    "s+" : this.getSeconds(),                 //秒   
    "q+" : Math.floor((this.getMonth()+3)/3), //季度   
    "S"  : this.getMilliseconds()             //毫秒   
  };   
  if(/(y+)/.test(fmt))   
    fmt=fmt.replace(RegExp.$1, (this.getFullYear()+"").substr(4 - RegExp.$1.length));   
  for(var k in o)   
    if(new RegExp("("+ k +")").test(fmt))   
  fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (o[k]) : (("00"+ o[k]).substr((""+ o[k]).length)));   
  return fmt;   
}  
function refresh(){
    $.ajax({
        type: 'GET',
        url: '/home/refresh',
        data: { date : '2015-03-12'},
        dataType: 'json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        },
        success: function(data){

            document.getElementById("profit").innerText =data.profit+"%";
            //userinfo
            document.getElementById("asset_net").innerText = data.userinfo.asset_net;
            document.getElementById("free_btc").innerText = data.userinfo.free_btc;
            document.getElementById("free_ltc").innerText = data.userinfo.free_ltc;
            document.getElementById("free_cny").innerText = data.userinfo.free_cny;
            document.getElementById("asset_total").innerText = data.userinfo.asset_total;
            document.getElementById("zhuanle").innerText = "盈利："+(data.userinfo.asset_total-data.user.cost).toFixed(2);
            document.getElementById("updated_at").innerText = new Date().Format("yyyy-MM-dd hh:mm:ss");
            if (data.user.btc_autotrade==1) {
                //btc_ticker
                document.getElementById("btc_last_price").innerText = data.btc_ticker.last_price;
                document.getElementById("btc_my_last_price").innerText = data.set.btc_my_last_price;
                document.getElementById("btc_n_price").innerText = data.set.btc_n_price;
                document.getElementById("btc_dif").innerText = (data.btc_ticker.last_price-data.set.btc_my_last_price).toFixed(2);
                document.getElementById("btc_up_dif").innerText = data.set.btc_n_price*data.set.uprate;
                document.getElementById("btc_down_dif").innerText = data.set.btc_n_price*data.set.downrate;
            };
            if (data.user.ltc_autotrade==1) {
                //ltc_ticker
                document.getElementById("ltc_last_price").innerText = data.ltc_ticker.last_price;
                document.getElementById("ltc_my_last_price").innerText = data.set.ltc_my_last_price;
                document.getElementById("ltc_n_price").innerText = data.set.ltc_n_price;
                document.getElementById("ltc_dif").innerText = (data.ltc_ticker.last_price-data.set.ltc_my_last_price).toFixed(2);
                document.getElementById("ltc_up_dif").innerText = data.set.ltc_n_price*data.set.uprate;
                document.getElementById("ltc_down_dif").innerText = data.set.ltc_n_price*data.set.downrate;
            };
            //刷新订单表
                var ddtable=document.getElementById("ddtable");

                //删除最近的最后一条
                for (var i = 0; i < 5; i++) {
                ddtable.deleteRow(1);
                var newRow = ddtable.insertRow(); //创建新行
                var newCell_avg_price = newRow.insertCell(); //创建新单元格
                var newCell_deal_amount = newRow.insertCell(); 
                var newCell_symbol = newRow.insertCell(); 
                var newCell_ordertype = newRow.insertCell(); 
                var newCell_create_date = newRow.insertCell(); 
                newCell_avg_price.innerHTML = data.orderinfos.data[i].avg_price; 
                newCell_deal_amount.innerHTML = data.orderinfos.data[i].deal_amount; 
                newCell_symbol.innerHTML = data.orderinfos.data[i].symbol; 
                var ordertype = data.orderinfos.data[i].ordertype; 
                if (ordertype=='buy_market') {
                newCell_ordertype.innerHTML = '买入'; 
                }
                else
                {
                newCell_ordertype.innerHTML = '卖出'; 
                }
                ;
                newCell_create_date.innerHTML = data.orderinfos.data[i].create_date; 
                };

        },
        error: function(xhr, type){
            //                alert('Ajax error!')
        }
    });
}
