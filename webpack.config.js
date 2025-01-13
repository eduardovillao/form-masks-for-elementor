const path = require('path');
const fs = require('fs');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const srcJsGeneralDirectory = path.resolve(__dirname, 'src/js/');
const generalEntries = fs.readdirSync(srcJsGeneralDirectory).reduce((entries, file) => {
		if (file.endsWith('.js')) {
			const entryKey = file.replace('.js', '');
			entries[entryKey] = path.resolve(srcJsGeneralDirectory, file);
		}
		return entries;
	}, {});

const generalJs = {
	mode: 'production',
	entry: generalEntries,
	output: {
		filename: '[name].min.js',
		path: path.resolve(__dirname, 'assets/js'),
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'esbuild-loader',
					options: {
						loader: 'js',
						target: 'es2016',
					},
				},
			},
		],
	},
};

const editorCSS = {
	mode: 'production',
	entry: './src/css/editor.css',
	output: {
		filename: 'style.bundle.js',
		path: path.resolve(__dirname, 'assets/css/'),
	},
	module: {
		rules: [
			{
				test: /\.css$/,
				use: [MiniCssExtractPlugin.loader, 'css-loader'],
			},
		],
	},
	optimization: {
		minimizer: [new CssMinimizerPlugin()],
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: 'editor.min.css',
		}),
	],
};

module.exports = [generalJs, editorCSS];
