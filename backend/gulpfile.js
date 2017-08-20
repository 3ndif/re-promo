/**
* Компиляция .js/.jsx
 *            .css/.scss
 * Включена поддержка ES6
 * @type Module gulp|Module gulp
 */

var gulp = require('gulp'),
    sass = require('gulp-sass'),
    concat = require('gulp-concat'),
    clean = require('gulp-clean'),
    babel = require('gulp-babel'),
    react = require('babel-preset-react'),
    browserify = require('browserify'),
    babelify = require('babelify'),
    source = require('vinyl-source-stream'),
    transform = require('vinyl-transform'),
    uglify = require('gulp-uglify'),
    glob = require('glob'),
    es  = require('event-stream'),
    rename     = require('gulp-rename');
    browserSync = require('browser-sync');


var paths = {
        src: {
            jsx: 'web/app/js/**/*.jsx',
            js: 'web/app/js/**/*.js',
            scss: 'web/app/css/importer.scss',
            main_scss: 'web/app/css/**/*.+(scss|css)'
        },

        build: { //Тут мы укажем куда складывать готовые после сборки файлы
            jsx: 'web/dist/js',
            js: 'web/dist/js',
            scss: 'web/dist/css',
            main_scss: 'web/dist',
        },
        watch: { //Тут мы укажем, за изменением каких файлов мы хотим наблюдать
            jsx: 'web/app/js/**/*.+(js|jsx)',
            scss: 'web/app/scss/*.+(scss|css)',
        },
        clean: {
            scripts: 'web/dist/js',
            styles: 'web/dist/css',
            all: 'web/dist'
        }
};

var slash2dash = function(str) { return str.replace(/\//g,'--'); } // Небольшая функция для преобразования слешей в тирэ
var exclude_ext = function(path, ext) { return path.substr(0, path.indexOf('.'+ext)); }; // Функция для исключения расширения из имени файла

//Получить имя файла
var fname = function(path_to_file){
    return path_to_file.replace(/^.*[\\\/]/, '');
};

gulp.task('sass', function () {
  return gulp.src(paths.src.main_scss)
  .pipe(concat('main.scss'))
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest(paths.build.main_scss))
    .pipe(browserSync.reload({stream: true}));
})

.task('sass:watch', function () {
  gulp.watch(paths.src.main_scss, ['sass:production']);
})

/**
 * Компилируем все .js .jsx скрипты
 */
.task('scripts', function(done) {
    gulp.start('js');
    gulp.start('jsx');
})

/**
 * Компилируем .jsx файлы
 */

/*
.task('jsx', function (done) {

//     var testFiles = glob.sync(paths.src.jsx);
//     return browserify({ entries: [testFiles], extensions: ['.jsx'], debug: false })
//                .transform('babelify', {presets: ['es2015', 'react']})
//                .bundle()
//                .pipe(source('bundle.js'))
//                .pipe(gulp.dest(paths.build.jsx))
//                .pipe(browserSync.reload({stream: true}));

     glob(paths.src.jsx, function(err, files) {

        if(err) done(err);

        var tasks = files.map(function(entry) {

            var filename = slash2dash(entry);

            return browserify({ entries: [entry], extensions: ['.jsx'], debug: false })
                .transform('babelify', {presets: ['es2015', 'react','stage-0']})
//                .require('./'+entry,{ expose: exclude_ext(fname(entry), 'jsx')})
                .bundle()
                .pipe(source(filename))
                .pipe(rename({
                    extname: '.js'
                }))
                .pipe(gulp.dest(paths.build.jsx))
                .pipe(browserSync.reload({stream: true}));
            });

        es.merge(tasks).on('end', done);
    })
})
*/

.task('jsx', function() {
    // we define our input files, which we want to have
    // bundled:
    var files = glob.sync(paths.src.jsx);
    // map them to our stream function
    var tasks = files.map(function(entry) {
        var filename = slash2dash(entry);
        console.log(entry)
        return browserify({ entries: [entry], extensions: ['.jsx'], debug: false})
            .transform('babelify', {presets: ['es2015', 'react','stage-0']})
            .require('./'+entry,{ expose: exclude_ext(fname(entry), 'jsx')})
            .bundle()
            .pipe(source(filename))
            // rename them to have "bundle as postfix"
            .pipe(rename({
                extname: '.js'
            }))
            .pipe(gulp.dest(paths.build.jsx))
            .pipe(browserSync.reload({stream: true}));
        });
    // create a merged stream
    return es.merge.apply(null, tasks);

})
/*
//.task('test',function(){
//    var files = glob.sync(paths.src.jsx);
//
//    return browserify({ entries: files, extensions: ['.jsx'], debug: false})
//            .transform('babelify', {presets: ['es2015', 'react','stage-0']})
//            .bundle()
//            .pipe(source('bundle'))
//            // rename them to have "bundle as postfix"
//            .pipe(rename({
//                extname: '.bundle.js'
//            }))
//            .pipe(gulp.dest(paths.build.jsx));
//})

/**
 * Компилируем .js файлы
 */
.task('js', function (done) {
    glob(paths.src.js, function(err, files) {

        if(err) done(err);

        var tasks = files.map(function(entry) {
            // Вычесляем имя файла, чтоб задать скомпилированному файлу то же имя
            var filename = (slash2dash(entry));

            return gulp.src(entry)
                    .pipe(rename({
                        basename: exclude_ext(filename,'js')
                    }))
                    .pipe(gulp.dest(paths.build.js))
                    .pipe(browserSync.reload({stream: true}));
        });

        es.merge(tasks).on('end', done);
    })

});

gulp.task('browser-sync',function(){
    browserSync({
        proxy: 'http://admin.promo-local',
//        host: "localhost",
//        server: {
//            baseDir: 'backend/web/app'
//        },
    });
});

gulp.task('watch:sass',['browser-sync','sass'], function () {
    gulp.watch(paths.src.main_scss, ['sass']);
});

gulp.task('watch:js',['browser-sync','jsx','js'], function () {
    gulp.watch(paths.src.jsx, ['jsx']);
    gulp.watch(paths.src.js, ['js']);
//    gulp.watch(paths.src.js, ['js']);
});


gulp.task('clean:scrtips', function(){
    return gulp.src(paths.clean.scripts)
            .pipe(clean());
});

gulp.task('clean:styles', function(){
    return gulp.src(paths.clean.styles)
            .pipe(clean());
});

gulp.task('default', ['watch']);