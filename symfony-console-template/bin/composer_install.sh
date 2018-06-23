#!/bin/bash

function usage()
{
    cat <<_EOT_

#==========================================================
# Outline
#  Install vendors using composer
#
# Example
#   $ sh composer_install.sh
#
#==========================================================

_EOT_
    exit 1
}

# Default parameters
PROJECT_DIR="$(cd $(dirname ${BASH_SOURCE:-$0})/.. && pwd)"
VENDOR_DIR_PATH=${PROJECT_DIR}/vendor
COMPOSER_PHAR_PATH=${PROJECT_DIR}/composer.phar

#==========================================================
# Main
#==========================================================

# Delete an existing vendor dir.
echo "start : "`date +%Y\-%m\-%d\ %H\:%M\:%S`

if [ -d ${VENDOR_DIR_PATH} ]; then
    echo ">>> remove vendors directory."
    rm -rf ${VENDOR_DIR_PATH}
fi

if [ ! -e ${COMPOSER_PHAR_PATH} ]; then
    curl -s http://getcomposer.org/installer | php
fi

# Install
php ${COMPOSER_PHAR_PATH} install

echo "finish : "`date +%Y\-%m\-%d\ %H\:%M\:%S`
