<?php

namespace Municipio\Customizer\Sections\Module;

class Posts
{
    public function __construct(string $sectionID)
    {
        \Kirki::add_field(\Municipio\Customizer::KIRKI_CONFIG, [
          'type'        => 'select',
          'settings'    => 'mod_posts_index_modifier',
          'label'       => esc_html__('Index', 'municipio'),
          'section'     => $sectionID,
          'default'     => 'none',
          'priority'    => 10,
          'choices'     => [
            'none' => esc_html__('None', 'municipio'),
            'panel' => esc_html__('Panel', 'municipio'),
            'accented' => esc_html__('Accented', 'municipio'),
            'highlight' => esc_html__('Highlight', 'municipio'),
          ],
          'output' => [
              [
                'type' => 'modifier',
                'context' => ['module.posts.index']
              ]
          ],
        ]);

        \Kirki::add_field(\Municipio\Customizer::KIRKI_CONFIG, [
          'type'        => 'select',
          'settings'    => 'mod_posts_list_modifier',
          'label'       => esc_html__('List', 'municipio'),
          'section'     => $sectionID,
          'default'     => 'none',
          'priority'    => 10,
          'choices'     => [
            'none' => esc_html__('None', 'municipio'),
            'panel' => esc_html__('Panel', 'municipio'),
            'accented' => esc_html__('Accented', 'municipio'),
            'highlight' => esc_html__('Highlight', 'municipio'),
          ],
          'output' => [
              [
                'type' => 'modifier',
                'context' => ['module.posts.list']
              ]
          ],
        ]);

        \Kirki::add_field(\Municipio\Customizer::KIRKI_CONFIG, [
          'type'        => 'select',
          'settings'    => 'mod_posts_expandablelist_modifier',
          'label'       => esc_html__('Expandable List', 'municipio'),
          'section'     => $sectionID,
          'default'     => 'none',
          'priority'    => 10,
          'choices'     => [
            'none' => esc_html__('None', 'municipio'),
            'panel' => esc_html__('Panel', 'municipio'),
            'accented' => esc_html__('Accented', 'municipio'),
            'highlight' => esc_html__('Highlight', 'municipio'),
          ],
          'output' => [
              [
                'type' => 'modifier',
                'context' => ['module.posts.expandablelist']
              ]
          ],
        ]);

        \Kirki::add_field(\Municipio\Customizer::KIRKI_CONFIG, [
          'type'        => 'switch',
          'settings'    => 'mod_posts_display_post_icon',
          'label'       => esc_html__('Display term icon', 'municipio'),
          'description' => esc_html__('Display an icon on the post if the post has a term with an icon set', 'municipio'),
          'section'     => $sectionID,
          'default'     => 'off',
          'priority'    => 10,
          'choices'     => [
            'on' => __('On', 'municipio'),
            'off' => __('Off', 'municipio'),
          ],
          'output' => [
              [
                'type' => 'component_data',
                'dataKey' => 'displayIcon',
                'context' => [
                  'module.posts.index',
                  'module.posts.segment',
                  'module.posts.block',
                  'module.posts.collection__item'
                ]
              ],
          ],
        ]);
    }
}
