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

        return $this->simpleXML2Array($mappingData);
    }

    /**
     * Get array from SimpleXMLElement.
     *
     * @param \SimpleXMLElement $xml
     *
     * @return array
     */
    final protected function simpleXML2Array(\SimpleXMLElement $xml): array
    {
        $array = [];

        foreach ($xml as $element) {
            /* @var \SimpleXMLElement $element */
            $elementName = $element->getName();
            $elementVars = get_object_vars($element);

            if (!empty($elementVars)) {
                $array[$elementName] = $element instanceof \SimpleXMLElement
                    ? $this->simpleXML2Array($element)
                    : $elementVars;
            } else {
                $array[$elementName] = trim((string) $element);
            }
        }

        return $array;
    }
}
