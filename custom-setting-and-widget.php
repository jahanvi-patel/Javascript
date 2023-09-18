<?php

/**
 * Plugin Name: WP Settings and widget Page
 * Description: A simple call to action widget.
 * Version: 1.0
 * Author: Jahanvi 
 */
?><?php
    class executive_widget extends WP_Widget
    {

        function __construct()
        {
            parent::__construct(
                'executive_widget',
                __('Executive Widget', 'executive_widget_domain'),
                array('description' => __('Call to action for executive search', 'executive_widget_domain'),),
            );
        }

        public function widget($args, $instance)
        {
            $title = apply_filters('widget_title', $instance['title']);
            $text_two = apply_filters('widget_title', $instance['text_two']);
            $link_text = apply_filters('widget_text_two', $instance['link_text']);
            $gender = empty($instance['gender']) ? '' : $instance['gender'];

            echo $args['before_widget'];
            echo '<div class="widget-wrapper">';
            if (!empty($title))
                echo $args['before_title'] . $title . $args['after_title'];
            if (!empty($text_two))
                echo '<p>' . $text_two . '</p>';
            if (!empty($link_text))
                echo '<p><a href="/employers/executives">' . $link_text . '</a><i class="fa fa-play"></i></p>';
            if (!empty($gender))
                echo $gender;
            echo '</div>';
            echo $args['after_widget'];
        }

        // Widget Backend
        public function form($instance)
        {
            if (isset($instance['title'])) {
                $title = $instance['title'];
            } else {
                $title = __('Executive Search1', 'executive_widget_domain');
            }

            if (isset($instance['text_two'])) {
                $text_two = $instance['text_two'];
            } else {
                $text_two = __('Systematic searching to map the right talent for Director level roles using the best possible sector intelligence.', 'executive_widget_domain');
            }

            if (isset($instance['link_text'])) {
                $link_text = $instance['link_text'];
            } else {
                $link_text = __('Visit Executive Search', 'executive_widget_domain');
            }
            $gender = $instance['gender'];
            // Widget admin form
    ?>
<p>
    <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
    <input required class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
    <br /><br />
    <label for="<?php echo $this->get_field_id('text_two'); ?>"><?php _e('Main text:'); ?></label>
    <input required class="widefat" id="<?php echo $this->get_field_id('text_two'); ?>" name="<?php echo $this->get_field_name('text_two'); ?>" type="text" value="<?php echo esc_attr($text_two); ?>" />
    <br /><br />
    <label for="<?php echo $this->get_field_id('link_text'); ?>"><?php _e('Link text'); ?></label>
    <input required class="widefat" id="<?php echo $this->get_field_id('link_text'); ?>" name="<?php echo $this->get_field_name('link_text'); ?>" type="text" value="<?php echo esc_attr($link_text); ?>" />
</p>
<p>
    <label for="<?php echo $this->get_field_id('text'); ?>">gender:
        <select class='widefat' id="<?php echo $this->get_field_id('gender'); ?>" name="<?php echo $this->get_field_name('gender'); ?>" type="text">
            <option value='Female' <?php echo ($gender == 'Female') ? 'selected' : ''; ?>>
                Female
            </option>
            <option value='Male' <?php echo ($gender == 'Male') ? 'selected' : ''; ?>>
                Male
            </option>
            <option value='Other' <?php echo ($gender == 'Other') ? 'selected' : ''; ?>>
                Other
            </option>
        </select>
    </label>
</p>
<?php
        }

        // Updating widget replacing old instances with new
        public function update($new_instance, $old_instance)
        {
            $instance = array();
            $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
            $instance['text_two'] = (!empty($new_instance['text_two'])) ? strip_tags($new_instance['text_two']) : '';
            $instance['link_text'] = (!empty($new_instance['link_text'])) ? strip_tags($new_instance['link_text']) : '';
            $instance['gender'] = (!empty($new_instance['gender'])) ? strip_tags($new_instance['gender']) : '';
            return $instance;
        }
    }

    function executive_load_widget()
    {
        register_widget('executive_widget');
    }
    add_action('widgets_init', 'executive_load_widget');

    class Smashing_Fields_Plugin
    {

        public function __construct()
        {
            // Hook into the admin menu
            add_action('admin_menu', array($this, 'create_plugin_settings_page'));

            // Add Settings and Fields
            add_action('admin_init', array($this, 'setup_sections'));
            add_action('admin_init', array($this, 'setup_fields'));
        }

        public function create_plugin_settings_page()
        {
            // Add the menu item and page
            $page_title = 'My Awesome Settings Page';
            $menu_title = 'Awesome Plugin';
            $capability = 'manage_options';
            $slug = 'smashing_fields';
            $callback = array($this, 'plugin_settings_page_content');
            $icon = 'dashicons-admin-plugins';
            $position = 100;

            add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
        }

        public function plugin_settings_page_content()
        { ?>
    <div class="wrap">
        <h2>My Awesome Settings Page</h2><?php
                                            if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
                                                $this->admin_notice();
                                            } ?>
        <form method="POST" action="options.php">
            <?php
            settings_fields('smashing_fields');
            do_settings_sections('smashing_fields');
            submit_button();
            ?>
        </form>
    </div> <?php
        }

        public function admin_notice()
        { ?>
    <div class="notice notice-success is-dismissible">
        <p>Your settings have been updated!</p>
    </div><?php
        }

        public function setup_sections()
        {
            add_settings_section('our_first_section', 'My First Section Title', array($this, 'section_callback'), 'smashing_fields');
            add_settings_section('our_second_section', 'My Second Section Title', array($this, 'section_callback'), 'smashing_fields');
            add_settings_section('our_third_section', 'My Third Section Title', array($this, 'section_callback'), 'smashing_fields');
        }

        public function section_callback($arguments)
        {
            switch ($arguments['id']) {
                case 'our_first_section':
                    echo 'This is the first description here!';
                    break;
                case 'our_second_section':
                    echo 'This one is number two';
                    break;
                case 'our_third_section':
                    echo 'Third time is the charm!';
                    break;
            }
        }

        public function setup_fields()
        {
            $fields = array(
                array(
                    'uid' => 'awesome_text_field',
                    'label' => 'Sample Text Field',
                    'section' => 'our_first_section',
                    'type' => 'text',
                    'placeholder' => 'Some text',
                    'helper' => 'Does this help?',
                    'supplimental' => 'I am underneath!',
                ),
                array(
                    'uid' => 'awesome_password_field',
                    'label' => 'Sample Password Field',
                    'section' => 'our_first_section',
                    'type' => 'password',
                ),
                array(
                    'uid' => 'awesome_number_field',
                    'label' => 'Sample Number Field',
                    'section' => 'our_first_section',
                    'type' => 'number',
                ),
                array(
                    'uid' => 'awesome_textarea',
                    'label' => 'Sample Text Area',
                    'section' => 'our_first_section',
                    'type' => 'textarea',
                ),
                array(
                    'uid' => 'awesome_select',
                    'label' => 'Sample Select Dropdown',
                    'section' => 'our_first_section',
                    'type' => 'select',
                    'options' => array(
                        'option1' => 'Option 1',
                        'option2' => 'Option 2',
                        'option3' => 'Option 3',
                        'option4' => 'Option 4',
                        'option5' => 'Option 5',
                    ),
                    'default' => array()
                ),
                array(
                    'uid' => 'awesome_multiselect',
                    'label' => 'Sample Multi Select',
                    'section' => 'our_first_section',
                    'type' => 'multiselect',
                    'options' => array(
                        'option1' => 'Option 1',
                        'option2' => 'Option 2',
                        'option3' => 'Option 3',
                        'option4' => 'Option 4',
                        'option5' => 'Option 5',
                    ),
                    'default' => array()
                ),
                array(
                    'uid' => 'awesome_radio',
                    'label' => 'Sample Radio Buttons',
                    'section' => 'our_first_section',
                    'type' => 'radio',
                    'options' => array(
                        'option1' => 'Option 1',
                        'option2' => 'Option 2',
                        'option3' => 'Option 3',
                        'option4' => 'Option 4',
                        'option5' => 'Option 5',
                    ),
                    'default' => array()
                ),
                array(
                    'uid' => 'awesome_checkboxes',
                    'label' => 'Sample Checkboxes',
                    'section' => 'our_first_section',
                    'type' => 'checkbox',
                    'options' => array(
                        'option1' => 'Option 1',
                        'option2' => 'Option 2',
                        'option3' => 'Option 3',
                        'option4' => 'Option 4',
                        'option5' => 'Option 5',
                    ),
                    'default' => array()
                )
            );
            foreach ($fields as $field) {

                add_settings_field($field['uid'], $field['label'], array($this, 'field_callback'), 'smashing_fields', $field['section'], $field);
                register_setting('smashing_fields', $field['uid']);
            }
        }

        public function field_callback($arguments)
        {

            $value = get_option($arguments['uid']);

            if (!$value) {
                $value = $arguments['default'];
            }

            switch ($arguments['type']) {
                case 'text':
                case 'password':
                case 'number':
                    printf('<input required name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />', $arguments['uid'], $arguments['type'], $arguments['placeholder'], $value);
                    break;
                case 'textarea':
                    printf('<textarea name="%1$s" id="%1$s" placeholder="%2$s" rows="5" cols="50">%3$s</textarea>', $arguments['uid'], $arguments['placeholder'], $value);
                    break;
                case 'select':
                case 'multiselect':
                    if (!empty($arguments['options']) && is_array($arguments['options'])) {
                        $attributes = '';
                        $options_markup = '';
                        foreach ($arguments['options'] as $key => $label) {
                            $options_markup .= sprintf('<option value="%s" %s>%s</option>', $key, selected($value[array_search($key, $value, true)], $key, false), $label);
                        }
                        if ($arguments['type'] === 'multiselect') {
                            $attributes = ' multiple="multiple" ';
                        }
                        printf('<select name="%1$s[]" id="%1$s" %2$s>%3$s</select>', $arguments['uid'], $attributes, $options_markup);
                    }
                    break;
                case 'radio':
                case 'checkbox':
                    if (!empty($arguments['options']) && is_array($arguments['options'])) {
                        $options_markup = '';
                        $iterator = 0;
                        foreach ($arguments['options'] as $key => $label) {
                            $iterator++;
                            $options_markup .= sprintf('<label for="%1$s_%6$s"><input required id="%1$s_%6$s" name="%1$s[]" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>', $arguments['uid'], $arguments['type'], $key, checked($value[array_search($key, $value, true)], $key, false), $label, $iterator);
                        }
                        printf('<fieldset>%s</fieldset>', $options_markup);
                    }
                    break;
            }

            if ($helper = $arguments['helper']) {
                printf('<span class="helper"> %s</span>', $helper);
            }

            if ($supplimental = $arguments['supplimental']) {
                printf('<p class="description">%s</p>', $supplimental);
            }
        }
    }
    new Smashing_Fields_Plugin();
