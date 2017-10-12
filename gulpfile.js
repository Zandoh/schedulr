//gulp default will run tasks once include watch
//gulp watch will be watching for file changes in js modules folders and scss modules folders
//gulp concat will concatenate all the modules into one file
//gulp minify will minify the concatenated file
//gulp rename will rename the  minified file
//gulp dest will spit the renamed minifed file into the proper directory 

var gulp = require('gulp');
var gutil = require('gulp-util');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');

var paths = {
  scripts: 'js/modules/**/*.js',
  sass: 'scss/modules/**/*.scss'
};

gulp.task('scripts', function() {
    gulp.src(paths.scripts)
        .pipe(uglify())
        .pipe(concat('scripts.min.js'))
        .pipe(gulp.dest('js/'));
});
  
gulp.task('sass', function() {
    gulp.src(paths.sass)
        .pipe(sass({style: 'expanded'}))
            .on('error', gutil.log)
        .pipe(concat('styles.css'))
        .pipe(gulp.dest('css/'))
});

// Rerun the task when a file changes
gulp.task('watch', function() {
    gulp.watch(paths.scripts, ['scripts']);
    gulp.watch(paths.sass, ['sass']);
});

// The default task (called when you run `gulp` from cli)
gulp.task('default', ['scripts', 'sass', 'watch']);