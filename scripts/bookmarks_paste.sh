#!/bin/bash
dir=$(dirname $0)
echo $dir
copied=$(wl-paste | grep "^http*");
if [[ -n "$copied" ]] && [[ "$copied" != "$(grep "$(wl-paste)" $dir/bookmarks)" ]];then 
	wl-paste >> $dir/bookmarks && notify-send -t 3000 Success Bookmark\ has\ saved!

elif [[ -n $copied ]]; then 
	notify-send Oops! -t 3000 'It seems the link is already in there!'
else 
	notify-send Oops! -t 3000 "That doesn't seem like link bro"
fi
