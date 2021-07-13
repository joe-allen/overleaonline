/**
 * @file Gulp tasks
 */
/* eslint-env node */

const gulp = require( 'gulp' );

const {
	parallel,
	series,
	src,
	watch,
	dest,
} = gulp;

const browserSync = require( 'browser-sync' ).create();
const homedir     = require( 'os' ).homedir();

const currentPath  = __dirname;
const pathArr      = currentPath.split( '/' );
const pathFromRoot = currentPath.replace( /.*?\/wp-content/, 'wp-content' );
const pathToRoot   = currentPath.replace( /\/wp-content.*/, '' );

// SCSS
const sass         = require( 'gulp-sass' );
const fiber        = require( 'fibers' );
const sassGlob     = require( 'gulp-sass-glob' );
const sourcemaps   = require( 'gulp-sourcemaps' );
const postcss      = require( 'gulp-postcss' );
const autoprefixer = require( 'autoprefixer' );
// const extractmq    = require( 'postcss-extract-media-query' );

sass.compiler = require( 'sass' );

/**
 * Build SCSS
 *
 * @return {Function} gulp task
 */
const scss = () =>
	src( [ 'scss/**/*.scss', 'templates/**/*.scss' ] )
		.pipe( sourcemaps.init() )
		.pipe( sassGlob() )
		.pipe(
			sass( {
				fiber,
				outputStyle: 'compressed',
			} ).on( 'error', sass.logError ),
		)
		.pipe(
			postcss( [
				require( 'postcss-import' ),
				require( 'tailwindcss' ),
				autoprefixer( {
					cascade: false,
				} ),
				/* extractmq( {
					output: {
						path: `${ __dirname }/css`,
					},
					queries: {
						'screen and (max-width: 1920px)': 'desktop',
						'screen and (max-width: 1024px)': 'tablet-landscape',
						'screen and (max-width: 768px)':  'tablet-portrait',
						'screen and (max-width: 600px)':  'mobile',
						'screen and (max-width: 550px)':  'mobile',
						'screen and (max-width: 360px)':  'mobile',
					},
				} ), */
			] ),
		)
		.pipe( sourcemaps.write( './maps' ) )
		.pipe( dest( 'css' ) )
		.pipe( browserSync.stream() );

/**
 * Watch SCSS
 *
 * @param {Function} cb callback
 */
const scssWatch = ( cb ) => {
	watch( '**/*.scss', scss );
	cb();
};

// JS
const webpackStream = require( 'webpack-stream' );
const webpack       = require( 'webpack' );
const named         = require( 'vinyl-named' );
const webpackConfig = require( './webpack.config' );

/**
 * Build JS
 *
 * @return {Function} gulp task
 */
const js = () => {
	const env = process.env.NODE_ENV || 'development';
	return src( './js/*.js' )
		.pipe( named() )
		.pipe( webpackStream( webpackConfig( env ), webpack ) )
		.pipe( dest( './js/min' ) );
};

/**
 * Reload browser after JS builds
 *
 * @param {Function} cb callback
 */
const jsDone = ( cb ) => {
	browserSync.reload();
	cb();
};

/**
 * Watch JS
 *
 * @param {Function} cb callback
 */
const jsWatch = ( cb ) => {
	gitHooks();
	watch( [ './js/*.js', './components/**/*.js', './templates/**/*.js' ], series( js, jsDone ) );
	cb();
};

// BrowserSync
const domain = pathArr[ pathArr.length - 4 ] + '.test';

/**
 * Reload browser on php and twig changes
 *
 * @param {Function} cb callback
 */
const phpTwigDone = ( cb ) => {
	browserSync.reload();
	cb();
};

/**
 * Run BrowserSync and watch php/twig files
 *
 * @param {Function} cb callback
 */
const browserReload = ( cb ) => {
	browserSync.init( {
		proxy:           `https://${ domain }`,
		host:            domain,
		open:            false,
		reloadOnRestart: true,
		https:           {
			key:  `${ homedir }/.config/valet/Certificates/${ domain }.key`,
			cert: `${ homedir }/.config/valet/Certificates/${ domain }.crt`,
		},
	} );
	watch( [ './*.php', './**/*.twig' ], phpTwigDone );
	cb();
};

// Scaffold
const gulpTemplate  = require( 'gulp-template' );
const minimist      = require( 'minimist' );
const rename        = require( 'gulp-rename' );
const { argv }      = require( 'process' );
const packageConfig = require( './package.json' );

/**
 * Component
 *
 * Build out a component folder
 *
 * @param {Function} cb callback
 */
const component = ( cb ) => {
	const args = minimist( argv.slice( 2 ) );
	if ( ! args.name ) {
		cb();
		return;
	}

	const dir            = `components/${ args.name }`;
	const nameUnderscore = args.name.replace( /-/g, '_' );
	const nameLower      = args.name.replace( /-([a-z])/g, ( g ) => g[ 1 ].toUpperCase() );
	const nameUpper      = args.name.replace( /(?:^(.))|(?:-([a-z]))/g, ( g ) => ( g.length > 1 ? g[ 1 ] : g ).toUpperCase() );
	const nameSpaced     = args.name.replace( /(?:^(.))|(?:-([a-z]))/g, ( g ) => ( g.length > 1 ? ' ' + g[ 1 ] : g ).toUpperCase() )
		.replace( 'Hp', 'Homepage' );
	const themeName      = ( packageConfig.name || 'vanilla-theme' ).replace( /(?:^(.))|(?:-([a-z]))/g, ( g ) => ( g.length > 1 ? '_' + g[ 1 ] : g ).toUpperCase() );

	const types = ( args.js ? 'js,' : '' ) + 'scss,twig,php';

	src( `.gulp-templates/component/*.{${ types }}` )
		.pipe( gulpTemplate( {
			name:    args.name,
			element: args.element || 'article',
			theme:   themeName,
			nameLower,
			nameUpper,
			nameSpaced,
			nameUnderscore,
		} ) )
		.pipe( rename( ( path ) => {
			const prefix  = path.extname === '.scss' ? '_' : '';
			const suffix  = path.extname === '.php' ? '-acf' : '';
			path.basename = prefix + args.name + suffix;
		} ) )
		.pipe( dest( dir ) );

	cb();
};

/**
 * Template
 *
 * Build out a template folder
 *
 * @param {Function} cb callback
 */
const template = ( cb ) => {
	const args = minimist( argv.slice( 2 ) );
	if ( ! args.name ) {
		cb();
		return;
	}

	const dir            = `templates/${ args.name }`;
	const nameUnderscore = args.name.replace( /-/g, '_' );
	const nameLower      = args.name.replace( /-([a-z])/g, ( g ) => g[ 1 ].toUpperCase() );
	const nameUpper      = args.name.replace( /(?:^(.))|(?:-([a-z]))/g, ( g ) => ( g.length > 1 ? g[ 1 ] : g ).toUpperCase() );
	const nameSpaced     = args.name.replace( /(?:^(.))|(?:-([a-z]))/g, ( g ) => ( g.length > 1 ? ' ' + g[ 1 ] : g ).toUpperCase() );
	const themeName      = ( packageConfig.name || 'vanilla-theme' ).replace( /(?:^(.))|(?:-([a-z]))/g, ( g ) => ( g.length > 1 ? '_' + g[ 1 ] : g ).toUpperCase() );

	const templates = '.gulp-templates/template';
	const files     = [ `${ templates }/template-acf.php`, `${ templates }/template.twig` ];
	if ( args.js ) {
		files.push( `${ templates }/template.js` );
	}
	if ( args.scss ) {
		files.push( `${ templates }/template.scss` );
	}

	// Process files and drop in templates/
	src( files )
		.pipe( gulpTemplate( {
			name:  args.name,
			theme: themeName,
			nameLower,
			nameUpper,
			nameSpaced,
			nameUnderscore,
		} ) )
		.pipe( rename( ( path ) => {
			const suffix  = path.extname === '.php' ? '-acf' : '';
			path.basename = args.name + suffix;
		} ) )
		.pipe( dest( dir ) );

	// Process php template and drop in theme root
	src( `${ templates }/template.php` )
		.pipe( gulpTemplate( {
			name:  args.name,
			theme: themeName,
			nameLower,
			nameUpper,
			nameSpaced,
			nameUnderscore,
		} ) )
		.pipe( rename( ( path ) => {
			path.basename = `template-${ args.name }`;
		} ) )
		.pipe( dest( './' ) );

	cb();
};

// Installation
const fs    = require( 'fs' );
const chmod = require( 'gulp-chmod' );

/**
 * Git Hooks
 *
 * @param {Function} cb callback
 */
const gitHooks = ( cb ) => {
	// If git folder doesn't exist, exit
	if ( ! fs.existsSync( `${ pathToRoot }/.git` ) ) {
		if ( cb ) {
			cb();
		}

		return;
	}

	if ( ! fs.existsSync( `${ pathToRoot }/.git/hooks/pre-commit` ) || ! fs.existsSync( `${ pathToRoot }/.git/hooks` ) ) {
		src( [ '.gulp-templates/pre-commit', '.gulp-templates/post-commit' ] )
			.pipe( gulpTemplate( {
				theme: pathFromRoot,
			} ) )
			.pipe( chmod( 0o777 ) )
			.pipe( dest( `${ pathToRoot }/.git/hooks` ) );
	}

	if ( cb ) {
		cb();
	}
};

/**
 * Editor Files
 *
 * @param {Function} cb callback
 */
const editorFiles = ( cb ) => {
	/**
	 * Handle Errors
	 *
	 * @param {Error} err error
	 */
	const errorCb = ( err ) => {
		if ( err ) {
			throw err;
		}
	};

	if ( fs.existsSync( '.editorconfig' ) ) {
		fs.rename( '.editorconfig', `${ pathToRoot }/.editorconfig`, errorCb );
	}

	if ( fs.existsSync( '.phpcs.xml' ) ) {
		fs.rename( '.phpcs.xml', `${ pathToRoot }/.phpcs.xml`, errorCb );
	}

	cb();
};

/**
 * Settings JSON
 *
 * @param {Function} cb callback
 */
const settingsJson = ( cb ) => {
	/**
	 * Build Settings
	 *
	 * @return {*} Gulp stream
	 */
	const buildSettings = () => (
		src( '.gulp-templates/settings.partial' )
			.pipe( gulpTemplate( {
				theme: pathFromRoot,
			} ) )
	);

	buildSettings().on( 'data', ( file ) => {
		const compiledSettings = file.contents.toString();

		src( `${ pathToRoot }/*.code-workspace` )
			.pipe( gulpTemplate( {
				settings: compiledSettings,
			}, {
				interpolate: /"(settings)": {}/gs,
			} ) )
			.pipe( dest( pathToRoot ) );
	} );

	cb();
};

// Start
exports.default   = parallel( jsWatch, scssWatch );
exports.live      = parallel( browserReload, jsWatch, scssWatch );
exports.js        = series( gitHooks, js );
exports.scss      = scss;
exports.component = component;
exports.template  = template;
exports.install   = series( gitHooks, editorFiles, settingsJson );
exports.githooks  = gitHooks;

/**
 * Build JS for production
 *
 * @param {Function} cb callback
 */
exports[ 'pre-commit' ] = ( cb ) => {
	process.env.NODE_ENV = 'production';
	js();
	cb();
};
