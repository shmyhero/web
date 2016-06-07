/**
 * ÓÃnode ¿ªÆô3000µ¥¿Ú
 * ¼ÓÔØwebpack.config.js ÅäÖÃÏî£¬´î½¨ÈÈ¼ÓÔØ¿ª·¢»·¾³
 */
var webpack = require('webpack');
var WebpackDevServer = require('webpack-dev-server');
var config = require('./webpack.config.js');

new WebpackDevServer(webpack(config), {
    publicPath: config.output.publicPath,
    hot: true,
    historyApiFallback: true
}).listen(3001, 'localhost', function(err, result) {
    if (err) {
        console.log(err);
    }
    console.log('3001¶Ë¿ÚÒÑ¿ªÆô');
});
