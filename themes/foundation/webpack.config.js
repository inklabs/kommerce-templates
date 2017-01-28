const path = require('path');
const webpack = require('webpack');

const ExtractTextPlugin = require('extract-text-webpack-plugin');

module.exports = {
    context: path.resolve(__dirname, './javascript'),
    entry: {
        app: './main.js',
    },
    output: {
        path: path.resolve(__dirname, './assets'),
        filename: '[name].bundle.js',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                use: [{
                    loader: 'babel-loader',
                    options: { presets: ['es2015'] },
                }],
            },
            {
                test: /\.css$/,
                loader:  ExtractTextPlugin.extract({
                    loader: 'css-loader?importLoaders=1',
                }),
            },
            {
                test: /\.(sass|scss)$/,
                use: [
                    'style-loader',
                    'css-loader',
                    'sass-loader',
                ]
            }
        ],
    },
    plugins: [
        new ExtractTextPlugin({
            path: path.resolve(__dirname, './assets'),
            filename: 'bundle.css',
            allChunks: true,
        }),
    ],
};
