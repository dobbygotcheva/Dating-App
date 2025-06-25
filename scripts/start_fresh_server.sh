#!/bin/bash

echo "Starting Fresh Mismatch Server on Port 8001"
echo "==========================================="

# Kill any existing PHP servers (optional)
echo "Checking for existing PHP servers..."
pkill -f "php -S" 2>/dev/null || echo "No existing PHP servers found"

# Start fresh server
cd mismatch
echo "Starting server on http://localhost:8001"
echo "Press Ctrl+C to stop"
php -S localhost:8001 