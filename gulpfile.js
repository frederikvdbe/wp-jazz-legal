/* CONFIG */
const theme_name = "jazzlegal";
const config = {
	src_path: "./web/app/themes/" + theme_name + "/assets/src",
	build_path: "./web/app/themes/" + theme_name + "/assets/build",
	proxy: theme_name + ".ddev.site",
};

/* GLOBAL IMPORTS */
const gulp = require("gulp");
const gutil = require("gulp-util");
const plumber = require("gulp-plumber");
const concat = require("gulp-concat");
const babel = require("gulp-babel");
const browserSync = require('browser-sync').create();
const reload = browserSync.reload;

/* OPTIONS */
let isProduction = true;
let sassStyle = "compressed";
let sourceMap = false;

if (gutil.env.dev === true) {
	isProduction = false;
	sassStyle = "expanded";
	sourceMap = true;
}

function sass() {
	const sass = require("gulp-sass");
	const sourcemaps = require("gulp-sourcemaps");

	return gulp
	.src(config.src_path + "/scss/main.scss")
	.pipe(!isProduction ? sourcemaps.init() : gutil.noop())
	.pipe(sass())
	.pipe(!isProduction ? sourcemaps.write() : gutil.noop())
	.pipe(gulp.dest(config.build_path + "/css"))
	.pipe(browserSync.stream());
}

function css() {
	const concat = require("gulp-concat");
	const csso = require("gulp-csso");
	const autoprefixer = require("gulp-autoprefixer");
	const rename = require("gulp-rename");

	let styles = [
		"./node_modules/flexboxgrid/dist/flexboxgrid.css",
		"./node_modules/select2/dist/css/select2.css",
		"./node_modules/tooltipster/dist/css/tooltipster.bundle.css",
		"./node_modules/swiper/swiper-bundle.css",
		"./node_modules/vanilla-cookieconsent/src/cookieconsent.css",
	];

	// Bundle files for production
	if (isProduction) {
		styles.push(config.build_path + "/css/main.css");

		return gulp
		.src(styles)
		.pipe(concat("styles.css"))
		.pipe(csso())
		.pipe(autoprefixer())
		.pipe(rename("styles.min.css"))
		.pipe(gulp.dest(config.build_path + "/css"));
	}

	// Copy source files in dev environment
	return gulp.src(styles).pipe(gulp.dest(config.build_path + "/css/vendor"));
}

function jsDeps() {
	const concat = require("gulp-concat");
	const uglify = require("gulp-uglify");
	const rename = require("gulp-rename");
	const plumber = require("gulp-plumber");

	// Bundle
	const scripts = [
		"./node_modules/picturefill/dist/picturefill.js",
		"./node_modules/imagesloaded/imagesloaded.pkgd.js",
		"./node_modules/select2/dist/js/select2.js",
		"./node_modules/swiper/swiper-bundle.js",
		"./node_modules/tooltipster/dist/js/tooltipster.bundle.js",
		"./node_modules/jquery.scrollto/jquery.scrollTo.js",
		"./node_modules/vanilla-cookieconsent/src/cookieconsent.js",
		"./node_modules/swiper/swiper-bundle.js",
		config.src_path + "/js/vendor/**/*.js",
	];

	if (isProduction) {
		gulp.src(scripts)
		.pipe(plumber())
		.pipe(concat("deps.js"))
		.pipe(gulp.dest(config.build_path + "/js/temp"));
	}

	scripts.push(
		"./node_modules/animejs/lib/anime.min.js",
		"./node_modules/jquery/dist/jquery.js"
	);

	return gulp.src(scripts).pipe(gulp.dest(config.build_path + "/js/vendor"));
}

function jsBuild() {
	const concat = require("gulp-concat");
	const plumber = require("gulp-plumber");
	const babel = require("gulp-babel");
	const merge = require("merge-stream");

	const scripts = gulp.src([
		config.src_path + "/js/responsive-background-images.js",
		config.src_path + "/js/tabs.js",
		config.src_path + "/js/gravityforms.js",
		config.src_path + "/js/cookie-consent.js",
		config.src_path + "/js/scripts.js",
	])
	.pipe(plumber())
	.pipe(concat("scripts.js"))
	.pipe(
		babel({
			presets: [
				[
					"@babel/env",
					{
						modules: false,
					},
				],
			],
		})
	)
	// And the destination change.
	.pipe(gulp.dest(config.build_path + "/js/temp"));

	const admin = gulp.src([
		config.src_path + "/js/admin/editor-buttons.js",
	])
	.pipe(plumber())
	.pipe(concat("admin.js"))
	.pipe(
		babel({
			presets: [
				[
					"@babel/env",
					{
						modules: false,
					},
				],
			],
		})
	)
	// And the destination change.
	.pipe(gulp.dest(config.build_path + "/js"));

	return merge(scripts, admin);
}

function jsConcat(done) {
	const concat = require("gulp-concat");
	const uglify = require("gulp-uglify");
	const rename = require("gulp-rename");
	const plumber = require("gulp-plumber");
	const stripDebug = require("gulp-strip-debug");

	const files = [
		config.build_path + "/js/temp/deps.js",
		config.build_path + "/js/temp/scripts.js",
	];

	if (isProduction) {
		return gulp
		.src(files)
		.pipe(plumber())
		.pipe(concat("scripts.js"))
		.pipe(stripDebug())
		.pipe(uglify())
		.pipe(rename("scripts.min.js"))
		.pipe(gulp.dest(config.build_path + "/js"));
	}

	// return gulp.src(files)
	// 	.pipe(plumber())
	// 	.pipe(concat('scripts.js'))
	// 	.pipe(gulp.dest(config.build_path + '/js'));

	done();
}

function php(done) {
	reload();

	done();
}

function images() {
	const imagemin = require("gulp-imagemin");
	const imageminPngquant = require("imagemin-pngquant");

	return gulp
	.src(config.src_path + "/images/**/*")
	.pipe(
		imagemin([
			//png
			imageminPngquant({
				speed: 1,
				quality: [0.7, 0.8], //lossy settings
			}),
			imagemin.gifsicle({ interlaced: true }),
			imagemin.jpegtran({ progressive: true }),
			imagemin.svgo({
				plugins: [{ removeViewBox: true }, { cleanupIDs: true }],
			}),
		])
	)
	.pipe(gulp.dest(config.build_path + "/images"));
}

function copy() {
	const merge = require("merge-stream");

	// var styles = gulp.src([
	// ]).pipe(gulp.dest(config.build_path + '/css/vendor'));

	var scripts = gulp
	.src(["./node_modules/jquery/dist/jquery.js"])
	.pipe(gulp.dest(config.build_path + "/js/vendor"));

	// var icons = gulp.src([
	// ]).pipe(gulp.dest(config.build_path + '/icons'));

	var vectors = gulp
	.src(config.src_path + "/vectors/**/*")
	.pipe(gulp.dest(config.build_path + "/vectors"));

	return merge(scripts, vectors);
}

function watch() {

	browserSync.init({
		proxy: 'https://' + config.proxy,
		host: config.proxy
	});

	gulp.watch(config.src_path + "/scss/**/*.scss", sass);
	gulp.watch(
		config.src_path + "/js/**/*.js",
		gulp.series(jsDeps, jsBuild, jsConcat)
	);
	gulp.watch(config.src_path + "/images/**/*", images);
	gulp.watch("./web/app/themes/" + theme_name + "/**/*.php", php);
}

function clean() {
	const del = require("del");

	return del(config.build_path);
}

exports.sass = sass;
exports.css = css;
exports.jsDeps = jsDeps;
exports.jsBuild = jsBuild;
exports.jsConcat = jsConcat;
exports.images = images;
exports.watch = watch;
exports.clean = clean;

exports.default = gulp.series(
	clean,
	copy,
	sass,
	css,
	jsDeps,
	jsBuild,
	jsConcat,
	images,
	watch
);
exports.build = gulp.series(
	clean,
	copy,
	sass,
	css,
	jsDeps,
	jsBuild,
	jsConcat,
	images
);
