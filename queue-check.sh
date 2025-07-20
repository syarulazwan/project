#!/bin/bash

# PHP 8.2 binary path
PHP="/usr/local/bin/ea-php82"

# Laravel project directory
PROJECT_DIR="/home2/syarulaz/public_html/project"

# Artisan command to monitor
COMMAND="artisan queue:work"

# Log file location
LOG_FILE="$PROJECT_DIR/storage/logs/queue-monitor.log"

# Check if queue:work is running
if pgrep -f "$COMMAND" > /dev/null
then
    echo "$(date '+%Y-%m-%d %H:%M:%S') - queue:work is running." >> $LOG_FILE
else
    echo "$(date '+%Y-%m-%d %H:%M:%S') - queue:work not running. Restarting..." >> $LOG_FILE
    cd $PROJECT_DIR
    nohup $PHP artisan queue:work --tries=3 --timeout=60 >> $LOG_FILE 2>&1 &
fi
