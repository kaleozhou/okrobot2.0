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
                document.getElementById("asset_net").innerText = data.userinfo.asset_net;
                document.getElementById("free_btc").innerText = data.userinfo.free_btc;
                document.getElementById("free_ltc").innerText = data.userinfo.free_ltc;
                document.getElementById("free_cny").innerText = data.userinfo.free_cny;
                document.getElementById("zhuanle").innerText = "盈利："+(data.userinfo.asset_total-data.user.cost).toFixed(2);
                document.getElementById("updated_at").innerText = data.userinfo.updated_at;
//                document.getElementById("btc_last_price").innerText = data.btc_ticker.last_last_price;
            },
            error: function(xhr, type){
//                alert('Ajax error!')
            }
        });
}
