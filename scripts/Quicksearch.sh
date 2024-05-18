#!/bin/bash

dir=$(dirname $0)
if [[ -z $WAYLAND_DISPLAY ]]; then
	link=$(cat $dir/bookmarks | rofi -dmenu -config /home/$(whoami)/.cache/wal/colors-rofi-dark.rasi)
else
        link=$(cat $dir/bookmarks | wofi --dmenu)	
fi

if [[ -n $link ]]; then 
       notify-send -t 3000 Success! 'Link selected!' 
       xdg-open $link 
else  
	notify-send -t 3000 Canceled! 'No link selected'
fi
