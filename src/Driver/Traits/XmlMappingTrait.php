<?php

/*
 * mapping (https://github.com/juliangut/mapping).
 * Mapping parsing base library.
 *
 * @license BSD-3-Clause
 * @link https://github.com/juliangut/mapping
 * @author Julián Gutiérrez <juliangut@gmail.com>
 */

declare(strict_types=1);

namespace Jgut\Mapping\Driver\Traits;

/**
 * XML file mapping trait.
 */
trait XmlMappingTrait
{
    /**
     * Truthly values.
     *
     * @var array
     */
    private static $truthlyValues = [
        'true',
        'on',
        'yes',
    ];

    /**
     * Falsy values.
     *
     * @var array
     */
    private static $falsyValues = [
        'false',
        'off',
        'no',
    ];

    /**
     * List of boolean values.
     *
     * @var array
     */
    private static $boolValues;

    /**
     * Get supported mapping file extensions.
     *
     * @return string[]
     */
    protected function getExtensions(): array
    {
        return ['xml'];
    }

    /**
     * Load mappings from file.
     *
     * @param string $mappingFile
     *
     * @throws \RuntimeException
     *
     * @return array
     */
    protected function loadMappingFile(string $mappingFile): array
    {
        $disableEntityLoader = libxml_disable_entity_loader(true);
        $useInternalErrors = libxml_use_internal_errors(true);

        $mappingData = simplexml_load_string(file_get_contents($mappingFile));

        libxml_use_internal_errors($useInternalErrors);
        libxml_disable_entity_loader($disableEntityLoader);

        if ($mappingData === false) {
            // @codeCoverageIgnoreStart
            $errors = array_map(
                function (\LibXMLError $error) {
                    return '"' . $error->message . '"';
                },
                libxml_get_errors()
            );
            // @codeCoverageIgnoreEnd

            libxml_clear_errors();

            throw new \RuntimeException(
                sprintf('XML mapping file %s parsing error: "%s"', $mappingFile, implode(',', $errors))
            );
        }

        if (self::$boolValues === null) {
            self::$boolValues = array_merge(static::$truthlyValues, static::$falsyValues);
        }

        return $this->parseSimpleXML($mappingData);
    }

    /**
     * Parse xml to array.
     *
     * @param \SimpleXMLElement $element
     *
     * @return mixed|mixed[]
     */
    final protected function parseSimpleXML(\SimpleXMLElement $element)
    {
        if ($element->count() === 0) {
            $value = (string) $element;

            if (in_array($value, self::$boolValues)) {
                return $this->getBooleanFromString($value);
            }

            if (is_numeric($value)) {
                $value = $this->getNumericFromString($value);
            }

            return $value;
        }

        $elements = [];

        foreach ($element->children() as $child) {
            if ($child instanceof \SimpleXMLElement) {
                $elements[$child->getName()] = $this->parseSimpleXML($child);
            } else {
                $elements[] = $child;
            }
        }

        return $elements;
    }

    /**
     * Get boolean value from string.
     *
     * @param string $value
     *
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     *
     * @return bool
     */
    private function getBooleanFromString(string $value): bool
    {
        if (in_array($value, static::$truthlyValues)) {
            return true;
        }

        return false;
    }

    /**
     * Get numeric value from string.
     *
     * @param string $value
     *
     * @return float|int
     */
    private function getNumericFromString(string $value)
    {
        if (strpos($value, '.') !== false) {
            return (float) $value;
        }

        return (int) $value;
    }
}
