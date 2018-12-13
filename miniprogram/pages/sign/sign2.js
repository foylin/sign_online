
var api     = require('../../utils/api.js');
var app     = getApp();

Page({
  
    // 视图数据
    data: {
      selectColor: 'black'
    },

    onLoad(params) {
      this.params = params;
      console.log(this.params)
      // return;
      if (params.post_id) {
        // wx.showNavigationBarLoading();
        wx.showLoading({title: '生成中...'})
        api.get({
            url: 'protocol/lists/sec_through?post_id=' + params.post_id + '&pcup_id=' + params.pcup_id,
            data: {},
            success: data => {
                // wx.hideNavigationBarLoading();
                wx.hideLoading()
                if (data.code == 0) {
                  wx.showModal({
                    content: data.msg,
                    showCancel: false,
                    success: function (res) {
                        if (res.confirm) {
                            console.log('用户点击确定')
                            
                        }
                    }
                  })
                }else{

                  wx.showToast({
                    title: '审批成功',
                    icon: 'none',
                    duration: 1000,
                    
                  })

                    setTimeout(function(){
                        // wx.navigateBack({
                        //     delta: 1
                        // })
                        wx.switchTab({
                            url: '/pages/index/index'
                        });
                    }, 1000)

                    
                    
                }
            },
            fail: err => {
                // wx.hideNavigationBarLoading();
                wx.hideLoading()
                wx.showToast({
                  title: '审批失败',
                  icon: 'none',
                  duration: 1000,
                  
                })

                setTimeout(function(){
                    // wx.navigateBack({
                    //     delta: 1
                    // })
                    wx.navigateTo({
                        url: '/pages/index/index'
                    });
                }, 1000)
            }
        });
    }
    }
  })