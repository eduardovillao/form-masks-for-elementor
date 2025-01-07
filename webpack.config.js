// const path = require('path');
// const fs = require('fs');
// const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
// const MiniCssExtractPlugin = require("mini-css-extract-plugin");

// const orderJs = {
// 	mode: 'production',
// 	entry: './src/js/order/controller.js',
// 	output: {
// 		filename: 'order.min.js',
// 		path: path.resolve(__dirname, 'assets/js'),
// 	},
// 	module: {
// 		rules: [
// 			{
// 				test: /\.js$/,
// 				exclude: /node_modules/,
// 				use: {
// 					loader: 'esbuild-loader',
// 					options: {
// 						loader: 'js',
// 						target: 'es2016',
// 					},
// 				},
// 			},
// 		],
// 	},
// };

// const srcJsAdminDirectory = path.resolve(__dirname, 'src/js/admin');
// const adminEntries = fs.readdirSync(srcJsAdminDirectory).reduce((entries, file) => {
// 		if (file.endsWith('.js')) {
// 			const entryKey = file.replace('.js', '');
// 			entries[entryKey] = path.resolve(srcJsAdminDirectory, file);
// 		}
// 		return entries;
// 	}, {});

// const adminJs = {
// 	mode: 'production',
// 	entry: adminEntries,
// 	output: {
// 		filename: '[name].min.js',
// 		path: path.resolve(__dirname, 'assets/js/admin'),
// 	},
// 	module: {
// 		rules: [
// 			{
// 				test: /\.js$/,
// 				exclude: /node_modules/,
// 				use: {
// 					loader: 'esbuild-loader',
// 					options: {
// 						loader: 'js',
// 						target: 'es2016',
// 					},
// 				},
// 			},
// 		],
// 	},
// };

// const srcJsCustomFieldsDirectory = path.resolve(__dirname, 'src/js/admin/custom-fields');
// const customFieldsEntries = fs.readdirSync(srcJsCustomFieldsDirectory).reduce((entries, file) => {
// 		if (file.endsWith('.js')) {
// 			const entryKey = file.replace('.js', '');
// 			entries[entryKey] = path.resolve(srcJsCustomFieldsDirectory, file);
// 		}
// 		return entries;
// 	}, {});

// const customFieldsJs = {
// 	mode: 'production',
// 	entry: customFieldsEntries,
// 	output: {
// 		filename: '[name].min.js',
// 		path: path.resolve(__dirname, 'assets/js/admin/custom-fields'),
// 	},
// 	module: {
// 		rules: [
// 			{
// 				test: /\.js$/,
// 				exclude: /node_modules/,
// 				use: {
// 					loader: 'esbuild-loader',
// 					options: {
// 						loader: 'js',
// 						target: 'es2016',
// 					},
// 				},
// 			},
// 		],
// 	},
// };

// const srcJsGeneralDirectory = path.resolve(__dirname, 'src/js/');
// const generalEntries = fs.readdirSync(srcJsGeneralDirectory).reduce((entries, file) => {
// 		if (file.endsWith('.js')) {
// 			const entryKey = file.replace('.js', '');
// 			entries[entryKey] = path.resolve(srcJsGeneralDirectory, file);
// 		}
// 		return entries;
// 	}, {});

// const generalJs = {
// 	mode: 'production',
// 	entry: generalEntries,
// 	output: {
// 		filename: '[name].min.js',
// 		path: path.resolve(__dirname, 'assets/js'),
// 	},
// 	module: {
// 		rules: [
// 			{
// 				test: /\.js$/,
// 				exclude: /node_modules/,
// 				use: {
// 					loader: 'esbuild-loader',
// 					options: {
// 						loader: 'js',
// 						target: 'es2016',
// 					},
// 				},
// 			},
// 		],
// 	},
// };

// const srcJsOrdersPanelDirectory = path.resolve(__dirname, 'src/js/orders-panel');
// const ordersPanelEntries = fs.readdirSync(srcJsOrdersPanelDirectory).map((file) => {
// 		if (file.endsWith('.js')) {
// 			return path.resolve(srcJsOrdersPanelDirectory, file);
// 		}
// 	}, []);

// const ordersPanelJs = {
// 	mode: 'production',
// 	entry: ordersPanelEntries,
// 	output: {
// 		filename: 'frontend.min.js',
// 		path: path.resolve(__dirname, 'assets/js/orders-panel'),
// 	},
// 	module: {
// 		rules: [
// 			{
// 				test: /\.js$/,
// 				exclude: /node_modules/,
// 				use: {
// 					loader: 'esbuild-loader',
// 					options: {
// 						loader: 'js',
// 						target: 'es2016',
// 					},
// 				},
// 			},
// 		],
// 	},
// };

// const deliveryPageCSS = {
// 	mode: 'production',
// 	entry: './src/css/delivery-page/style.css',
// 	output: {
// 		filename: 'style.bundle.js',
// 		path: path.resolve(__dirname, 'assets/css/'),
// 	},
// 	module: {
// 		rules: [
// 			{
// 				test: /\.css$/,
// 				use: [MiniCssExtractPlugin.loader, 'css-loader'],
// 			},
// 		],
// 	},
// 	optimization: {
// 		minimizer: [new CssMinimizerPlugin()],
// 	},
// 	plugins: [
// 		new MiniCssExtractPlugin({
// 			filename: 'delivery-frontend.min.css',
// 		}),
// 	],
// };

// const orderPanelPageCSS = {
// 	mode: 'production',
// 	entry: './src/css/order-panel/style.css',
// 	output: {
// 		filename: 'style.bundle.js',
// 		path: path.resolve(__dirname, 'assets/css/'),
// 	},
// 	module: {
// 		rules: [
// 			{
// 				test: /\.css$/,
// 				use: [MiniCssExtractPlugin.loader, 'css-loader'],
// 			},
// 		],
// 	},
// 	optimization: {
// 		minimizer: [new CssMinimizerPlugin()],
// 	},
// 	plugins: [
// 		new MiniCssExtractPlugin({
// 			filename: 'order-panel-frontend.min.css',
// 		}),
// 	],
// };

// const trackOrderPageCSS = {
// 	mode: 'production',
// 	entry: './src/css/track-order/style.css',
// 	output: {
// 		filename: 'style.bundle.js',
// 		path: path.resolve(__dirname, 'assets/css/'),
// 	},
// 	module: {
// 		rules: [
// 			{
// 				test: /\.css$/,
// 				use: [MiniCssExtractPlugin.loader, 'css-loader'],
// 			},
// 		],
// 	},
// 	optimization: {
// 		minimizer: [new CssMinimizerPlugin()],
// 	},
// 	plugins: [
// 		new MiniCssExtractPlugin({
// 			filename: 'track-order-frontend.min.css',
// 		}),
// 	],
// };

// module.exports = [
// 	orderJs,
// 	adminJs,
// 	customFieldsJs,
// 	generalJs,
// 	ordersPanelJs,
// 	deliveryPageCSS,
// 	orderPanelPageCSS,
// 	trackOrderPageCSS,
// ];
