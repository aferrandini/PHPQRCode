# PHP QRCode Library for Symfony2

To install this library please follow the next steps:

## Symfony 2.0.x

First add the repo to your `deps` file:

    [PHPQRCode]
        git=https://github.com/aferrandini/PHPQRCode.git
        target=/phpqrcode

Then install the library with the command:

    ./bin/vendors install

Now the library is installed so, now we need to load in the `autoload.php`

Open the file `./app/autoload.php` and add this line:

    $loader->registerPrefixes(array(
        // ...
        'PHPQRCode' => __DIR__.'/../vendor/phpqrcode/Classes',
        // ...
    ));

Now you can use the PHPQRCode libray everywhere in your Symfony2 app!

## Symfony 2.1.x

1. Install the library:

Change directory to your Symfony2 root and execute:

    git clone https://github.com/aferrandini/PHPQRCode.git vendor/phpqrcode/PHPQRCode

2. Register the library:

Open the file `app/autoload.php` and insert this new line after `$loader = ...`:

    $loader->add('PHPQRCode_', __DIR__.'/../vendor/phpqrcode/PHPQRCode/Classes');

Now you can use the PHPQRCode libray everywhere in your Symfony2 app!

## Usage

Sample code:

    \PHPQRCode_QRcode::png("Test", "/tmp/qrcode.png", 'L', 4, 2);


## Acknowledgements

This library is an import of PHP QR Code by Dominik Dzienia that you can find at http://phpqrcode.sourceforge.net

Based on C libqrencode library (ver. 3.1.1), Copyright (C) 2006-2010 by Kentaro Fukuchi
http://megaui.net/fukuchi/works/qrencode/index.en.html

QR Code is registered trademarks of DENSO WAVE INCORPORATED in JAPAN and other countries.

Reed-Solomon code encoder is written by Phil Karn, KA9Q. Copyright (C) 2002, 2003, 2004, 2006 Phil Karn, KA9Q

