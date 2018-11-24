var api = require('../../utils/api.js')

Page({
    data: {
        list: [],
    },
    onLoad() {

    },
    onShow() {
        let isLogin = wx.getStorageSync('login');
        if (!isLogin) {
            wx.navigateTo({
                url: '/pages/login/login'
            });
        }

        wx.getStorage({
            key: 'user',
            success: (res) => {
                console.log(res);
                this.setData({user: res.data});
            },
            fail: (res) => {
                console.log(res);
            }
        });

    },
    logout(){
        wx.clearStorageSync();
        wx.navigateTo({
            url: '/pages/login/login'
        });
    }
});