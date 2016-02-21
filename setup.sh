#!/bin/bash


# This script changes the namespace for the bundle

USAGE="\e[34mUsage: \e[32m$0 <NameBundle>\e[0m"
ARGNUM=1

if [[ $# != $ARGNUM ]];then
  echo -e "\e[34mERROR: \e[31mThis program takes exactly $ARGNUM arguments\e[0m" >&2
  echo -e $USAGE >&2
  exit 1
fi

OLDBUNDLENAME=`find src/ -type d -name *Bundle -exec basename ̣{} \;`
NEWBUNDLENAME=$1


echo "Working..."
mv src/$OLDBUNDLENAME src/$NEWBUNDLENAME
mv src/$NEWBUNDLENAME/$OLDBUNDLENAME.php src/$NEWBUNDLENAME/$NEWBUNDLENAME.php
find src -type f -exec sed "s/$OLDBUNDLENAME/$NEWBUNDLENAME/g" -i {} \;
find app -type f -exec sed "s/$OLDBUNDLENAME/$NEWBUNDLENAME/g" -i {} \;


#php bin/console doctrine:schema:update --force
#create database test;
#grant all privileges on test.* to test@localhost identified by 'test';
#setfacl -dR -m u:www-data:rwX -m u:lluis:rwX var
#setfacl -R -m u:www-data:rwX -m u:lluis:rwX var




