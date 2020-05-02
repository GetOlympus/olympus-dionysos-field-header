<?php

namespace GetOlympus\Dionysos\Field;

use GetOlympus\Zeus\Field\Field;

/**
 * Builds Header field.
 *
 * @package    DionysosField
 * @subpackage Header
 * @author     Achraf Chouk <achrafchouk@gmail.com>
 * @since      0.0.1
 *
 */

class Header extends Field
{
    /**
     * @var array
     */
    protected $adminscripts = ['wp-util'];

    /**
     * @var string
     */
    protected $script = 'js'.S.'header.js';

    /**
     * @var string
     */
    protected $style = 'css'.S.'header.css';

    /**
     * @var string
     */
    protected $template = 'header.html.twig';

    /**
     * @var string
     */
    protected $textdomain = 'headerfield';

    /**
     * Prepare defaults.
     *
     * @return array
     */
    protected function getDefaults() : array
    {
        return [
            'title'       => parent::t('header.title', $this->textdomain),
            'default'     => [],
            'description' => '',
            'mode'        => 'top',

            // settings
            'settings'    => [
                'align'      => [],
                'background' => [],
                'contents'   => [],
                'padding'    => [],
            ],

            // texts
            't_align_left'        => parent::t('header.align_left', $this->textdomain),
            't_align_center'      => parent::t('header.align_center', $this->textdomain),
            't_align_right'       => parent::t('header.align_right', $this->textdomain),
            't_align_expand'      => parent::t('header.align_expand', $this->textdomain),

            't_header_overall'    => parent::t('header.header_overall', $this->textdomain),
            't_header_main'       => parent::t('header.header_main', $this->textdomain),
            't_header_secondary'  => parent::t('header.header_secondary', $this->textdomain),

            't_logo_no_display'   => parent::t('header.logo_no_display', $this->textdomain),
            't_logo_display'      => parent::t('header.logo_display', $this->textdomain),

            't_navs_label'        => parent::t('header.navs_label', $this->textdomain),

            't_search_label'      => parent::t('header.search_label', $this->textdomain),
            't_search_default'    => parent::t('header.search_default', $this->textdomain),
            't_search_drop'       => parent::t('header.search_drop', $this->textdomain),
            't_search_dropdown'   => parent::t('header.search_dropdown', $this->textdomain),
            't_search_modal'      => parent::t('header.search_modal', $this->textdomain),
            't_search_overlay'    => parent::t('header.search_overlay', $this->textdomain),

            't_text_default'      => parent::t('header.text_default', $this->textdomain),

            't_type_label'        => parent::t('header.type_label', $this->textdomain),
            't_type_logo'         => parent::t('header.type_logo', $this->textdomain),
            't_type_nav'          => parent::t('header.type_nav', $this->textdomain),
            't_type_search'       => parent::t('header.type_search', $this->textdomain),
            't_type_text'         => parent::t('header.type_text', $this->textdomain),

            't_addblock_label'    => parent::t('header.addblock_label', $this->textdomain),
            't_editblock_label'   => parent::t('header.editblock_label', $this->textdomain),
            't_removeblock_label' => parent::t('header.removeblock_label', $this->textdomain),
            't_updateblock_label' => parent::t('header.updateblock_label', $this->textdomain),
        ];
    }

    /**
     * Prepare variables.
     *
     * @param  object  $value
     * @param  array   $contents
     *
     * @return array
     */
    protected function getVars($value, $contents) : array
    {
        // Available modes
        $modes = ['top', 'left', 'right'];

        // Get contents
        $vars = $contents;

        // Retrieve field value
        $vars['value'] = !is_array($value) ? [$value] : $value;

        // Build mode
        $vars['mode'] = in_array($vars['mode'], $modes) ? $vars['mode'] : $modes[0];

        // Build settings
        $vars['settings'] = $this->buildDefaultSettings($vars['settings'], $vars);

        // Build contents
        $vars['logos']   = $this->buildLogos($vars);
        $vars['navs']    = $this->buildNavs($vars);
        $vars['searchs'] = $this->buildSearchs($vars);
        $vars['types']   = $this->buildTypes($vars);

        // Build headers from values
        $vars['headers'] = $this->buildHeaders($vars['value'], $vars);

        // Update vars
        return $vars;
    }

    /**
     * Build settings.
     *
     * @param  array   $settings
     * @param  array   $vars
     *
     * @return array
     */
    protected function buildDefaultSettings($settings, $vars) : array
    {
        // Build align
        $settings['align'] = array_merge([
            'left'   => $vars['t_align_left'],
            'center' => $vars['t_align_center'],
            'right'  => $vars['t_align_right'],
            'expand' => $vars['t_align_expand'],
        ], $settings['align']);

        // Build background
        $settings['background'] = empty($settings['background']) ? 'transparent' : $settings['background'];

        // Build padding
        $settings['padding'] = empty($settings['padding']) ? '15px' : $settings['padding'];

        return $settings;
    }

    /**
     * Build headers.
     *
     * @param  array   $values
     * @param  array   $vars
     *
     * @return array
     */
    protected function buildHeaders($values, $vars) : array
    {
        // Initialize overall header
        $overall   = isset($values['overall']) ? $values['overall'] : [
            'active'     => true,
            'align'      => 'left',
            'background' => '#fbfbfb',
            'contents'   => [],
            'padding'    => '5px',
        ];

        // Initialize main header
        $main      = isset($values['main']) ? $values['main'] : [
            'active'     => true,
            'align'      => 'left',
            'background' => 'transparent',
            'contents'   => [],
            'padding'    => '15px',
        ];

        // Initialize secondary header
        $secondary = isset($values['secondary']) ? $values['secondary'] : [
            'active'     => false,
            'align'      => 'center',
            'background' => 'transparent',
            'contents'   => [],
            'padding'    => '10px',
        ];

        return [
            'overall'   => $overall,
            'main'      => $main,
            'secondary' => $secondary,
        ];
    }

    /**
     * Build logos.
     *
     * @param  array   $vars
     *
     * @return array
     */
    protected function buildLogos($vars) : array
    {
        return [
            ''  => $vars['t_logo_no_display'],
            '1' => $vars['t_logo_display'],
        ];
    }

    /**
     * Build navs.
     *
     * @param  array   $vars
     *
     * @return array
     */
    protected function buildNavs($vars) : array
    {
        $navs = wp_get_nav_menus();
        $arr  = [
            '' => $vars['t_navs_label'],
        ];

        foreach ($navs as $nav) {
            $arr[$nav->term_id] = $nav->name;
        }

        return $arr;
    }

    /**
     * Build searchs.
     *
     * @param  array   $vars
     *
     * @return array
     */
    protected function buildSearchs($vars) : array
    {
        return [
            ''         => $vars['t_search_label'],
            'default'  => $vars['t_search_default'],
            'drop'     => $vars['t_search_drop'],
            'dropdown' => $vars['t_search_dropdown'],
            'modal'    => $vars['t_search_modal'],
            'overlay'  => $vars['t_search_overlay'],
        ];
    }

    /**
     * Build types.
     *
     * @param  array   $vars
     *
     * @return array
     */
    protected function buildTypes($vars) : array
    {
        return [
            ''       => $vars['t_type_label'],
            'logo'   => $vars['t_type_logo'],
            'nav'    => $vars['t_type_nav'],
            'search' => $vars['t_type_search'],
            'text'   => $vars['t_type_text'],
        ];
    }
}
