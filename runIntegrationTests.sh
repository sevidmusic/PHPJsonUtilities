#!/bin/sh

pathToIntegrationTestDirectory="tests/integration"

for file in "$pathToIntegrationTestDirectory"/*.php; do
    if [ -f "$file" ]; then
        echo "Running test: $file"
        php "$file"
        echo "-----------------"
    fi
done

