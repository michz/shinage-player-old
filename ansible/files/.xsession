#!/bin/bash

# run window manager
/usr/bin/matchbox-window-manager -use_titlebar no -use_cursor no &
sleep 1

# run browser
/usr/local/bin/run-browser.sh
