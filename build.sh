#!/bin/bash
set -ev

# Run tests
cd tests
phpunit --coverage-clover tests-clover.xml --log-junit tests-junit.xml .

