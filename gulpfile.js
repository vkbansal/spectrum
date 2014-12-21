var path = require('path'),
    gulp = require('gulp'),
    phpunit = require('gulp-phpunit'),
    notify = require('gulp-notify'),
    version = require('./package.json').version,
    replace = require('gulp-replace'),
    semver = require('semver-regex'),
    test = null,
    notice = {
        phpunit:{
            pass:{
                title: "PHPUnit",
                message: "All tests passed!"
            },
            fail:{
                title: "PHPUnit",
                message: "One or more tests failed!"
            },
        }
    };

function notifyText(test, status){
    var obj = notice[test][status];
    obj.icon = path.join(process.cwd(), 'node_modules', 'gulp-phpunit', 'assets', 'test-' + status +'.png');
    return obj;
}

function handleErrors(){
    args = Array.prototype.slice.call(arguments);
    notify.onError(notifyText(test,'fail')).apply(this, args);
    this.emit('end');
}

gulp.task('default', ['phpunit', 'watch']);

gulp.task('watch', function(){
    return gulp.watch('**/*.php', ['phpunit']);
});

gulp.task('phpunit', function(){
    test = 'phpunit';
    return gulp.src('phpunit.xml.dist')
        .pipe(phpunit('', {notify: true, debug:true}))
        .on('error', handleErrors)
        .pipe(notify(notifyText(test, 'pass')));
});

gulp.task('bump', function(){
    return gulp.src(['src/**/*.php'])
        .pipe(replace(/(\s?\*\s+?@version\s+?)(\bv?(?:0|[1-9][0-9]*)\.(?:0|[1-9][0-9]*)\.(?:0|[1-9][0-9]*)(?:-[\da-z\-]+(?:\.[\da-z\-]+)*)?(?:\+[\da-z\-]+(?:\.[\da-z\-]+)*)?\b)/img, "$1"+version))
        .pipe(gulp.dest('./src/'));

});

gulp.task('test', ['phpunit']);
