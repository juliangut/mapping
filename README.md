[![PHP version](https://img.shields.io/badge/PHP-%3E%3D7-8892BF.svg?style=flat-square)](http://php.net)
[![Latest Version](https://img.shields.io/packagist/v/juliangut/mapping.svg?style=flat-square)](https://packagist.org/packages/juliangut/mapping)
[![License](https://img.shields.io/github/license/juliangut/mapping.svg?style=flat-square)](https://github.com/juliangut/mapping/blob/master/LICENSE)

[![Build Status](https://img.shields.io/travis/juliangut/mapping.svg?style=flat-square)](https://travis-ci.org/juliangut/mapping)
[![Style Check](https://styleci.io/repos/107862050/shield)](https://styleci.io/repos/107862050)
[![Code Quality](https://img.shields.io/scrutinizer/g/juliangut/mapping.svg?style=flat-square)](https://scrutinizer-ci.com/g/juliangut/mapping)
[![Code Coverage](https://img.shields.io/coveralls/juliangut/mapping.svg?style=flat-square)](https://coveralls.io/github/juliangut/mapping)

[![Total Downloads](https://img.shields.io/packagist/dt/juliangut/mapping.svg?style=flat-square)](https://packagist.org/packages/juliangut/mapping/stats)
[![Monthly Downloads](https://img.shields.io/packagist/dm/juliangut/mapping.svg?style=flat-square)](https://packagist.org/packages/juliangut/mapping/stats)

# Mapping

Mapping parsing base library for any kind of project or library.

This library frees you from the most tedious part of mapping parsing by providing a set of functionalities to easily load mappings either from Doctrine annotations or files of different formats (PHP, JSON, XML, YAML), so you can focus on the actual parsing of mappings into metadata you can use onwards.

## Installation

### Composer

```
composer require juliangut/mapping
```

To use mappings in class annotations

```
composer require doctrine/annotations
```

To use yaml files mappings

```
composer require symfony/yaml
```

## Usage

Require composer autoload file

```php
require './vendor/autoload.php';
```

### Drivers

Should retrieve parsed metadata stored in a specific format 

#### Annotation mapping

```php
use Doctrine\Common\Annotations\AnnotationReader;
use Jgut\Mapping\Driver\AbstractAnnotationDriver;

class AnnotationDriver extends AbstractAnnotationDriver
{
    /**
     * @return \Jgut\Mapping\Metadata\MetadataInterface[]
     */
    public function getMetadata(): array
    {
        $mappingClasses = $this->getMappingClasses();

        // Annotation reader available on $this->annotationReader

        // Return your parsed metadata
    }
}

$driver = new AnnotationDriver(['path/to/classes'], new AnnotationReader());

$driver->getMetadata();
```

#### File mapping

Any kind of format that can be returned on an array can be used

```php
use Jgut\Mapping\Driver\AbstractMappingDriver;
use Jgut\Mapping\Driver\Traits\PhpMappingTrait;
use Jgut\Mapping\Driver\DriverInterface;

class PhpDriver extends AbstractMappingDriver
{
    use PhpMappingTrait;

    /**
     * @return \Jgut\Mapping\Metadata\MetadataInterface[]
     */
    public function getMetadata(): array
    {
        $mappingData = $this->getMappingData();

        // Return your parsed metadata
    }
}

$driver = new MappingDriver(['path/to/classes'], DriverInterface::DRIVER_PHP);

$driver->getMetadata();
```

There are mapping traits to easily support four types of mapping files:

* DriverInterface::DRIVER_PHP => Jgut\Mapping\Driver\Traits\PhpMappingTrait
* DriverInterface::DRIVER_JSON => Jgut\Mapping\Driver\Traits\JsonMappingTrait
* DriverInterface::DRIVER_XML => Jgut\Mapping\Driver\Traits\XmlMappingTrait
* DriverInterface::DRIVER_YAML => Jgut\Mapping\Driver\Traits\YamlMappingTrait

#### Factory

Driver factory allows to automatically get a mapping driver given 

```php
use Jgut\Mapping\Driver\AbstractDriverFactory;
use Jgut\Mapping\Driver\DriverFactoryInterface;
use Jgut\Mapping\Driver\DriverInterface;

class DriverFactory extends AbstractDriverFactory
{
    protected function getAnnotationDriver(array $paths): DriverInterface
    {
        return new AnnotationDriver($paths);
    }

    protected function getPhpDriver(array $paths): DriverInterface
    {
        return new PhpDriver($paths);
    }

    // ...
}
```

### Resolver

Given mapping source definitions will resolve metadata from drivers

```php
use Jgut\Mapping\Metadata\MetadataResolver;

$mappingSources = [
    [
        'type' => DriverFactoryInterface::DRIVER_ANNOTATION,
        'path' => '/path/to/mapping/files',
    ]
];

$metadataResolver = new MetadataResolver(new DriverFactory());

$metadata = $metadataResolver->getMetadata($mappingSources);
```

#### Mapping source

* `type` one of \Jgut\Mapping\Driver\DriverFactoryInterface constants: `DRIVER_ANNOTATION`, `DRIVER_PHP`, `DRIVER_JSON`, `DRIVER_XML` or `DRIVER_YAML` **defaults to DRIVER_ANNOTATION if no driver**
* `path` a string path or array of paths to where mapping files are located (files or directories) **REQUIRED if no driver**
* `driver` an already created \Jgut\Mapping\Driver\DriverInterface object **REQUIRED if no type AND path**

### Annotations

Base AbstractAnnotation class is provided to ease annotations creation.

```php
use Jgut\Mapping\Annotation\AbstractAnnotation;

/**
 * Custom annotation.
 *
 * @Annotation
 * @Target("PROPERTY")
 */
class Custom extends AbstractAnnotation
{
}
```

## Example

If you want to see a full implementation example of this library head to [juliangu/slim-routing](https://github.com/juliangut/slim-routing)

## Contributing

Found a bug or have a feature request? [Please open a new issue](https://github.com/juliangut/mapping/issues). Have a look at existing issues before.

See file [CONTRIBUTING.md](https://github.com/juliangut/mapping/blob/master/CONTRIBUTING.md)

## License

See file [LICENSE](https://github.com/juliangut/mapping/blob/master/LICENSE) included with the source code for a copy of the license terms.
