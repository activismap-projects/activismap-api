#!/bin/bash

cat <<EOF
*** API Installer started ***
EOF

if [[ "$SYMFONY_ENV" != "prod" ]];then
    cat <<EOF
Warning, this script must not be used if you are not sure because it will override the parameters.yml file.
If you want to execute this script please export the environment var SYMFONY_ENV as 'prod'.
*** Installer finished failed ***
EOF
    exit -1
fi

if [[ -t 0 ]];then
    cat <<EOF
You must provide the content of parameters.yml from stdin
*** Installer finished failed ***
EOF
    exit -2
fi

cat > app/config/parameters.yml

curl -sS https://getcomposer.org/installer -s | php
php composer.phar install --no-scripts --no-dev --optimize-autoloader --ignore-platform-reqs --quiet
php vendor/sensio/distribution-bundle/Sensio/Bundle/DistributionBundle/Resources/bin/build_bootstrap.php

cat <<EOF
*** Installer finished success ***
EOF
exit 0