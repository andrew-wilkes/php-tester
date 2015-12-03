# php-tester
PHP unit testing with Karma and Jasmine.

## Requirements

nodejs

webserver running PHP5 e.g. IIS, Apache2

## Installation

Download the code:
`npm install php-tester`

Change to the php-tester directory:
`cd node_modules/php-tester`

Install the dependencies:
`npm install`

Open `tests/karma.conf.js` in a text editor.

Edit the URL for the location of: `tests/php/test.php` in the files list
```
    files: [
      'js/*Spec.js',
      'http://localhost/tests/php/test.php'
```
Note: `test.php` produces javascript code for the Jasmine testing framework.

## Running Tests

Example PHP test specs are in the `tests/php/specs/` folder.

Run the tests from the command line with:

`npm test`

Read more at the [Home Page](http://jsphp.io/php-unit-testing.php)
