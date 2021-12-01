#!/usr/bin/env bash

PHPS_PROTOCOL="http"
PHPS_SERVER="0.0.0.0"

echo -e "\e[1m\e[33mPHP Server\e[0m\n"
case $1 in
    -r|--random)
        PHPS_RANDOM=$(($RANDOM % 500))
        PHPS_PORT=$((28000 + $PHPS_RANDOM))
        PHPS_LIVERELOAD_PORT=$((29000 + $PHPS_RANDOM))
        PHPS_LIVERELOAD="livereload --port $PHPS_LIVERELOAD_PORT"
        PHPS_PARAMS="${@:2}"
    ;;
    -h|--help)
        echo -e "An improvement for the built-in web server."
        echo ""
        echo -e "It uses 8080 port by default or set option -r to use a random port."
        echo -e "Also run LiveReload if available."
        echo -e "Reads the \e[35mphps\e[0m key in the \e[35mextra\e[0m section in composer.json if it's configured."
        echo ""
        echo -e "Go to https://github.com/4lb0/phps for more information."
        echo ""
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
       PHPS_PARAMS="$@"
    ;;
esac

config=$(composer config extra.phps --absolute --quiet 2> /dev/null || echo $PHPS_PARAMS)
if [ "${config:0:1}" = "{" ]; then
    config=""
    router=$(composer config extra.phps.router --absolute --quiet 2> /dev/null)
    docroot=$(composer config extra.phps.docroot --absolute --quiet 2> /dev/null)
    extra_extensions=$(composer config extra.phps.extraExtensions --absolute --quiet 2> /dev/null)
    php_config=$(composer config extra.phps.config --absolute --quiet 2> /dev/null)
    [[ ! -z "$extra_extensions" ]] && PHPS_LIVERELOAD="$PHPS_LIVERELOAD -ee \"$extra_extensions\""
    [[ ! -z "$docroot" ]] && config="$config --docroot=$docroot"
    [[ ! -z "$php_config" ]] && config="$config --php-ini=$php_config"
    config="$config $router"
fi

PHPS_SERVER_RUN="php -S \"${PHPS_SERVER}:${PHPS_PORT}\" $config"

command -v livereload &> /dev/null || echo -e "\e[31mLivereload not detected.\e[0m To install it run:\n\nnpm install -g livereload\n"

echo -e "Available on:"
ip -4 address show | grep -B 3 "enp\|wlp\|lo:" | grep inet | sed -rn "s/inet ([^\/]+)\/.*/\o033[36m$PHPS_PROTOCOL:\/\/\1:$PHPS_PORT\o033[0m/gp"
echo -e "\nHit CTRL-C to stop the server\n"
(trap 'kill 0' SIGINT;  eval $PHPS_SERVER_RUN & eval "$PHPS_LIVERELOAD 2> /dev/null")
