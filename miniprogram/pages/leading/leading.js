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

        console.log(app.pagesNeedUpdate);
        if (app.pagesNeedUpdate['pages/leading/leading'] == 1) {
            let newItems = api.updatePageList('id');
            console.log(newItems);
            this.setData({
                list: newItems
            });
        }

        if (app.pagesNeedUpdate['pages/leading/leading'] == 'refresh') {
            this.onPullDownRefresh();
        }
        this.pullUpLoad();

        api.pageNeedUpdate('pages/leading/leading', 0);

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
    toleading(e) {
        let post_id = e.currentTarget.dataset.post;
        wx.navigateTo({
            url: '/pages/leading/leading2?post_id=' + post_id
        });

    },
});