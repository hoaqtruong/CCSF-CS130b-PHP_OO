find . |grep ".php$" | while read line; do php -l "$line"; done > output
