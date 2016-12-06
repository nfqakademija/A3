'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var sourcemaps = require('gulp-sourcemaps');
var autoprefixer = require('gulp-autoprefixer');
var minifycss = require('gulp-clean-css');
var rename = require('gulp-rename');
var minify = require('gulp-minify');
var plumber = require('gulp-plumber');
var concat = require('gulp-concat');


gulp.task('sass', function () {
    return gulp.src('./app/Resources/scss/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./web/assets/css'));
});

gulp.task('sass-min', function () {
    return gulp.src('./app/Resources/scss/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 2 versions'],
            cascade: false
        }))
        .pipe(rename({suffix: '.min'}))
        .pipe(minifycss())
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./web/assets/css'));
});

gulp.task('js', function() {
    return gulp.src([

        // Grab all js scripts
        './node_modules/jquery/dist/jquery.js',
        './node_modules/js-sha256/src/sha256.js',
        './app/Resources/js/**/*.js'
    ])
        .pipe(sourcemaps.init())
        .pipe(plumber())
        .pipe(concat('app.js'))
        .pipe(sourcemaps.write('./maps'))
        .pipe(gulp.dest('./web/assets/js'))
        .pipe(minify())
        .pipe(gulp.dest('./web/assets/js'))
});

gulp.task('watch', function () {
    gulp.watch('./app/Resources/scss/**/*.scss', ['sass','sass-min']);
    gulp.watch('./app/Resources/js/**/*.js', ['js']);
});