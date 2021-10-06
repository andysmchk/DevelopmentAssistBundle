![workflow](https://github.com/andysmchk/DevelopmentAssistBundle/actions/workflows/test.yml/badge.svg)

Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require rewsam/development-assist
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require rewsam/development-assist
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Rewsam\DevelopmentAssist\DevelopmentAssistBundle::class => ['dev' => true],
];
```
for the symfony projects with legacy app directory structure
update `app/AppKernel.php` instead:

```php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            // ...
            new Rewsam\DevelopmentAssist\DevelopmentAssistBundle(),
        ];

        // ...
    }

    // ...
}
```
