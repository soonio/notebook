#!/usr/bin/env bash

source ./_tips.sh

tips "测试123"

# shellcheck disable=SC2087
(
  ssh -p22 ubuntu@101.34.92.30 <<- EOF
    $(declare -f)
    tips "发布成功"
EOF
) || exit 1


#
exit 0