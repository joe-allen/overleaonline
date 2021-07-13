/**
 * @file Webpack config
 */
/* eslint-env node */

module.exports = ( env ) => {
	return {
		mode:   env,
		output: {
			filename: '[name].min.js',
		},
		devtool: env === 'development' ? 'inline-source-map' : 'source-map',
		module:  {
			rules: [
				{
					test:    /\.(js|jsx)$/,
					exclude: /(node_modules)/,
					loader:  'babel-loader',
				},
			],
		},
		optimization: {
			chunkIds:    'named',
			splitChunks: {
				cacheGroups: {
					commons: {
						chunks:             'initial',
						minChunks:          2,
						maxInitialRequests: 5,
						minSize:            0,
					},
					vendor: {
						test:     /node_modules/,
						chunks:   'initial',
						name:     'vendor',
						priority: 10,
						enforce:  true,
					},
				},
			},
		},
	};
};
