
var gulp = require('gulp'),
    runSequence = require('run-sequence'),
    less = require('gulp-less'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    del = require('del');

gulp.task('clean', function() {
    return del(['./web/assets']);
});

gulp.task('less', function() {
    return gulp.src(['app/Resources/assets/less/main.less', 'app/Resources/assets/vendor/fontawesome/less/font-awesome.less'])
        .pipe(less())
        .pipe(concat('main.css'))
        .pipe(gulp.dest('./web/assets/css'));
});

gulp.task('bootstrap', function() {
    return gulp.src(['app/Resources/assets/vendor/jquery/dist/jquery.js', 'app/Resources/assets/vendor/bootstrap/dist/bootstrap.js'])
       .pipe(uglify())
       .pipe(concat('bootstrap.js'))
       .pipe(gulp.dest('./web/assets/js'));
});

gulp.task('fa', function () {
    gulp.src('app/Resources/assets/vendor/fontawesome/fonts/*')
        .pipe(gulp.dest('./web/assets/fonts'));
});

gulp.task('default', function(callback) {
    runSequence(
        'clean',
        ['less', 'bootstrap', 'fa'],
        callback
    );
});
