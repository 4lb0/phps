# PHP Server

![Usage screenshot](https://user-images.githubusercontent.com/142173/139636053-e3d177a7-1cab-4012-bd17-a203869eaa5a.png)

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

**Save parameters in composer.json**

You may add `[-t docroot] [router]` in a custom key  `phps` in the `config` section of your composer.json.

For example if you run it `phps -r -t public app.php` add the following configuration to your composer.json and then run it with just `php -r`

    "config": {
      "phps": "-t public app.php"
    }


**Requirements:**

* PHP version 5.4 or newer versions
* Bash support
* Optional: [LiveReload](https://www.npmjs.com/package/livereload)
