#系统开发笔记
##策略
###概述
####目标
    根据okcoin的系统情况自动，持续的盈利。包含所有的市场情况
    - 市场上涨
    - 市场急速下跌
    - 市场波动
    - 市场横盘
####原理
    根据海龟算法严格控制仓位，买入，卖出，离场
#####指标
    1. unit 下单的单位，百分比为单位例：0.1，总资金量的asset_tol****unit
    2. n_price 价值波动，近期n（天，30min，15min)的最高价-最低价之间的平均值
    3. uprate 当当前价格高于上次成交价的时候，判断买入信号（当前价格差与uprate*n_price比较）
    4. downrate 当当前价格低于上次成交价的时候，判断卖出信号（价格差与downrate*n_price比较）
    5. downline 止损值
    6. upline 止盈值
####接下来要添加的功能 2016-12-26 
    - 添加ltc测试
    - 用户自己设置止损值
    - 添加copyright标志 ©2016 OKROBOT
####完成策略一到LTC的移植策略一使用2016-12-26
####经过一天的运行发现策略一和ltc不匹配    损失500元 2016-12-27
    着手开发策略2 改进所有方法采用高抛低吸的高频策略
####策略二已经开发完成正在运行 2016-12-28
    经过一天的额运行，无语了，ltc的人为因素太大了，策略二亏损1200 2016-12-28
    继续运行至晚上，如果再不盈利我将放弃开发策略二，回归改良后的策略一至BTC,并将长期运行
####回归正统后策略一运行BTC一切正常，目前盈利 2016-12-29
    

