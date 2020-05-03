<img src="https://github.com/GetOlympus/olympus-dionysos-field-header/blob/master/assets/field-header.png" align="left" />

# Dionysos Header Field

[![Olympus Component][olympus-image]][olympus-url]
[![CodeFactor Grade][codefactor-image]][codefactor-url]
[![Packagist Version][packagist-image]][packagist-url]
[![MIT][license-image]][license-blob]

> This component is a part of the **Olympus Dionysos fields** for **WordPress**.

```sh
composer require getolympus/olympus-dionysos-field-header
```

---

## Table of contents

[Field initialization](#field-initialization) • [Variables definitions](#variables-definitions) • [Texts definition](#texts-definition) • [Accepted modes](#accepted-modes) • [Retrive data](#retrive-data) • [Release history](#release-history) • [Contributing](#contributing)

---

## Field initialization

Use the following lines to add a `header field` in your **WordPress** admin pages or custom post type meta fields:

```php
return \GetOlympus\Dionysos\Field\Header::build('my_header_field_id', [
    'title'       => 'You\'re about to find out what it\'s like to fight a real Super Saiyan...',
    'default'     => [],
    'description' => 'and I\'m not talking about Goku!',
    'mode'        => 'top',

    /**
     * Texts definition
     * @see the `Texts definition` section below
     */
    't_align_left'        => 'Left',
    't_align_center'      => 'Center',
    't_align_right'       => 'Right',
    't_align_expand'      => 'Expand',

    't_header_overall'    => 'Overall header',
    't_header_main'       => 'Main header',
    't_header_secondary'  => 'Secondary header',

    't_logo_no_display'   => 'Hide website\'s baseline',
    't_logo_display'      => 'Display website\'s baseline',

    't_navs_label'        => 'Navigation menus',

    't_search_label'      => 'Search displays',
    't_search_default'    => 'Default',
    't_search_drop'       => 'Drop',
    't_search_dropdown'   => 'Dropdown',
    't_search_modal'      => 'Modal',
    't_search_overlay'    => 'Overlay',

    't_text_default'      => 'Call us today! 1.555.555.555',

    't_type_label'        => 'Choose a content type',
    't_type_logo'         => 'Website\'s logo',
    't_type_nav'          => 'Navigation menu',
    't_type_search'       => 'Search form',
    't_type_text'         => 'Custom text field',

    't_addblock_label'    => 'Click on the button to add content',
    't_editblock_label'   => 'Click on the button to edit content',
    't_removeblock_label' => 'Remove',
    't_updateblock_label' => 'Update',
]);
```

## Variables definitions

| Variable      | Type    | Default value if not set | Accepted values |
| :------------ | :------ | :----------------------- | :-------------- |
| `title`       | String  | `'Header'` | *empty* |
| `default`     | Array   | *empty* | *empty* |
| `description` | String  | *empty* | *empty* |
| `mode`        | String  | `top` | see [Accepted modes](#accepted-modes) |

## Texts definition

| Code | Default value | Definition |
| :--- | :------------ | :--------- |
| `t_align_left` | Left | Left align option |
| `t_align_center` | Center | Center align option |
| `t_align_right` | Right | Right align option |
| `t_align_expand` | Expand | Expand align option |
| `t_header_overall` | Overall header | Overall header's title |
| `t_header_main` | Main header | Main header's title |
| `t_header_secondary` | Secondary header | Secondary header's title |
| `t_logo_no_display` | Hide website's baseline | Hide slogan option |
| `t_logo_display` | Display website's baseline | Display slogan option |
| `t_navs_label` | Navigation menus | Navs' selectbox title |
| `t_search_label` | Search displays | Searchs' selectbox title |
| `t_search_default` | Default | Default search option |
| `t_search_drop` | Drop | Drop search option |
| `t_search_dropdown` | Dropdown | Dropdown search option |
| `t_search_modal` | Modal | Modal search option |
| `t_search_overlay` | Overlay | Overlay search option |
| `t_text_default` | Call us today! 1.555.555.555 | Default custom text field value |
| `t_type_label` | Choose a content type | Types' selectbox title |
| `t_type_logo` | Website's logo | Logo type option |
| `t_type_nav` | Navigation menu | Nav type option |
| `t_type_search` | Search form | Search type option |
| `t_type_text` | Custom text field | Text type option |
| `t_addblock_label` | Click on the button to add content | Add button label |
| `t_editblock_label` | Click on the button to edit content | Edit button label |
| `t_removeblock_label` | Remove | Remove button label |
| `t_updateblock_label` | Update | Update button label |

## Accepted modes

* `top` to display headers as default display
* `left` to display headers as left side nav
* `right` to display headers as right side nav

## Retrive data

Retrieve your value from Database with a simple `get_option('my_header_field_id', [])` (see [WordPress reference][getoption-url]):

```php
// Get headers from Database
$headers = get_option('my_header_field_id', []);

if (!empty($headers)) {
    echo '<header>';

    foreach ($headers as $name => $options) {
        echo '<nav class="nav '.$name.'">';
        echo '<ul>';

        foreach ($options['contents'] as $content) {
            # code...
            echo '<li>'.$content[0].': '.$content[1].'</li>';
        }

        echo '</ul>';
        echo '</nav>';
    }

    echo '</header>';
}
```

## Release history

| Version | Note |
| :------ | :--- |
| 0.0.2   | Update CSS and languages |
| 0.0.1   | Initial commit |

## Contributing

1. Fork it (<https://github.com/GetOlympus/olympus-dionysos-field-header/fork>)
2. Create your feature branch (`git checkout -b feature/fooBar`)
3. Commit your changes (`git commit -am 'Add some fooBar'`)
4. Push to the branch (`git push origin feature/fooBar`)
5. Create a new Pull Request

---

**Built with ♥ by [Achraf Chouk](https://github.com/crewstyle "Achraf Chouk") ~ (c) since a long time.**

<!-- links & imgs dfn's -->
[olympus-image]: https://img.shields.io/badge/for-Olympus-44cc11.svg?style=flat-square
[olympus-url]: https://github.com/GetOlympus
[codefactor-image]: https://www.codefactor.io/repository/github/GetOlympus/olympus-dionysos-field-header/badge?style=flat-square
[codefactor-url]: https://www.codefactor.io/repository/github/getolympus/olympus-dionysos-field-header
[getoption-url]: https://developer.wordpress.org/reference/functions/get_option/
[license-blob]: https://github.com/GetOlympus/olympus-dionysos-field-header/blob/master/LICENSE
[license-image]: https://img.shields.io/badge/license-MIT_License-blue.svg?style=flat-square
[packagist-image]: https://img.shields.io/packagist/v/getolympus/olympus-dionysos-field-header.svg?style=flat-square
[packagist-url]: https://packagist.org/packages/getolympus/olympus-dionysos-field-header
