#!/bin/bash

# Path PHP berdasarkan output: which php
PHP="/usr/local/bin/php"

# Lokasi projek Laravel
PROJECT_DIR="/home2/syarulaz/public_html/project"

# Command artisan untuk dipantau
COMMAND="artisan queue:work"

# Log file (untuk debug / audit)
LOG_FILE="$PROJECT_DIR/storage/logs/queue-monitor.log"

# Semak jika queue:work sedang hidup
if pgrep -f "$COMMAND" > /dev/null
then
    echo "$(date '+%Y-%m-%d %H:%M:%S') - queue:work is running." >> $LOG_FILE
else
    echo "$(date '+%Y-%m-%d %H:%M:%S') - queue:work not running. Restarting..." >> $LOG_FILE
    cd $PROJECT_DIR
    nohup $PHP artisan queue:work --tries=3 --timeout=60 >> $LOG_FILE 2>&1 &
fi
