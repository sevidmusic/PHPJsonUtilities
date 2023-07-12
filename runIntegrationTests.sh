#!/bin/sh

# This script will run all integration tests defined in the
# $pathToIntegrationTestDirectory.

pathToIntegrationTestDirectory="tests/integration"

for file in "$pathToIntegrationTestDirectory"/*.php; do
    if [ -f "$file" ]; then
        php "$file"
        echo
        echo
    fi
done

