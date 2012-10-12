# Description

The LogMore class is a minimalist PHP logging tool for versions >= PHP 5.2, that provides wrappers for the PHP functions openlog, closelog and syslog.


# Usage example from within PHP

	require('vendor/codeless/logmore/src/logmore.php');

 	# Opening of the log is not required, but recommended.
 	# Here you can pass an ident-string of your application,
 	# which makes filtering of the messages easier later on:
 	LogMore::open('nameOfApplication');

 	# Possible priorities for messages:
 	LogMore::emerg('a emergency message');
 	LogMore::alert('an alert message');
 	LogMore::crit('a critical message');
 	LogMore::err('an error message');
 	LogMore::warning('a warning');
 	LogMore::notice('a notice');
 	LogMore::info('a informative message');
 	LogMore::debug('a debug message');

 	# All messages are formated via (vs)printf,
 	# so the following is possible:
 	LogMore::debug('Variable $test is of type %s', gettype($test));

 	# The number of arguments to the logging functions
 	# is not restricted by LogMore:
 	LogMore::notice(
 		'Message string coming from file %s at line %i ...',
 		__FILE__,
 		__LINE__,
 		...);

 	# Disable logging:
 	LogMore::disable();
 	# Won't land in the logfile:
 	LogMore::debug('A debug message');

 	# Enable logging:
 	LogMore::enable();
 	# Will land in the logfile again:
 	LogMore::debug('Another debug message');

Using LogMore with the Unix/Linux tail-command works very well. While developing, catch the appendage to the logfile by entering the following command on the shell:

 	/usr/bin/tail -F /path/to/error.log


# Multiple logs

LogMore prevents the usage of multiple logs with different idents. After LogMore::open has been called with the ident "x", LogMore will ignore any other call to open() if close() hasn't been called inbetween:

	LogMore::open('ident1');
	LogMore::open('ident2');
	LogMore::debug('A message'); # Still logging with ident1!

	LogMore::close(); # Closing ident1
	LogMore::open('ident2');
	LogMore::debug('A message'); # Logging with ident2!


# Installation

Either install LogMore by downloading the src/logmore.php file or by using packagist/composer (see Resources-section).


# Compiling

LogMore comes "compiled" already and is ready to be used in your PHP applications. If you want to modify LogMore, please take a look at the accompanied Makefile.


# Documentation

Documentation is not included by default but can be compiled using Natural Docs. When you have Natural Docs installed, simply type

 	make doc

on your commandline in the root-directory of LogMore.


# Resources

- PHP manual about opelog, closelog & syslog: http://www.php.net/manual/en/ref.network.php
- AutoGen, the Automated Text and Program Generation Tool: http://www.gnu.org/software/autogen
- Travis.ci - Continious Integration for the opensource scene: <http://www.travis-ci.org>
- Packagist - PHP package archivist: http://www.packagist.org
- Composer - Dependency manager for PHP: http://www.getcomposer.org


# Ideas for improving LogMore

- Enabling/disabling logging of individual priorities to reduce syslog()-calls


# Credits and Bugreports

LogMore was written by Codeless (http://www.codeless.at/). All bugreports can be directed to more@codeless.at -- even better bugreports are posted on the github-repository of this package: https://www.github.com/codeless/logmore


# License

This work is licensed under a Creative Commons Attribution 3.0 Unported License: <http://creativecommons.org/licenses/by/3.0/deed.en_US>
