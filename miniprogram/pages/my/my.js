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
                this.setData({user: res.data});
            }
        });

    }
});