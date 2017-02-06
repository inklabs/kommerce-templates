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
        filename: 'js/[name].package.js',
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
                use: [
                    'css-loader?importLoaders=1',
                ]
            },
            {
                test: /\.(sass|scss)$/,
                loader: ExtractTextPlugin.extract({
                    fallbackLoader: "style-loader",
                    loader: "css-loader!sass-loader",
                }),
            },
            // {
            //     test: /\.(sass|scss)$/,
            //     use: ['css-loader', 'sass-loader']
            // }
        ],
    },
    plugins: [
        new ExtractTextPlugin({
            path: path.resolve(__dirname, './assets'),
            filename: 'css/[name].package.css',
            allChunks: true,
        }),
    ],
};
