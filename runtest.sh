#!/bin/sh

SEARCH=$1
if [ -z "$SEARCH" ]; then
  SEARCH=*Test.php
fi

for ut in `find test -name "$SEARCH" -or -name "$SEARCH.php" -or -name "${SEARCH}Test.php"`; do
  echo; echo $ut:
  vendor/phpunit/phpunit/phpunit --bootstrap test/Did/Test/Bootstrap.php $ut
done
