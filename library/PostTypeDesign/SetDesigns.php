<?php

namespace Municipio\PostTypeDesign;

use WpService\Contracts\AddFilter;
use WpService\Contracts\GetOption;
use WpService\Contracts\GetPostType;

/**
 * Class SetDesigns
 *
 * This class represents a set of designs for a specific post type.
 */
class SetDesigns
{
    /**
     * Class SetDesigns
     *
     * Represents a class that sets the designs for a post type.
     */
    public function __construct(private string $optionName, private AddFilter&GetPostType&GetOption $wpService)
    {
        $this->addHooks();
    }

    /**
     * Adds hooks for setting designs.
     *
     * This method adds hooks to modify the theme mods and custom CSS for setting designs.
     *
     * @return void
     */
    public function addHooks()
    {
        $this->wpService->addFilter("option_theme_mods_municipio", array($this, 'setDesign'), 10, 2);
        $this->wpService->addFilter('wp_get_custom_css', array($this, 'setCss'), 10, 2);
    }

    /**
     * Sets the CSS for a specific post type design.
     *
     * @param string $css The CSS to be set.
     * @param string $stylesheet The name of the stylesheet.
     * @return string The updated CSS for the post type design.
     */
    public function setCss(string $css, string $stylesheet): string
    {
        $postType = $this->wpService->getPostType();

        if (empty($postType) || empty($this->wpService->getOption('post_type_design')[$postType]['css'])) {
            return $css;
        }

        return $this->wpService->getOption('post_type_design')[$postType]['css'];
    }

    /**
     * Sets the design for a given value and option.
     *
     * @param mixed $value The value to set the design for.
     * @param string $option The option to set the design for.
     * @return mixed The modified value with the design applied.
     */
    public function setDesign(mixed $value, string $option): mixed
    {
        $postType = $this->wpService->getPostType();

        if (empty($postType) || empty($this->wpService->getOption('post_type_design')[$postType]['design'])) {
            return $value;
        }

        $design = $this->wpService->getOption('post_type_design')[$postType]['design'];
        $value  = array_replace($value, (array) $design);

        return $value;
    }
}
