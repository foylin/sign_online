var api = require('../../utils/api.js')
var app = getApp();

Page({
    data: {
        list: [],
        post_id: ''
    },
    onLoad(params) {

        let isLogin = wx.getStorageSync('login');
        if (!isLogin) {
            wx.navigateTo({
                url: '/pages/login/login'
            });
        }

        this.setData({
            post_id: params.post_id
        })

        wx.getStorage({
          key: 'user',
          success: (res) => {
            console.log(res);
            this.setData({ user: res.data });
          },
          fail: (res) => {
            console.log(res);
          }
        });

        this.params = params;

        this.getData(params.post_id);
    },
    onShow() {

    },
    getData(post_id) {

        wx.showLoading({title: '加载中...',})
        api.get({
            url: 'protocol/lists/fz_sign_list',
            data: {
                page: this.currentPageNumber,
                token: wx.getStorageSync('token'),
                post_id: post_id
            },
            success: data => {
                // let newItems = api.updatePageList('post_id', data.data.list, this.formatListItem, true);
                // console.log(newItems);
                // this.setData({
                //     list: newItems
                // });

                // if (data.data.list.length > 0) {
                //     this.currentPageNumber++;
                // } else {
                //     this.setData({
                //         noMoreData: true
                //     });

                // }

                // wx.stopPullDownRefresh();

                console.log(data)
                wx.hideLoading()
                
                if(data.code == 0) {
                    wx.showModal({
                        content: data.msg,
                        showCancel: false,
                        success: function (res) {
                            if (res.confirm) {
                                console.log('用户点击确定')
                            }
                        }
                    })
                    return !1;
                }

                if(data.code == 1) {
                    
                    this.setData({
                        list: data.data.list
                    });
                }
            }
        });
    },
    /**
     * 下拉刷新
     */
    onPullDownRefresh() {
        this.currentPageNumber = 1;
        this.setData({
            noMoreData: false,
            noData: false
        });
        api.get({
            url: 'protocol/lists/fz_sign',
            data: {
                page: this.currentPageNumber,
                token: wx.getStorageSync('token')
            },
            success: data => {
                let newItems = api.updatePageList('post_id', data.data.list, this.formatListItem, true);
                console.log(newItems);
                this.setData({
                    list: newItems
                });

                if (data.data.list.length > 0) {
                    this.currentPageNumber++;
                } else {
                    this.setData({
                        noMoreData: true
                    });

                    // 没有数据
                    // this.setData({
                    //     noMoreData: true,
                    //     noData: true
                    // });
                }

                wx.stopPullDownRefresh();
            }
        });
    },

    /**
     * 上拉刷新
     */
    pullUpLoad() {
        if (this.data.loadingMore || this.data.noMoreData) return;
        this.setData({
            loadingMore: true
        });
        wx.showNavigationBarLoading();

        api.get({
            url: 'protocol/lists/fz_sign',
            data: {
                page: this.currentPageNumber,
                token: wx.getStorageSync('token')
            },
            success: data => {
                console.log(data.data.list)
                let newItems = api.updatePageList('post_id', data.data.list, this.formatListItem);
                console.log(newItems);
                this.setData({
                    list: newItems
                });
                if (data.data.list.length > 0) {
                    this.currentPageNumber++;
                } else {
                    this.setData({
                        noMoreData: true
                    });

                    // 没有数据
                    // this.setData({
                    //     noMoreData: true,
                    //     noData: true
                    // });
                }
            },
            complete: () => {
                this.setData({
                    loadingMore: false
                });
                wx.hideNavigationBarLoading();
            }
        });
    },
    formatListItem(item) {
        if (item.Thumbnail) {
            item.Thumbnail = api.getUploadUrl(item.Thumbnail);
        }
        return item;
    },
    onListItemTap(e) {
        let id = e.currentTarget.dataset.id;
        let status = e.currentTarget.dataset.status;
        let uid = e.currentTarget.dataset.uid;
        let type = e.currentTarget.dataset.type;
        let usertype = e.currentTarget.dataset.usertype; 
        let pcup_id = e.currentTarget.dataset.pcup_id;
        wx.navigateTo({
          url: '/pages/protocol/protocol?id=' + id + '&status=' + status + '&uid=' + uid + '&type=' + type + '&usertype=' + usertype + '&pcup_id=' + pcup_id
        });
    },
    subsign(e) {
        let protocol_id = e.currentTarget.dataset.id;
        //判断是否有未签约的
        wx.showLoading({title: '加载中...',})
        api.get({
            url: 'protocol/lists/isCanSign',
            data: {
                protocol_id: protocol_id
            },
            success: data => {
                wx.hideLoading()
                
                if(data.code == 0) {
                    wx.showModal({
                        content: data.msg,
                        showCancel: false,
                        success: function (res) {
                            if (res.confirm) {
                                console.log('用户点击确定')
                            }
                        }
                    })
                    return !1;
                }else if(data.code == 1) {
                    wx.navigateTo({
                        url: '/pages/sign/sign?protocol_id='+protocol_id+'&type=1'
                    })
                }
            },
            complete: () => {
                wx.hideLoading()
            }
        });
        // wx.navigateTo({
        //     url: '/pages/sign/sign?protocol_id='+protocol_id+'&type=1'
        // })
    }

    
});