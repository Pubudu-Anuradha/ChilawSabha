#!/bin/bash
testReport="test-report.txt"
# Running this script will run all the tests in the core folder
# and output the results to a file called test-report.txt
# Phpunit must be installed via composer for this to work
echo $tests
echo "Running tests" > $testReport
for test in ./core/test*.php; do
    echo "" | tee -a $testReport
    echo "=========================" | tee -a $testReport
    echo "Running Tests on $test" | tee -a $testReport
    echo "=========================" | tee -a $testReport
    ../vendor/bin/phpunit --display-warnings $test | tee -a $testReport
done