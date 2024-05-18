#!/bin/bash

#n=$((RANDOM%2+1))
n=3
/usr/bin/dbus-send --session --type=method_call --dest=org.freedesktop.ScreenSaver /ScreenSaver org.freedesktop.ScreenSaver.Lock &
if [[ "$n" == "1" ]]; then
feh --bg-fill /home/cancel/Wallpaper/madmoon.jpg
	notify-send "Welcome back!" "Alif" --icon=/home/cancel/.battery/linux.png
ffplay -volume 60 -t 8.5 -nodisp -autoexit -loglevel quiet /home/cancel/.battery/Sol-squadron.mp3 
elif [[ "$n" == "2" ]]; then 
	notify-send "Welcome back!" "Alif" --icon=/home/cancel/.battery/linux.png
	ffplay -volume 60 
elif [[ "$n" == "3" ]]; then
	# xwinwrap -ov -ni -g 1920x1080 -- mpv -wid WID --no-osc --panscan=1.0 --no-audio --no-input-default-bindings --player-operation-mode=cplayer --no-osd-bar --no-loop --keep-open=yes /home/cancel/Wallpaper/cnc/cnc.mp4 & 	
	sleep 3 && 
	ffplay -nodisp -autoexit -volume 60 -loglevel quiet /home/cancel/.battery/Bladerunnerstart.mp3 &  
fi
