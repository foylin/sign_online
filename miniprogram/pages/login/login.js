var api = require('../../utils/api.js')
var app = getApp()
Page({
    data: {},

    onLoad() {
        // console.log(wx.getStorageSync('token'));
        // let token = wx.getStorageSync('token');
        
    },
    formSubmit: function (e) {
        //console.log(api.json2Form(e.detail.value));
        console.log(e.detail.value);
        e.detail.value.device_type = 'wxapp';
        api.post({
            url: 'user/public/login',
            data: e.detail.value,
            success: data => {
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
                }

                if (data.code == 1) {
                    // wx.showToast({
                    //     title: '登录成功!',
                    //     icon: 'success',
                    //     duration: 2000
                    // });

                    try {
                        wx.setStorageSync('login', '1');
                        wx.setStorageSync('token', data.data.token);
                        wx.setStorageSync('user', data.data.user);
                        wx.navigateBack({
                            delta: 1
                        });
                    } catch (e) {
                        console.log(e);
                        // Do something when catch error
                    }

                    wx.navigateTo({
                        url: '/pages/index/index'
                    });

                }


                console.log(data);
            }
        });
    },
    handleGetUserInfo(){
        api.login();
    }
})
