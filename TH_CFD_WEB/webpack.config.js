/**
 * webpack 配置文件
 * 配置独立项、入口文件、输出项信息
 */
var path = require('path');
var webpack = require('webpack');

var node_modules_dir = path.join(__dirname, 'node_modules');
var components_dir = path.join(__dirname, 'components') + "/";

//独立项
var deps = [
    'react/dist/react.min.js',
    'react/dist/react-dom.min.js',
    //'jquery/dist/jquery.min.js',
    'underscore/underscore-min.js'
];


//重定向文件
var alias = {
    Base: components_dir + 'Base/Base.js',
    LogicData: components_dir + 'Base/LogicData.js',
    NetConstants: components_dir + 'Base/NetConstants.js',
    Storage: components_dir + 'Base/Storage.js',
    Sortable: components_dir + 'Sortable/Sortable.js',
    Picker: components_dir + 'Tick/Picker.js',
    Login: components_dir + 'Login/Login.js',
    ScrollLoadmore: components_dir + 'ScrollLoadmore/ScrollLoadmore.js',
    PositionLoadmore: components_dir + 'PositionLoadmore/PositionLoadmore.js',
    StockClosedPositionPage: components_dir + 'PositionLoadmore/StockClosedPositionPage.js',
    PositionStatistical: components_dir + 'PositionLoadmore/PositionStatistical.js',
    Position: components_dir + 'Position/PositionList.js',
    SliderList: components_dir + 'Slider/SliderList.js',
    TipConfirm: components_dir + 'Slider/TipConfirm.js',
    Tip: components_dir + 'Slider/Tip.js',
    SearchBox: components_dir + 'SearchBox/SearchBox.js',
    Slider: components_dir + 'Position/Slider.js'
};
var precss = require('postcss-loader');
var autoprefixer = require('autoprefixer');
var config = {
    devtool: false,
    //'inline-source-map',
    entry: {
        SliderTab: "./components/Slider/Tab.js",
        Tick: "./components/Tick/Tick.js",
        PositionTab: "./components/Position/Position.js"
    },
    output: {
        path: path.join(__dirname, 'public/dist/'),
        filename: "[name].js",
        publicPath: '/static/'
    },
    resolve: {
        alias: []
    },
    module: {
        noParse: [],
        loaders: [{
            test: /\.jsx?$/,
            loaders: ['babel'],
            include: [
                path.join(__dirname, 'components')
            ]
        }, {
            test: /\.css$/,
            loader: "style-loader!css-loader!postcss-loader"
        }, {
            test: /\.less$/,
            loader: "style!css!less"
        }]
    },
    postcss: function() {
        return [precss, autoprefixer];
    },
    plugins: [
        //new webpack.HotModuleReplacementPlugin(),
        new webpack.optimize.UglifyJsPlugin({
            compress: {
                //supresses warnings, usually from module minification
                warnings: false
            }
        }),
        new webpack.NoErrorsPlugin(),
        new webpack.DefinePlugin({
            //'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV || 'development')
            "process.env": {
                NODE_ENV: JSON.stringify("production")
            }
        })
    ]
}

//加载 alias项
deps.forEach(function(dep) {
    var depPath = path.resolve(node_modules_dir, dep);
    config.module.noParse.push(depPath);
});

//重定向文件赋值
config.resolve.alias = alias;

module.exports = config;