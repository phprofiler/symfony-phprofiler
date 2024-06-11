# Symfony PHProfiler Bundle

[![Latest Stable Version](http://poser.pugx.org/phprofiler/symfony-phprofiler/v)](https://packagist.org/packages/phprofiler/symfony-phprofiler)
[![Total Downloads](http://poser.pugx.org/phprofiler/symfony-phprofiler/downloads)](https://packagist.org/packages/phprofiler/symfony-phprofiler)
[![Latest Unstable Version](http://poser.pugx.org/phprofiler/symfony-phprofiler/v/unstable)](https://packagist.org/packages/phprofiler/symfony-phprofiler)
[![License](http://poser.pugx.org/phprofiler/symfony-phprofiler/license)](https://packagist.org/packages/phprofiler/symfony-phprofiler)
[![PHP Version Require](http://poser.pugx.org/phprofiler/symfony-phprofiler/require/php)](https://packagist.org/packages/phprofiler/symfony-phprofiler)

Laravel middleware to capture PHProfiler profiling data. This bundle is compatible with Symfony 5.4, 6.0, and 7.0.

## Installation

You can install the bundle via composer:

```bash
composer require phprofiler/symfony-phprofiler
```

## Configuration
Add the following environment variables to your .env file:
```dotenv
PHPROFILER_ENABLED=true
PHPROFILER_DSN={Get your DSN from the PHProfiler UI}
```

## Usage

### Register the Bundle
If your Symfony version does not support Flex or auto-discovery, you need to register the bundle manually in config/bundles.php:
```php
return [
    // Other bundles...

    PHProfiler\SymfonyPHProfilerBundle\PHProfilerBundle::class => ['all' => true],
];
```

### Publishing Configuration
To publish the configuration file, run the following command:
```bash
php bin/console config:dump-reference PHProfilerBundle
```

### Profiling Data Capture
The bundle automatically captures profiling data for each request and sends it asynchronously to the configured DSN.

## License
The Apache 2.0 License (Apache-2.0). Please see [License File](LICENSE) for more information.

## Contributing
Contributions are welcome! Please feel free to submit a Pull Request.

## Issues
If you encounter any issues, please create a new issue in the GitHub Issue Tracker.