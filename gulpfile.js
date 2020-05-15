const gulp = require('gulp');
const yargs = require('yargs');
const sass = require('gulp-sass');
const cleanCSS = require('gulp-clean-css');
const gulpIf = require('gulp-if');
const minify = require('gulp-minify');
const wpPot = require('gulp-wp-pot');

const PRODUCTION = yargs.argv.prod;

gulp.task( 'styles', () => {
    return gulp.src( 'src/sass/main.scss' )
               .pipe( sass().on( 'error', sass.logError ) )
               .pipe( gulpIf( PRODUCTION, cleanCSS({compatibility: 'ie8'} ) ) )
               .pipe( gulp.dest( 'dist/' ) );
});

gulp.task( 'scripts', () => {
    return gulp.src( ['src/js/agiledrop-form.js', 'src/js/agiledrop-form-admin.js'] )
               .pipe( gulpIf( PRODUCTION, minify() ) )
               .pipe(gulp.dest('dist'))
});

gulp.task( 'watch', () => {
   watch( 'src/sass/main.scss', styles );
});

gulp.task('build', gulp.parallel('scripts', 'styles'));

gulp.task( 'translate', () => {
    return gulp.src(['templates/*.php', 'inc/*.php'])
               .pipe(wpPot({domain: 'agiledrop-domain'}))
               .pipe(gulp.dest('languages/agiledrop-domain.pot'));
});