#!/bin/bash
while true; do 
	status=$(xprop -id $(xdotool getactivewindow) | grep -o "FULLSCREEN")
	cpustatus=$(top -bn1 | grep "Cpu(s)" | sed "s/.*, *\([0-9.]*\)%* id.*/\1/" | awk '{print 100 - $1}')
#	echo $status
if [ "$status" == "FULLSCREEN" ] || [ "$cpustatus" -ge "85" ] || [ "$status" == "FULLSCREEN FULLSCREEN" ];then 
        	pkill xwinwrap
		pkill glava
	else 
		id=$(pgrep xwinwrap)
		if [ -z "$id" ] && [ "$cpustatus" -lt "85" ]; then
		#	sh -c 'glava -d --force-mod=bars' &
		xwinwrap -ov -g 1920x1080+0+0 -ni -- mpv -wid WID ~/Wallpaper/gif/islander.gif --no-osc --no-osd-bar --loop-file --player-operation-mode=cplayer --no-audio --panscan=1.0 --no-input-default-bindings &
		fi
	fi
	sleep 0.1 

done
