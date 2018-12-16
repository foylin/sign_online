var api = require('../../utils/api.js');
Page({
    data: {},
    onLoad () {
    },
    formSubmit(e){

        if(this.new_password != this.again_password) {
            wx.showModal({
                content: '两次密码不同，请重新输入',
                showCancel: false,
                success: function (res) {
                    if (res.confirm) {
                        console.log('用户点击确定')
                    }
                }
            });
            return !1;
        }
        console.log(this.data.new_password,this.data.again_password);
        
        api.post({
            url: 'user/public/newPasswordReset',
            data: e.detail.value,
            success: data => {
                if (data.code == 1) {
                    wx.showToast({
                        title: data.msg,
                        icon: 'success',
                        duration: 1000
                    });
                    setTimeout(function () {
                        // wx.navigateBack({
                        //     delta: 1
                        // });
                        wx.clearStorageSync();
                        wx.navigateTo({
                            url: '/pages/login/login'
                        });
                    }, 1000);
                }

                if (data.code == 0) {
                    wx.showModal({
                        content: data.msg,
                        showCancel: false,
                        success: function (res) {
                            if (res.confirm) {
                                console.log('用户点击确定')
                            }
                        }
                    });
                }


                console.log(data);
            }
        });
        //console.log(e);
    },
    onAccountInput(e){
        this.account = e.detail.value;
    },
    onNewPassword(e){
        this.new_password = e.detail.value;
    },
    onAgainPassword(e){
        this.again_password = e.detail.value;
    },
    onGetVerificationCode(){
        api.post({
            url: 'user/verification_code/send',
            data: {username: this.account},
            success: data => {
                if (data.code == 1) {
                    wx.showModal({
                        content: data.msg,
                        showCancel: false,
                        success: function (res) {
                        }
                    });

                }

                if (data.code == 0) {
                    wx.showModal({
                        content: data.msg,
                        showCancel: false,
                        success: function (res) {
                        }
                    });
                }


                console.log(data);
            }
        });
    }
})
