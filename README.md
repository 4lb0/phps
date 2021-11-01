# PHP Server

An improvement for the [built-in web server](https://www.php.net/manual/en/features.commandline.webserver.php). 
It uses 8080 port by default or set option `-r` to use a random port.
Also run [LiveReload](https://www.npmjs.com/package/livereload) if available.

**Usage:**

    phps [-r] [-t docroot] [router]

**Options:**

* `-r, --random`	Run PHP and Livereload on random ports.
* `-t, --docroot`	Starting with a specific document root directory
* `-h, --help`	Show this help

**Set up:**

Use composer 

    composer global require 4lb0/phps

Or download the [phps](/phps) file.

**Requirements:**

* PHP version 5.4 or newer versions
* Bash support
* Optional: [LiveReload](https://www.npmjs.com/package/livereload)
