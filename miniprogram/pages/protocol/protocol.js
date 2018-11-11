var api     = require('../../utils/api.js');
var WxParse = require('../../wxParse/wxParse.js');
var app     = getApp();


Page({

    data: {
        'countdown': 30,
        'countdowndes': '请阅读协议内容',
        
    },

    onLoad(params) {
        console.log(params);
        this.params = params;
        let count = 30;
        let that = this;
        let interval = setInterval(function(){
            count--;
            console.log(count);
            that.setData({countdown : count});

            if(count <= 0){
                clearInterval(interval);
                that.setData({countdowndes: ''});
            }
        }, 1000)

        
    },

    onReady() {
        this.loadData();
    },
    loadData() {
        var params = this.params;
        if (params.id) {
            wx.showNavigationBarLoading();
            api.get({
                url: 'protocol/articles/' + params.id,
                data: {},
                success: data => {
                    wx.hideNavigationBarLoading();
                    if (data.code) {
                        let publishedDate = new Date();
                        publishedDate.setTime(data.data.published_time * 1000);
                        data.data.published_date = publishedDate.format('yyyy-MM-dd hh:mm');
                        this.setData({article: data.data});
                        WxParse.wxParse('articleContent', 'html', data.data.post_content, this, 30);
                        wx.setNavigationBarTitle({
                            title: data.data.post_title
                        });
                    }else{


                        setTimeout(function(){
                            wx.navigateBack({
                                delta: 1
                            })
                        }, 1300)

                        wx.showToast({
                            title: data.msg,
                            icon: 'loading',
                            duration: 1000,
                            
                          })
                        
                    }
                },
                fail: err => {
                    wx.hideNavigationBarLoading();
                }
            });
        }


    },
    onFavoriteTap(e) {
        api.post({
            url: 'user/favorites',
            data: {
                object_id: this.params.id,
                table_name: 'portal_post',
                url: JSON.stringify({"action": "portal/Article/index", "param": {"id": this.params.id}}),
                title: this.data.article.post_title,
                description: this.data.article.post_excerpt,
            },
            success: data => {
                if (data.code) {
                    wx.showToast({
                        title: '收藏成功!',
                        icon: 'success',
                        duration: 1000
                    });
                } else {
                    wx.showToast({
                        title: data.msg,
                        icon: 'error',
                        duration: 1000
                    });
                }
            },
            fail: err => {
            }
        });

    },
    onLikeTap(e) {
        api.post({
            url: 'portal/articles/doLike',
            data: {
                id: this.params.id
            },
            success: data => {
                if (data.code) {
                    wx.showToast({
                        title: '点赞成功!',
                        icon: 'success',
                        duration: 1000
                    });
                    this.setData({'article.post_like': data.data.post_like});
                } else {
                    wx.showToast({
                        title: data.msg,
                        icon: 'error',
                        duration: 1000
                    });
                }
            },
            fail: err => {
            }
        });
    },
    onShareTap() {
        wx.showShareMenu({
            withShareTicket: true
        });
    },
    onShareAppMessage() {
        return {
            title: this.data.article.post_title,
            path: '/pages/article/article?id=' + this.params.id
        }
    },
    onsign(){
        if (this.data.countdown) return !1

        // console.log(this.data.countdown);
        var params = this.params;
        wx.navigateTo({
            url: '/pages/sign/sign?protocol_id='+params.id
        });
    }

});
