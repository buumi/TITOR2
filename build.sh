#!/bin/bash
set -ev

# Run tests
cd tests
phpunit --coverage-clover tests-clover.xml --log-junit tests-junit.xml .

# Run SonarQube analysis
cd ..
wget https://sonarsource.bintray.com/Distribution/sonar-scanner-cli/sonar-scanner-2.5.zip
unzip sonar-scanner-2.5.zip

cat > sonar-project.properties << EOL
sonar.login=${SONAR_LOGIN}
sonar.password=${SONAR_PASSWORD}
sonar.projectKey=TITOR2
sonar.projectName=TITOR2
sonar.projectVersion=1.0ALPHA
sonar.sources=src
sonar.tests=tests
sonar.php.tests.reportPath=tests/tests-junit.xml
sonar.php.coverage.reportPath=tests/tests-clover.xml
sonar.coverage.exclusions=tests/*.php
sonar.host.url=http://buumi.me:9000
EOL

./sonar-scanner-2.5/bin/sonar-runner
