#!/bin/sh
dir=$(dirname $0)
bat_files="/sys/class/power_supply/BAT1"
bat_status=$(cat "${bat_files}/status")
capacity=$(cat "${bat_files}/capacity")
if [[ "${bat_status}" == "Discharging" ]] && [[ "${capacity}" -le 20 ]] && [[ "${capacity}" -ge 10 ]]; then
    notify-send "~Oni-chan!" "Your battery is low at "${capacity}"" --icon=$dir/lowBattery.jpg && ffplay -nodisp -autoexit -volume 20 -loglevel quiet $dir/Google-notification.mp3
    exit 0 
elif [[ "${bat_status}" == "Charging" ]] && [[ "${capacity}" -ge 95 ]]; then
	notify-send "~Oni-chan!" "I'm full" --icon=$dir/lowBattery.jpg && ffplay -nodisp -autoexit -volume 20 -loglevel quiet $dir/Google-notification.mp3
	exit 0 
elif [[ "${capacity}" -lt 10 ]] && [[ "${bat_status}" == "Discharging" ]]; then 
	notify-send "~Oni-chan! I'm really hungry!" "Please feed me!" --icon=$dir/lowBattery.jpg && ffplay -nodisp -autoexit -volume 20 -loglevel quiet $dir/Google-notification.mp3
fi
