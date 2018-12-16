var api = require('../../utils/api.js')

var app = getApp();

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
        api.deletePageListItemByPage('pages/index/index','id')
        console.log(app.pagesData)
        wx.reLaunch({
            url: '/pages/login/login'
        });
    },
    changepwd(){
        wx.navigateTo({
            url: '/pages/password/reset'
        });
    }
});