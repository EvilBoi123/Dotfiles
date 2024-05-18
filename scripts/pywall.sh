#!/bin/bash
waybar_old_line=202
waybar_old_color=$(sed -n "$waybar_old_line"p .config/waybar/style.css | awk '{print $2}')
waybar_new_color=$(grep -i 'color10' .cache/wal/colors-kitty.conf | awk '{print $2}')
wal -i $1 
sed -i '2173,2192d' /home/cancel/.config/kitty/kitty.conf
sed -i '2173,2192d' /home/cancel/.config/kitty/kitty.wayfire
cat /home/cancel/.cache/wal/colors-kitty.conf >> /home/cancel/.config/kitty/kitty.conf	
cat /home/cancel/.cache/wal/colors-kitty.conf >> /home/cancel/.config/kitty/kitty.wayfire
sed -i s/"$waybar_old_color"/"$waybar_new_color;"/ .config/waybar/style.css 
#
# Relaunch Waybar
pkill waybar
waybar &
