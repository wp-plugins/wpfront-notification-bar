<?php

/*
  WPFront Notification Bar Plugin
  Copyright (C) 2013, WPFront.com
  Website: wpfront.com
  Contact: syam@wpfront.com

  WPFront Notification Bar Plugin is distributed under the GNU General Public License, Version 3,
  June 2007. Copyright (C) 2007 Free Software Foundation, Inc., 51 Franklin
  St, Fifth Floor, Boston, MA 02110, USA

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
  ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
  WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
  ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
  (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
  LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
  ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
  SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

require_once("class-wpfront-notification-bar-options.php");

if (!class_exists('WPFront_Notification_Bar')) {

    /**
     * Main class of WPFront Notification Bar plugin
     *
     * @author Syam Mohan <syam@wpfront.com>
     * @copyright 2013 WPFront.com
     */
    class WPFront_Notification_Bar {

        //Constants
        const VERSION = '1.1';
        const OPTIONSPAGE_SLUG = 'wpfront-notification-bar';
        const OPTIONS_GROUP_NAME = 'wpfront-notification-bar-options-group';
        const OPTION_NAME = 'wpfront-notification-bar-options';
        const PLUGIN_SLUG = 'wpfront-notification-bar';
        
        //cookie names
        const COOKIE_LANDINGPAGE = 'wpfront-notification-bar-landingpage';

        //Variables
        private $pluginURLRoot;
        private $pluginDIRRoot;
        private $options;
        private $markupLoaded;
        private $scriptLoaded;

        function __construct() {
            $this->markupLoaded = FALSE;

            //Root variables
            $this->pluginURLRoot = plugins_url() . '/wpfront-notification-bar/';
            $this->pluginDIRRoot = dirname(__FILE__) . '/../';

            add_action('init', array(&$this, 'init'));

            //register actions
            if (is_admin()) {
                add_action('admin_init', array(&$this, 'admin_init'));
                add_action('admin_menu', array(&$this, 'admin_menu'));
                add_filter('plugin_action_links', array(&$this, 'action_links'), 10, 2);
            } else {
                add_action('wp_enqueue_scripts', array(&$this, 'enqueue_styles'));
                add_action('wp_enqueue_scripts', array(&$this, 'enqueue_scripts'));
            }

            add_action('wp_footer', array(&$this, 'write_markup'));
            add_action('shutdown', array(&$this, 'write_markup'));
            add_action('plugins_loaded', array(&$this, 'plugins_loaded'));
        }

        public function init() {
            //for landing page tracking
            if (!isset($_COOKIE[self::COOKIE_LANDINGPAGE])) {
                setcookie(self::COOKIE_LANDINGPAGE, 1);
            }
        }

        //add scripts
        public function enqueue_scripts() {
            if ($this->enabled() == FALSE)
                return;

            $jsRoot = $this->pluginURLRoot . 'js/';

            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery.cookie', $this->pluginURLRoot . 'jquery-plugins/jquery.cookie.js', array('jquery'), '1.4.0');
            wp_enqueue_script('wpfront-notification-bar', $jsRoot . 'wpfront-notification-bar.js', array('jquery'), self::VERSION);

            $this->scriptLoaded = TRUE;
        }

        //add styles
        public function enqueue_styles() {
            if ($this->enabled() == FALSE)
                return;

            $cssRoot = $this->pluginURLRoot . 'css/';

            wp_enqueue_style('wpfront-notification-bar', $cssRoot . 'wpfront-notification-bar.css', array(), self::VERSION);
        }

        public function admin_init() {
            register_setting(self::OPTIONS_GROUP_NAME, self::OPTION_NAME);
        }

        public function admin_menu() {
            $page_hook_suffix = add_options_page($this->__('WPFront Notification Bar'), $this->__('Notification Bar'), 'manage_options', self::OPTIONSPAGE_SLUG, array($this, 'options_page'));

            //register for options page scripts and styles
            add_action('admin_print_scripts-' . $page_hook_suffix, array($this, 'enqueue_options_scripts'));
            add_action('admin_print_styles-' . $page_hook_suffix, array($this, 'enqueue_options_styles'));
        }

        //options page scripts
        public function enqueue_options_scripts() {
            $this->enqueue_scripts();

            $jsRoot = $this->pluginURLRoot . 'jquery-plugins/colorpicker/js/';
            wp_enqueue_script('jquery.eyecon.colorpicker', $jsRoot . 'colorpicker.js', array('jquery'), self::VERSION);

//            $jsRoot = $this->pluginURLRoot . 'js/';
//            wp_enqueue_script('wpfront-notification-bar-options', $jsRoot . 'options.js', array(), self::VERSION);
        }

        //options page styles
        public function enqueue_options_styles() {
            $this->enqueue_styles();

            $styleRoot = $this->pluginURLRoot . 'jquery-plugins/colorpicker/css/';
            wp_enqueue_style('jquery.eyecon.colorpicker.colorpicker', $styleRoot . 'colorpicker.css', array(), self::VERSION);

            $styleRoot = $this->pluginURLRoot . 'css/';
            wp_enqueue_style('wpfront-notification-bar-options', $styleRoot . 'options.css', array(), self::VERSION);
        }

        //creates options page
        public function options_page() {
            if (!current_user_can('manage_options')) {
                wp_die($this->__('You do not have sufficient permissions to access this page.'));
                return;
            }

            include($this->pluginDIRRoot . 'templates/options-template.php');
        }

        //add "settings" link
        public function action_links($links, $file) {
            if ($file == 'wpfront-notification-bar/wpfront-notification-bar.php') {
                $settings_link = '<a href="' . get_bloginfo('wpurl') . '/wp-admin/options-general.php?page=' . self::OPTIONSPAGE_SLUG . '">' . $this->__('Settings') . '</a>';
                array_unshift($links, $settings_link);
            }
            return $links;
        }

        public function plugins_loaded() {
            //load plugin options
            $this->options = new WPFront_Notification_Bar_Options(self::OPTION_NAME, self::PLUGIN_SLUG);

            //for localization
            load_plugin_textdomain(self::PLUGIN_SLUG, FALSE, $this->pluginDIRRoot . 'languages/');
        }

        //writes the html and script for the bar
        public function write_markup() {
            if ($this->markupLoaded) {
                return;
            }

            if ($this->scriptLoaded != TRUE) {
                return;
            }

            if ($this->enabled()) {
                include($this->pluginDIRRoot . 'templates/notification-bar-template.php');

                echo '<script type="text/javascript">';
                echo 'if(typeof wpfront_notification_bar == "function") ';
                echo 'wpfront_notification_bar(' . json_encode(array(
                    'position' => $this->options->position(),
                    'height' => $this->options->height(),
                    'fixed_position' => $this->options->fixed_position(),
                    'animate_delay' => $this->options->animate_delay(),
                    'close_button' => $this->options->close_button(),
                    'button_action_close_bar' => $this->options->button_action_close_bar(),
                    'auto_close_after' => $this->options->auto_close_after(),
                    'display_after' => $this->options->display_after(),
                    'is_admin_bar_showing' => $this->is_admin_bar_showing(),
                    'display_open_button' => $this->options->display_open_button(),
                    'keep_closed' => $this->options->keep_closed(),
                    'position_offset' => $this->options->position_offset(),
                )) . ');';
                echo '</script>';
            }

            $this->markupLoaded = TRUE;
        }

        //returns localized string
        public function __($key) {
            return __($key, self::PLUGIN_SLUG);
        }

        //for compatibility
        private function submit_button() {
            if (function_exists('submit_button')) {
                submit_button();
            } else {
                echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="' . $this->__('Save Changes') . '" /></p>';
            }
        }

        private function is_admin_bar_showing() {
            if (function_exists('is_admin_bar_showing')) {
                return is_admin_bar_showing();
            }

            return FALSE;
        }

        private function get_filter_objects() {
            $objects = array();

            $objects['1.home'] = $this->__('[Page]') . ' ' . $this->__('Home');

            $pages = get_pages();
            foreach ($pages as $page) {
                $objects['1.' . $page->ID] = $this->__('[Page]') . ' ' . $page->post_title;
            }

            $posts = get_posts();
            foreach ($posts as $post) {
                $objects['2.' . $post->ID] = $this->__('[Post]') . ' ' . $post->post_title;
            }

//            $categories = get_categories();
//            foreach ($categories as $category) {
//                $objects['3.' . $category->cat_ID] = $this->__('[Category]') . ' ' . $category->cat_name;
//            }

            return $objects;
        }

        private function filter_page() {
            if (is_admin())
                return TRUE;
            
            switch ($this->options->display_pages()) {
                case 1:
                    return TRUE;
                case 2:
                    return !isset($_COOKIE[self::COOKIE_LANDINGPAGE]);
                case 3:
                case 4:
                    global $post;
                    $ID = FALSE;
                    $type = FALSE;
                    if (is_home()) {
                        $ID = 'home';
                        $type = 1;
                    } elseif (is_singular()) {
                        $post_type = get_post_type();
                        if ($post_type == 'page') {
                            $ID = $post->ID;
                            $type = 1;
                        } elseif ($post_type == 'post') {
                            $ID = $post->ID;
                            $type = 2;
                        }
                    }
                    if ($this->options->display_pages() == 3) {
                        if ($ID !== FALSE && $type !== FALSE) {
                            if (strpos($this->options->include_pages(), $type . '.' . $ID) === FALSE)
                                return FALSE;
                            else
                                return TRUE;
                        }
                        return FALSE;
                    }
                    if ($this->options->display_pages() == 4) {
                        if ($ID !== FALSE && $type !== FALSE) {
                            if (strpos($this->options->exclude_pages(), $type . '.' . $ID) === FALSE)
                                return TRUE;
                            else
                                return FALSE;
                        }
                        return TRUE;
                    }
            }

            return TRUE;
        }

        private function enabled() {
            if ($this->options->enabled()) {
                return $this->filter_page();
            }

            return FALSE;
        }

    }

}