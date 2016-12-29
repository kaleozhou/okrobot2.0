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
                document.getElementById("cost").innerText = data.user.cost;
                document.getElementById("zhuanle").innerText = data.user.zhuanle;
                document.getElementById("profit").innerText = round(data.profit,2);
                document.getElementById("asset_net").innerText = data.userinfo.asset_net;
                document.getElementById("free_btc").innerText = data.userinfo.free_btc;
                document.getElementById("free_ltc").innerText = data.userinfo.free_ltc;
                document.getElementById("free_cny").innerText = data.userinfo.free_cny;
                document.getElementById("asset_total").innerText = data.userinfo.asset_total;
                document.getElementById("btc_last_price").innerText = data.btc_ticker->last_price;
                document.getElementById("cost").innerText = data.user.cost;
                document.getElementById("cost").innerText = data.user.cost;
                document.getElementById("cost").innerText = data.user.cost;
                document.getElementById("cost").innerText = data.user.cost;
                document.getElementById("cost").innerText = data.user.cost;
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
}
var reload=window.setInterval(refresh,3000);
