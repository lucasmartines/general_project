heroku buildpacks:add heroku/nodejs
heroku config:set NPM_CONFIG_PRODUCTION=false

web: vendor/bin/heroku-php-apache2 public/
