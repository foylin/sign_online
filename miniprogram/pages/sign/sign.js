import Handwriting from '../../components/handwriting/handwriting.js';

var api     = require('../../utils/api.js');
var WxParse = require('../../wxParse/wxParse.js');
var app     = getApp();

Page({

    /**
     * 页面的初始数据
     */
    data: {
        selectColor: 'black',
        slideValue: 50,
        imageTempPath: '',
        ctx: '',
    },

    /**
     * 生命周期函数--监听页面加载
     */
    onLoad: function (options) {
        this.handwriting = new Handwriting(this, {
            lineColor: this.data.lineColor,
            slideValue: this.data.slideValue, // 0, 25, 50, 75, 100
        })

        // this.ctx = wx.createCanvasContext('handwriting')

        // const ctx = wx.createCanvasContext('handwriting')
        // ctx.setFillStyle('red')
        // ctx.fillRect(10, 10, 150, 75)
        // ctx.draw()
    },

    // 选择画笔颜色
    selectColorEvent(event) {
        var color = event.currentTarget.dataset.colorValue;
        var colorSelected = event.currentTarget.dataset.color;
        this.setData({
            selectColor: colorSelected
        })
        this.handwriting.selectColorEvent(color)
    },
    retDraw() {
        this.handwriting.retDraw()
    },
    // 笔迹粗细滑块
    onTouchStart(event) {
        this.startY = event.touches[0].clientY;
        this.startValue = this.format(this.data.slideValue)
    },
    onTouchMove(event) {
        const touch = event.touches[0];
        this.deltaY = touch.clientY - this.startY;
        this.updateValue(this.startValue + this.deltaY);
    },
    onTouchEnd() {
        this.updateValue(this.data.slideValue, true);
    },
    updateValue(slideValue, end) {
        slideValue = this.format(slideValue);
        this.setData({
            slideValue,
        });
        this.handwriting.selectSlideValue(this.data.slideValue)
    },
    format(value) {
        return Math.round(Math.max(0, Math.min(value, 100)) / 25) * 25;
    },
    subCanvas() {
        // this.handwriting.retFile();
        // var paperThis = this;

        // var sel = this.selectComponent('#handwriting');
        // const ctx = wx.createCanvasContext('handwriting', this)
        // this.handwriting.ctx.draw(false, function () {
            // console.log(123);
            wx.canvasToTempFilePath({
                canvasId: 'handwriting',
                // quality: 1,
                success: function (res) {
                    // 获得图片临时路径
                    // this.imageTempPath = res.tempFilePath;
                    console.log(res);
                },
                fail: function(err){
                    console.log(err);
                }
            }, this)
        
           
        // });
    }

})