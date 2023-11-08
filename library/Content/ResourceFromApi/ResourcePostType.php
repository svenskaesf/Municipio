<?php

namespace Municipio\Content\ResourceFromApi;

use Municipio\Helper\RestRequestHelper;

class ResourcePostType
{

    public function addHooks(): void
    {
        add_action('init', [$this, 'addPostType']);
        add_action('init', [$this, 'addOptionsPage']);
        add_filter('acf/load_field/name=post_type_source', [$this, 'loadPostTypeSourceOptions']);
        add_filter('acf/load_field/name=taxonomy_source', [$this, 'loadTaxonomySourceOptions']);
        add_action('acf/save_post', [$this, 'setPostTypeResourcePostTitleFromAcf'], 10);
        add_action('acf/save_post', [$this, 'setTaxonomyResourcePostTitleFromAcf'], 10);
        add_action('acf/save_post', [$this, 'setPostTypeApiMeta'], 10);
        add_filter('acf/update_value/name=post_type_key', [$this, 'sanitizePostTypeKeyBeforeSave'], 10, 4);
        add_filter('acf/update_value/name=taxonomy_key', [$this, 'sanitizeTaxonomyKeyBeforeSave'], 10, 4);
    }

    public function addPostType()
    {
        register_post_type(
            'api-resource',
            [
                'label' => __('API Resources', 'municipio'),
                'labels' => [
                    'singular_name' => __('API Resource', 'municipio'),
                ],
                'show_ui' => true,
                'public' => false,
                'has_archive' => false,
                'show_in_rest' => false,
                'supports' => false,
                'taxonomies' => [],
            ]
        );
    }

    public function addOptionsPage()
    {
        if (function_exists('acf_add_options_page')) {
            acf_add_options_page(array(
                'page_title'    => 'Api:s',
                'menu_title'    => 'Api:s',
                'menu_slug'     => 'api-resource-apis',
                'capability'    => 'manage_options',
                'redirect'       => false,
                'parent_slug' => 'edit.php?post_type=api-resource',
            ));
        }
    }

    public function loadPostTypeSourceOptions($field)
    {

        $choices = [];

        if (!function_exists('get_field')) {
            return $field;
        }

        $endpoints = get_field('api_resources_apis', 'options');

        if (!is_array($endpoints) || empty($endpoints)) {
            return $field;
        }

        $urls = array_map(fn ($row) => $row['url'], $endpoints);
        $urls = array_filter($urls, fn ($url) => filter_var($url, FILTER_VALIDATE_URL) !== false);

        if (empty($urls)) {
            return $field;
        }

        foreach ($urls as $url) {

            $typesFromApi = RestRequestHelper::getFromApi(trailingslashit($url) . 'types');

            if (is_wp_error($typesFromApi) || empty($typesFromApi)) {
                return null;
            }

            foreach ($typesFromApi as $type) {
                if (
                    !isset($type->slug) ||
                    !isset($type->_links) ||
                    !isset($type->_links->collection) ||
                    empty($type->_links->collection) ||
                    !isset($type->_links->collection[0]->href) ||
                    !filter_var($type->_links->collection[0]->href, FILTER_VALIDATE_URL)
                ) {
                    continue;
                }

                $value = trailingslashit($url) . ",{$type->slug}" . ",{$type->rest_base}";
                $labelParenthesis = trailingslashit($url) . $type->rest_base;
                $label = "{$type->slug}: {$labelParenthesis}";
            }
        }

        if (!empty($choices)) {
            $field['choices'] = $choices;
        }

        return $field;
    }

    public function loadTaxonomySourceOptions($field)
    {

        $choices = [];

        if (!function_exists('get_field')) {
            return $field;
        }

        $endpoints = get_field('api_resources_apis', 'options');

        if (!is_array($endpoints) || empty($endpoints)) {
            return $field;
        }

        $urls = array_map(fn ($row) => $row['url'], $endpoints);
        $urls = array_filter($urls, fn ($url) => filter_var($url, FILTER_VALIDATE_URL) !== false);

        if (empty($urls)) {
            return $field;
        }

        foreach ($urls as $url) {

            $typesFromApi = RestRequestHelper::getFromApi(trailingslashit($url) . 'taxonomies');

            if (is_wp_error($typesFromApi) || empty($typesFromApi)) {
                return null;
            }

            foreach ($typesFromApi as $type) {
                if (
                    !isset($type->slug) ||
                    !isset($type->_links) ||
                    !isset($type->_links->collection) ||
                    empty($type->_links->collection) ||
                    !isset($type->_links->collection[0]->href) ||
                    !filter_var($type->_links->collection[0]->href, FILTER_VALIDATE_URL)
                ) {
                    continue;
                }

                $value = trailingslashit($url) . ",{$type->slug}" . ",{$type->rest_base}";
                $labelParenthesis = trailingslashit($url) . $type->rest_base;
                $label = "{$type->slug}: {$labelParenthesis}";
                $choices[$value] = $label;
            }
        }

        if (!empty($choices)) {
            $field['choices'] = $choices;
        }

        return $field;
    }

    public function setPostTypeResourcePostTitleFromAcf($postId)
    {
        $postTypeArguments = get_field('post_type_arguments', $postId);

        if (
            empty($postTypeArguments) ||
            !isset($postTypeArguments['post_type_key']) ||
            empty($postTypeArguments['post_type_key'])
        ) {
            return;
        }

        $postTypeName = $postTypeArguments['post_type_key'];
        $postTypeName = sanitize_title(substr($postTypeName, 0, 19));

        wp_update_post([
            'ID' => $postId,
            'post_title' => $postTypeName,
            'post_name' => $postTypeName,

        ]);
    }
    
    public function setTaxonomyResourcePostTitleFromAcf($postId)
    {
        $taxonomyArguments = get_field('taxonomy_arguments', $postId);

        if (
            empty($taxonomyArguments) ||
            !isset($taxonomyArguments['taxonomy_key']) ||
            empty($taxonomyArguments['taxonomy_key'])
        ) {
            return;
        }

        $taxonomyName = $taxonomyArguments['taxonomy_key'];
        $taxonomyName = sanitize_title(substr($taxonomyName, 0, 31));

        wp_update_post([
            'ID' => $postId,
            'post_title' => $taxonomyName,
            'post_name' => $taxonomyName,

        ]);
    }

    public function setPostTypeApiMeta($postId) {
        if( !is_string(get_post_type($postId)) || get_post_type($postId) !== 'api-resource' || !function_exists('get_field') ) {
            return;
        }

        $postTypeSource = get_field('post_type_source', $postId);
        
        if( !is_string($postTypeSource) || empty($postTypeSource) ) {
            return;
        }

        $parts = explode(',', $postTypeSource);
        
        if( sizeof($parts) !== 3 ) {
            return;
        }

        $url = $parts[0];
        $originalName = $parts[1];
        $baseName = $parts[2];

        update_post_meta($postId, 'api_resource_url', $url);
        update_post_meta($postId, 'api_resource_original_name', $originalName);
        update_post_meta($postId, 'api_resource_base_name', $baseName);
    }

    public function sanitizePostTypeKeyBeforeSave($value, $postId, $field, $originalValue)
    {
        return sanitize_title(substr($value, 0, 19));
    }
    
    public function sanitizeTaxonomyKeyBeforeSave($value, $postId, $field, $originalValue)
    {
        return sanitize_title(substr($value, 0, 31));
    }
}
