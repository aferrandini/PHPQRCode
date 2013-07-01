# PHP QRCode Library

To install this library please follow the next steps:

## Install the library using `composer`:

Add the required module to your `composer.json` file:

    {
        "require": {
            ...
            "aferrandini/phpqrcode": "dev-master"
            ...
        }
    }

Then run the command `composer update`.

## If you are running Symfony 2.0.x

Register the library:

Open the file `app/autoload.php` and insert this new line after `$loader = ...`:

    $loader->add('PHPQRCode', __DIR__ . '/../vendor/aferrandini/phpqrcode/lib');

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

This code will generate a PNG file on '/tmp/qrcode.png' with a QRCode that contains the word 'Test'.

## Acknowledgements

This library is an import of PHP QR Code by Dominik Dzienia that you can find at http://phpqrcode.sourceforge.net

Based on C libqrencode library (ver. 3.1.1), Copyright (C) 2006-2010 by Kentaro Fukuchi
http://megaui.net/fukuchi/works/qrencode/index.en.html

QR Code is registered trademarks of DENSO WAVE INCORPORATED in JAPAN and other countries.

Reed-Solomon code encoder is written by Phil Karn, KA9Q. Copyright (C) 2002, 2003, 2004, 2006 Phil Karn, KA9Q
