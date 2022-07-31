(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['exports', 'echarts'], factory);
    } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
        // CommonJS
        factory(exports, require('echarts'));
    } else {
        // Browser globals
        factory({}, root.echarts);
    }
}(this, function (exports, echarts) {
    var log = function (msg) {
        if (typeof console !== 'undefined') {
            console && console.error && console.error(msg);
        }
    };
    if (!echarts) {
        log('ECharts is not Loaded');
        return;
    }
    var colorPalette = [
        'rgba(250,82,82,0.7)','rgba(255,146,43,0.7)','rgba(252,196,25,0.7)','rgba(130,201,30,0.7)','rgba(34,139,230,0.7)',
        'rgba(121,80,242,0.7)','rgba(73,80,87,0.7)'
    ];
    echarts.registerTheme('vintage', {
        color: colorPalette,
        graph: {
            color: colorPalette
        }
    });
}));