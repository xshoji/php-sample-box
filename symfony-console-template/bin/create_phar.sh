#!/bin/bash

PROJECT_DIR="$(cd $(dirname ${BASH_SOURCE:-$0})/.. && pwd)"
PHAR_COMPOSER_PATH=${PROJECT_DIR}/phar-composer.phar

if [ ! -e ${PHAR_COMPOSER_PATH} ]; then
    curl -L -O https://github.com/clue/phar-composer/releases/download/v1.0.0/phar-composer.phar
fi

php -d phar.readonly=0 ${PHAR_COMPOSER_PATH} build . target/app.phar
