# PHP Helpers
These are some classes that aim to facilitate PHP developments and use less procedural functions.

[![Latest Stable Version](https://img.shields.io/packagist/v/phpunit/phpunit.svg?style=flat-square)](https://packagist.org/packages/phpunit/phpunit)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.3-8892BF.svg?style=flat-square)](https://php.net/)

## Installation
##### With composer :  
```bash
$ composer require redlab-team/php-helpers
```  
##### Without composer :
You can just [download the archive](https://github.com/REDLab-Team/php-helpers/archive/master.zip) and unzip it into
your own project.

## License
This package is released under the MIT License. See the [LICENSE](./LICENSE) file for more details.

## Usage
Most of the classes juste contains static methods. But it is possible to extends them if you need to add some attribute
for you developments.  
The helpers that are available are :
- Arr class to manipulate arrays variables
- Date class to manipulate dates variables
- Json class to encode and decode JSON format. This class needs to be instanciated.
- Str class to manipulate strings.