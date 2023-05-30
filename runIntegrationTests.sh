#!/bin/sh

# This script will run all integration tests defined in the
# $pathToIntegrationTestDirectory.

pathToIntegrationTestDirectory="tests/integration"

for file in "$pathToIntegrationTestDirectory"/*.php; do
    if [ -f "$file" ]; then
        echo "Running test: $file"
        php "$file"
        echo "-----------------"
    fi
done

