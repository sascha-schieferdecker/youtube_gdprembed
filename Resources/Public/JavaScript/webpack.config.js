const webpack = require('webpack');
const path = require('path');

const config = {
    entry: './src/youtubegdpr.js',
    output: {
        path: path.resolve(__dirname, 'dist'),
        filename: 'youtubegdpr.js',
        library: 'youtubegdpr',
        libraryTarget: 'window',
        libraryExport: 'default'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                use: 'babel-loader',
                exclude: /node_modules/
            }
        ]
    }
}

module.exports = config;
