<?php

namespace Municipio\PostTypeDesign;

/**
 * Class ConfigSanitizer
 *
 * This class is responsible for sanitizing the configuration data for a post type design.
 */
class ConfigSanitizer
{
    /**
     * ConfigSanitizer constructor.
     *
     * @param array|null $config The configuration data to be sanitized.
     * @param array $keys The keys to be used for sanitization.
     */
    public function __construct(private ?array $config, private array $keys = [])
    {
    }

    /**
     * Transforms the configuration array by filtering out keys that are not present in the specified keys array.
     * If the configuration array or the keys array is empty, it returns an empty array.
     *
     * @return array The transformed configuration array.
     */
    public function transform(): array
    {
        if (empty($this->config) || empty($this->keys)) {
            return $this->config ?? [];
        }

        foreach ($this->config as $key => $value) {
            if (!in_array($key, $this->keys)) {
                unset($this->config[$key]);
            }
        }

        $this->config = array_merge(array_fill_keys($this->keys, null), $this->config);

        return $this->config;
    }
}
