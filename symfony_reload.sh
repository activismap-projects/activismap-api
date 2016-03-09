#!/bin/bash

cat <<EOF
*** Reloading configuration ***
EOF

php app/console doctrine:schema:update --force --env=prod
php app/console cache:clear --env=prod

cat <<EOF
*** DONE ***
EOF
exit 0