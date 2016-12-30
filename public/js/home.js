window.setInterval(refresh,1000);

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
                document.getElementById("updated_at").innerText = data.userinfo.updated_at;
                if (data.user.btc_autotrade==1) {
                //btc_ticker
                document.getElementById("btc_last_price").innerText = data.btc_ticker.last_price;
                document.getElementById("btc_my_last_price").innerText = data.set.btc_my_last_price;
                document.getElementById("btc_n_price").innerText = data.set.btc_n_price;
                document.getElementById("btc_dif").innerText = (data.btc_ticker.last_price-data.set.btc_my_last_price).toFixed(2);
                document.getElementById("btc_up_dif").innerText = data.set.btc_n_price*data.set.uprate;
                document.getElementById("btc_down_dif").innerText = data.set.btc_nprice*data.set.downrate;
                };
                if (data.user.ltc_autotrade==1) {
                //ltc_ticker
                document.getElementById("ltc_last_price").innerText = data.ltc_ticker.last_price;
                document.getElementById("ltc_my_last_price").innerText = data.set.ltc_my_last_price;
                document.getElementById("ltc_n_price").innerText = data.set.ltc_n_price;
                document.getElementById("ltc_dif").innerText = (data.ltc_ticker.last_price-data.set.ltc_my_last_price).toFixed(2);
                document.getElementById("ltc_up_dif").innerText = data.set.ltc_n_price*data.set.uprate;
                document.getElementById("ltc_down_dif").innerText = data.set.ltc_nprice*data.set.downrate;
                };
            },
            error: function(xhr, type){
//                alert('Ajax error!')
            }
        });
}
