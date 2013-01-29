# PHP QRCode Library for Symfony2

To install this library please follow the next steps:

## If you are running Symfony 2.1.x and 2.2.x

### Install the library using `composer`:

Add the required module to your `composer.json` file:

    {
        "require": {
            ...
            "aferrandini/phpqrcode": "master-dev"
            ...
        }
    }

Then run the command `composer update`.

### Install the library with `git clone`:

Change directory to your Symfony2 root and execute:

    git clone https://github.com/aferrandini/PHPQRCode.git vendor/aferrandini/PHPQRCode

Register the library:

Open the file `app/autoload.php` and insert this new line after `$loader = ...`:

    $loader->add('PHPQRCode', __DIR__.'/../vendor/aferrandini/phpqrcode/PHPQRCode/lib');

## If you are running Symfony 2.0.x :(

First add the repo to your `deps` file:

    [PHPQRCode]
        git=https://github.com/aferrandini/PHPQRCode.git
        target=/phpqrcode

Then install the library with the command:

    ./bin/vendors install

Now the library is installed so, now we need to load in the `autoload.php`

Open the file `./app/autload.php` and add this line:

    require __DIR__ . '/../vendor/aferrandini/PHPQRCode/lib/Autoloader.php';


## Usage

Sample code:

    \PHPQRCode\QRcode::png("Test", "/tmp/qrcode.png", 'L', 4, 2);


## Acknowledgements

This library is an import of PHP QR Code by Dominik Dzienia that you can find at http://phpqrcode.sourceforge.net

Based on C libqrencode library (ver. 3.1.1), Copyright (C) 2006-2010 by Kentaro Fukuchi
http://megaui.net/fukuchi/works/qrencode/index.en.html

QR Code is registered trademarks of DENSO WAVE INCORPORATED in JAPAN and other countries.

Reed-Solomon code encoder is written by Phil Karn, KA9Q. Copyright (C) 2002, 2003, 2004, 2006 Phil Karn, KA9Q