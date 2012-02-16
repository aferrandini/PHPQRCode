# PHP QRCode Library #

To install this library please follow the next steps:

First add the repo to your deps file:

    [PHPQRCode]
        git=https://github.com/aferrandini/PHPQRCode.git
        target=/phpqrcode

Then install the library with the command:

    ./bin/vendors install

Now the library is installed so, now we need to load in the autoload.php

Open the file ./app/autoload.php and add this line

    $loader->registerPrefixes(array(
        ...
        'PHPQRCode'        => __DIR__.'/../vendor/phpqrcode/Classes',
        ....
    ));

Now you can use the PHPQRCode libray everywhere in your Symfony2 app!

Sample code:

    \PHPQRCode_QRcode::png($attendee->getSlug(), $qrcode_directory . $attendee->getSlug(), 'L', 4, 2);
