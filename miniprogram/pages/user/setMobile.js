var api = require('../../utils/api.js')

Page({
    data: {
        mobile: ''
    },
    onLoad (params) {
        //console.log(options);
        this.params = params;
        this.setData({
            mobile: this.params.mobile
        });
    },

    formSubmit(e){
        
        api.post({
            // url: 'user/profile/bindingMobile',
            url: 'user/public/toverify',
            data: e.detail.value,
            success: data => {
                if (data.code == 1) {
                    wx.showToast({
                        title: data.msg,
                        icon: 'success',
                        duration: 1000
                    })
                }
                if (data.code == 0) {
                    wx.showModal({
                        content: data.msg,
                        showCancel:false,
                        success: function (res) {
                            if (res.confirm) {
                                console.log('用户点击确定')
                            }
                        }
                    })
                }
                console.log(data);
            }
        });
        //console.log(e);
    },
    onMobileInput(e){
        this.setData({
            mobile: e.detail.value
        });
        // this.mobile = e.detail.value;
    },
    onGetVerificationCode(){
        console.log(this);
        let that = this;
        api.post({
            // url: 'user/verification_code/send',
            url: 'user/msg/send',
            data: {mobile: that.data.mobile},
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


});