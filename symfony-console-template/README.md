# symfony-console-template

## Installation and Run sample command

#### Create project

```
$ git clone https://github.com/xshoji/php-sample-box
$ cd php-sample-box/symfony-console-template
```

You may ignore messages such as "...You are in 'detached HEAD' state...".

#### Composer install

```unix
$ sh bin/composer_install.sh
```

#### Usage

```unix
// Listup commands
$ php app/console

// Execute sample command (Show help)
$ php app/console symfony-console-template:sample --help

// Run sample command (Run sample command)
$ # php app/console symfony-console-template:sample
```


## Create new application

#### Modify application name

You should modify an application name as follows,

```
$ less -N app/config/config.ym
      1 imports:
      2     - { resource: service.yml }
      3
      4 parameters:
      5     application_name: "SimpleConsole" <-- modify
      6     application_version: "1.0.0"

$ less -N composer.json
      1 {
      2     "name": "simple_console", <-- modify
      3     "license": "MIT",
```

#### Generate code

```unix
$ sh bin/create_app.sh --name MyApplication

[Info]
  Application Name              : MyApplication
  Script Directory              : /App/simple_console/bin
  Template Directory            : /App/simple_console/bin/../app/src
  Created application Directory : /App/simple_console/bin/../src/MyApplication
```

#### Show command on generated application

```unix
$ php app/console
SimpleConsole version 1.0.0

...

 MyApplication <-- Added!
  my_application:sample  Sample Command. (Search wikipedia page info from wikipedia API)
 SimpleConsole
  simple_console:sample  Sample Command. (Search wikipedia page info from wikipedia API)
```

## Create single phar file from this project files

You can create Phar file from this project by [clue/phar-composer: Simple phar creation for every PHP project managed via Composer](https://github.com/clue/phar-composer).

Created Phar file is easy portable.

#### Create Phar file

```unix
$ sh bin/create_pahr.sh
> php vendor/bin/phar-composer build .
[1/1] Creating phar imple_console.phar
  - Adding main package

...

  - Setting main/stub
    Using referenced chmod 0644
    Applying chmod 0644

    OK - Creating target/app.phar (10999.5 KiB) completed after 167.1s
```

#### How to run

```
$ php target/app.phar
#!/usr/bin/env php
SimpleConsole version 1.0.0

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display this help message
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi            Force ANSI output
      --no-ansi         Disable ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  help                   Displays help for a command
  list                   Lists commands
 simple_console
  simple_console:sample  Sample Command. (Search wikipedia page info from wikipedia API)
```

## FAQ

#### ext-bcmath

You may find a problem such as follows,

```
...

Updating dependencies (including require-dev)
Your requirements could not be resolved to an installable set of packages.

  Problem 1
    - rych/bytesize v1.0.0 requires ext-bcmath * -> the requested PHP extension bcmath is missing from your system.
    - macfja/phar-builder 0.2.5 requires rych/bytesize ~1.0 -> satisfiable by rych/bytesize[v1.0.0].
    - Installation request for macfja/phar-builder ^0.2.5 -> satisfiable by macfja/phar-builder[0.2.5].

...
```

Solve: install bcmath extension

```
$ yum install php-bcmath -y
```

## Reference

 - [Symfony2 Console component, by example — Loïc Faugeron — Technical Blog](https://gnugat.github.io/2014/04/09/sf2-console-component-by-example.html)
  - [git clone - Download a specific tag with Git - Stack Overflow](http://stackoverflow.com/questions/791959/download-a-specific-tag-with-git)

## License

MIT
