#!/usr/bin/env bash

PHPS_PROTOCOL="http"
echo -e "\e[1m\e[33mPHP Server\e[0m\n"
case $1 in
    -r|--random)
        PHPS_RANDOM=$(($RANDOM % 500))
        PHPS_PORT=$((28000 + $PHPS_RANDOM))
        PHPS_LIVERELOAD_PORT=$((29000 + $PHPS_RANDOM))
        PHPS_LIVERELOAD="livereload --port $PHPS_LIVERELOAD_PORT"
        PHPS_PARAMS="php -S \"0.0.0.0:$PHPS_PORT\" ${@:2}"
    ;;
    -h|--help)
        echo -e "An improvement for the built-in web server."
        echo -e "It uses 8080 port by default or set option -r to use a random port."
        echo -e "It has support for LiveReload."
        echo -e "Usage: $0 [-r] [-t docroot] [router]"
        echo -e "Options:"
        echo -e "-r, --random\tRun PHP and Livereload on random ports."
        echo -e "-t, --docroot\tStarting with a specific document root directory"
        echo -e "-h, --help\tShow this help"
        exit
    ;;
    *)
       PHPS_PORT="8080"
       PHPS_LIVERELOAD="livereload"
       PHPS_PARAMS="php -S \"0.0.0.0:$PHPS_PORT\" $@"
    ;;
esac
command -v livereload &> /dev/null || echo -e "\e[31mLivereload not detected.\e[0m To install it run:\n\nnpm install -g livereload\n"
echo -e "Available on:"
ip -4 address show | grep -B 3 "enp\|wlp\|lo:" | grep inet | sed -rn "s/inet ([^\/]+)\/.*/\o033[36m$PHPS_PROTOCOL:\/\/\1:$PHPS_PORT\o033[0m/gp"
echo -e "\nHit CTRL-C to stop the server\n"
(trap 'kill 0' SIGINT;  eval $PHPS_PARAMS & eval "$PHPS_LIVERELOAD 2> /dev/null")
