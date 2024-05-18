#!/bin/bash
dir=$(dirname $0)

su cancel -c "env DBUS_SESSION_BUS_ADDRESS=unix:path=/run/user/1000/bus /usr/bin/notify-send 'Oni Chan' 'Youre inserting in me!'"

