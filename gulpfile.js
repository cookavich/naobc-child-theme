var gulp = require('gulp');
var sass = require('gulp-sass');
var autoprefixer = require('gulp-autoprefixer');

gulp.task('sass', function(){
    return gulp.src('./style.scss')
        .pipe(sass())
        .pipe(autoprefixer())
        .pipe(gulp.dest('./'))
});

gulp.task('watch', function(){
    gulp.watch('./**/*.scss', ['sass']);
});