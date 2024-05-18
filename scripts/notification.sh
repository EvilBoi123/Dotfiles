#!/bin/sh
capacity=$(cat /sys/class/power_supply/BAT1/capacity)
su cancel -c "env DBUS_SESSION_BUS_ADDRESS=unix:path=/run/user/1000/bus notify-send -t 3000 "Oni-Chan!" Your\ battery\ is\ at\ $capacity"
#su cancel -c "echo 200 > /sys/class/backlight/amdgpu_bl0/brightness"
#su cancel -c "paplay --server=/run/user/1000/pulse/native /home/cancel/test.wav"
