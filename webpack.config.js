const path = require('path');

const root = "./src";
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

module.exports = {
    entry: {
        main: root + "/src/index.ts"
    },
    output: {
        path: path.resolve(__dirname, root + "/Resources/public/"),
        filename: "js/default.js"
    },
    watch: false,
    devtool: "source-maps",
    module: {
        rules: [
            {
                // Include ts, tsx, js, and jsx files.
                test: /\.(ts|js)x?$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
            },
            {
                test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                use: [
                    {
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: 'fonts/'
                        }
                    }
                ]
            },
            {
                test: /\.(s?)css$/,
                use: [
                    {
                        loader: 'style-loader'
                    },
                    MiniCssExtractPlugin.loader,
                    {
                        loader: 'css-loader',
                        options: {
                            sourceMap: true,
                        },
                    },
                    "postcss-loader",
                    {
                        loader: 'sass-loader',
                        options: {
                            implementation: require('sass'),
                            sourceMap: true,
                        },
                    }
                ]
            },
            {
                // Match woff2 in addition to patterns like .woff?v=1.1.1.
                test: /\.(woff|woff2)(\?v=\d+\.\d+\.\d+)?$/,
                use: {
                    loader: "url-loader",
                    options: {
                        // Limit at 50k. Above that it emits separate files
                        limit: 50000,

                        // url-loader sets mimetype if it's passed.
                        // Without this it derives it from the file extension
                        mimetype: "application/font-woff",

                        // Output below fonts directory
                        name: "./css/fonts/[name].[ext]",
                    }
                },
            },
        ]
    },
    resolve: {
        extensions: ['.ts', '.tsx', '.js', '.json', '.scss']
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: "css/default.css"
        }),
    ]
};
