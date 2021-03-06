var api = require('../../utils/api.js')
var app = getApp()
Page({
    data: {
        username: '',
        password: '',
        res:{
            pwd:true,
            src:"../../images/nolook.png",
            src2:"../../images/close.png"
        },
        close: false,
        isfocus: true
    },

    onLoad() {
        // console.log(wx.getStorageSync('token'));
        // let token = wx.getStorageSync('token');
    },
    formSubmit: function (e) {
        //console.log(api.json2Form(e.detail.value));
        // console.log(e.detail.value);

        // e.detail.value.device_type = 'wxapp';
        let {username, password} = this.data;
        let d = {
            username:username, 
            password:password, 
            device_type: 'wxapp'
        }
        console.log(d);
        api.post({
            url: 'user/public/login',
            // data: e.detail.value,
            data: d,
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
                        
                        let _u = data.data.user;

                        

                        if(_u.user_status == 2) {
                            //未验证
                            wx.reLaunch({
                                url: '/pages/password/reset2?id=' + _u.id + '&phone=' + _u.mobile
                            });

                            // wx.reLaunch({
                            //     url: '/pages/user/setMobile?id=' + _u.id + '&mobile=' + _u.mobile
                            // });

                            return !1;
                        }
                        wx.navigateBack({
                            delta: 1
                        });
                        
                    } catch (e) {
                        console.log(e);
                        // Do something when catch error
                    }

                    wx.reLaunch({
                        url: '/pages/index/index'
                    });

                }


                console.log(data);
            }
        });
    },
    handleGetUserInfo(){
        api.login();
    },
    keyName :function(e) {
        let { value } = e.detail;
        this.setData({
            username:value
        })
        if(value.length > 0) {
            this.setData({
                close: true
            })
        }
    },
    keyPwd :function(e) {
        let { value } = e.detail;
        this.setData({
            password:value
        })
    },
    onLook: function(e) {
        const _k1 = `res.pwd`
        const _k2 = `res.src`
        if(!this.data.res.pwd) {
            console.log('e');
            this.setData({
                [_k1]: true,
                [_k2]: '../../images/nolook.png'
            })
        }else {
            console.log('ee');
            
            this.setData({
                [_k1]: false,
                [_k2]: '../../images/eye.png'
            })
        }
        
    },
    onClear: function(e) {
        this.setData({
            username: ''
        })
    }
})
