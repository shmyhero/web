/**
 * webpack 配置文件
 * 配置独立项、入口文件、输出项信息
 */
var path = require('path');
var webpack = require('webpack');

var node_modules_dir = path.join(__dirname, 'node_modules');
var components_dir = path.join(__dirname, 'components')+"/";

//独立项
var deps = [
  'react/dist/react.min.js',
  //'jquery/dist/jquery.min.js',
  'underscore/underscore-min.js'
];


//重定向文件
var alias= {
  Base          : components_dir + 'Base/Base.js',
  LogicData     : components_dir + 'Base/LogicData.js',
  NetConstants     : components_dir + 'Base/NetConstants.js',
  Storage     : components_dir + 'Base/Storage.js',
  Sortable      : components_dir + 'Sortable/Sortable.js',
  Tick       : components_dir + 'Tick/Tick.js',
  Login       : components_dir + 'Login/Login.js',
  // Tickheader       : components_dir + 'Tick/Tickheader.js',
  // HoldEdit      : components_dir + 'HoldEdit/HoldEdit.js',
  // ImageCut      : components_dir + 'ImageCut/ImageCut.js',
  // Loadmore      : components_dir + 'Loadmore/Loadmore.js',
  // Pager         : components_dir + 'Pager/Pager.js',
  ScrollLoadmore: components_dir + 'ScrollLoadmore/ScrollLoadmore.js',
  PositionLoadmore: components_dir + 'PositionLoadmore/PositionLoadmore.js',
  StockClosedPositionPage : components_dir + 'PositionLoadmore/StockClosedPositionPage.js',
  PositionStatistical : components_dir + 'PositionLoadmore/PositionStatistical.js',
  // SlideDelete   : components_dir + 'SlideDelete/SlideDelete.js',
  // SlideList     : components_dir + 'SlideList/SlideList.js',
  Position      : components_dir + 'Position/PositionList.js',
  Slider        : components_dir + 'Slider/SliderList.js',
  TipConfirm           : components_dir + 'Slider/TipConfirm.js',
  Tip           : components_dir + 'Slider/Tip.js',
  Form           : components_dir + 'Slider/form.js',
  SignIn        : components_dir + 'SignIn/SignIn.js',
  // SignUp        : components_dir + 'SignUp/SignUp.js',
  // FindPwd       : components_dir + 'FindPwd/FindPwd.js',
  // SetPwd        : components_dir + 'FindPwd/SetPwd.js',
  //SearchBar     : components_dir + 'SearchBar/SearchBar.js',
  SearchBox     : components_dir + 'SearchBox/SearchBox.js'
  // Dropdown      : components_dir + 'Dropdown/Dropdown.js',
  // UploadImage   : components_dir + 'UploadImage/UploadImage.js'
};

var config = {
  devtool: false,
  //'inline-source-map',
  //false,
//    entry: { a: "./a", b: "./b" },
//    output: { filename: "[name].js" },
//
//  entry: [
////    'webpack-dev-server/client?http://127.0.0.1:3000',
////    'webpack/hot/only-dev-server',
//    './examples/Slider/Tab.js',
//    //'./examples/SearchBar/SearchBar.js'
//  ],
  entry:{
      SliderTab: "./examples/Slider/Tab.js",
      Tick: "./examples/Tick/Tick.js",
      //Login: "./examples/Login/Login.js",
      PositionTab: "./examples/Position/Position.js",
      // SlideList: "./examples/SlideList/SlideList.js",
      // SearchBar: "./examples/SearchBar/SearchBar.js",
      // SearchBox: "./examples/SearchBox/SearchBox.js",
      // ScrollLoadmore: "./examples/ScrollLoadmore/ScrollLoadmore.js",
      // HoldEdit: "./examples/HoldEdit/HoldEdit.js",
      // Pager: "./examples/Pager/Pager.js",
      // Tip: "./examples/Tip/Tip.js",
      // Confirm: "./examples/Confirm/Confirm.js",
      // Dropdown: "./examples/Dropdown/Dropdown.js",
      // SlidePushMenu: "./examples/SlidePushMenu/SlidePushMenu.js",
      // SlideDelete: "./examples/SlideDelete/SlideDelete.js"
  },
  output: {
    path: path.join(__dirname, 'public/dist/'),
    filename: "[name].js",
    //filename: "SliderTab.js",
    //filename: "SearchBar.js",
    publicPath: '/static/'
  },
  plugins: [
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoErrorsPlugin()
  ],
  resolve: {
    alias: []
  },
  module: {
    noParse : [],
    loaders: [{
      test: /\.jsx?$/,
      loaders: ['react-hot', 'babel'],
      include: [
        path.join(__dirname,'components'),path.join(__dirname,'examples')
      ]
    }
    ,{
      test: /\.css$/,
      exclude: [
        path.resolve(__dirname, 'node_modules')
      ],
      loaders: ['style', 'css?modules&localIdentName=[name]_[local]_[hash:base64:5]','autoprefixer?{browsers:["> 5%", "ie 9"]}']
    },{
                test: /\.less$/,
                loader: "style!css!less"
     }
    // ,{
    //   test: /\.(svg|png|jpg|jpeg|gif)$/i,
    //   loaders: ['file', 'image-webpack?bypassOnDebug&optimizationLevel=7&interlaced=false']
    // }
    ]
  },
  plugins: [
    new webpack.HotModuleReplacementPlugin(),
    new webpack.NoErrorsPlugin(),
    new webpack.DefinePlugin({
      'process.env.NODE_ENV': JSON.stringify(process.env.NODE_ENV || 'development')
    })
  ]
}

//加载 alias项
deps.forEach(function (dep) {
  var depPath = path.resolve(node_modules_dir, dep);
  config.module.noParse.push(depPath);
});

//重定向文件赋值
config.resolve.alias = alias;

module.exports = config;