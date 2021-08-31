const path = require('path');
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const TerserPlugin = require("terser-webpack-plugin");

module.exports = {
    plugins: [new MiniCssExtractPlugin({ filename: 'styles.css' })],
    entry: {
        'scripts': path.resolve(__dirname, './app/Assets/js/entry.js'),
    },
    output: {
        filename: '[name].js',
        path: path.resolve(__dirname, './www/assets'),
    },
    optimization: {
        minimize: true,
        minimizer: [
            new CssMinimizerPlugin(),
            new TerserPlugin()
        ],
    },
    target: ['web', 'es5'],
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                exclude: [/node_modules/, /core-js/],
                use: {
                    loader: 'babel-loader',
                },
            },
            {
                test: /\.css$/,
                use: [MiniCssExtractPlugin.loader, "css-loader"],
            }
        ]
    },
    mode: 'production',
    devServer: {
        watchContentBase: true
    }
};