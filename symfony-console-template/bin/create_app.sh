#!/bin/bash

function usage()
{
    cat <<_EOT_

#==========================================
#
# Usage: sh $(basename "$0") --name [application_name]
#
# Description:
#   Create application files to "src"
#
# Example:
#   $ sh $(basename "$0") --name SampleBatch
#
#==========================================

_EOT_
    exit 1
}

#==========================================
# Preparation
#==========================================

set -eu

# オプション値のパース
APP_NAME=
for ARG in "$@"
do
    if [ ${ARG} == "--name" ]; then
        shift 1
        APP_NAME=${1}
        shift 1
    fi
done

# 引数確認
[ -z "${APP_NAME}" ] && { usage; exit 1; }



#==========================================
# main
#==========================================

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
TEMPLATE_APP_DIR=${SCRIPT_DIR}/../app/src
CREATED_APP_DIR=${SCRIPT_DIR}/../src/${APP_NAME}

if sed --version 2>/dev/null | grep -q GNU; then
  SNAKE_CASE_APP_NAME=$(sed -e 's/\([A-Z]\)/_\L\1/g' -e 's/^_//'  <<< "${APP_NAME}")
else
  # @see PerlでCamelize/DeCamelize - kawamuray's blog http://kawamuray.hatenablog.com/entry/2013/08/12/154443
  SNAKE_CASE_APP_NAME=$(echo ${APP_NAME} | perl -ne 'print lc(join("-", split(/(?=[A-Z])/)))')
fi



echo ""
echo "[Info]"
echo "  Application Name              : ${APP_NAME}"
echo "  Script Directory              : ${SCRIPT_DIR}"
echo "  Template Directory            : ${TEMPLATE_APP_DIR}"
echo "  Created application Directory : ${CREATED_APP_DIR}"
echo ""

# start
mkdir ${CREATED_APP_DIR}
cp -R ${TEMPLATE_APP_DIR}/* ${CREATED_APP_DIR}/

if sed --version 2>/dev/null | grep -q GNU; then
  SED_I=
else
  SED_I=''
fi

find ${CREATED_APP_DIR} -type f | xargs sed -i "${SED_I}" -e "s/SimpleConsole/${APP_NAME}/g"
find ${CREATED_APP_DIR} -type f | xargs sed -i "${SED_I}" -e "s/simple_console:sample/${SNAKE_CASE_APP_NAME}:sample/g"


