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

require_once("class-wpfront-options-base.php");

if (!class_exists('WPFront_Notification_Bar_Options')) {

    /**
     * Options class for WPFront Notification Bar plugin
     *
     * @author Syam Mohan <syam@wpfront.com>
     * @copyright 2013 WPFront.com
     */
    class WPFront_Notification_Bar_Options extends WPFront_Options_Base {

        function __construct($optionName, $pluginSlug) {
            parent::__construct($optionName, $pluginSlug);

            //add the options required for this plugin
            $this->addOption('enabled', 'bit', FALSE)->__('Enabled');
            $this->addOption('position', 'int', 1, array($this, 'validate_1or2'))->__('Position');
            $this->addOption('height', 'int', 0, array($this, 'validate_zero_positive'))->__('Bar Height');
            $this->addOption('message', 'string', '')->__('Message Text');
            $this->addOption('display_after', 'int', 1, array($this, 'validate_zero_positive'))->__('Display After');
            $this->addOption('animate_delay', 'float', 0.5, array($this, 'validate_zero_positive'))->__('Animation Duration');
            $this->addOption('close_button', 'bool', FALSE)->__('Display Close Button');
            $this->addOption('auto_close_after', 'int', 0, array($this, 'validate_zero_positive'))->__('Auto Close After');
            $this->addOption('display_button', 'bool', FALSE)->__('Display Button');
            $this->addOption('button_text', 'string', '')->__('Button Text');
            $this->addOption('button_action', 'int', 1, array($this, 'validate_1or2'))->__('Button Action');
            $this->addOption('button_action_url', 'string', '')->__('Open URL:');
            $this->addOption('button_action_new_tab', 'bool', FALSE)->__('Open URL in new tab/window');
            $this->addOption('button_action_javascript', 'string', '')->__('Execute JavaScript');
            $this->addOption('button_action_close_bar', 'bit', FALSE)->__('Close Bar on Button Click');
            $this->addOption('display_shadow', 'bit', FALSE)->__('Display Shadow');
            $this->addOption('fixed_position', 'bit', FALSE)->__('Fixed at Position');
            $this->addOption('message_color', 'string', '#ffffff', array($this, 'validate_color'))->__('Message Text Color');
            $this->addOption('bar_from_color', 'string', '#888888', array($this, 'validate_color'))->__('From Color');
            $this->addOption('bar_to_color', 'string', '#000000', array($this, 'validate_color'))->__('To Color');
            $this->addOption('button_from_color', 'string', '#00b7ea', array($this, 'validate_color'))->__('From Color');
            $this->addOption('button_to_color', 'string', '#009ec3', array($this, 'validate_color'))->__('To Color');
            $this->addOption('button_text_color', 'string', '#ffffff', array($this, 'validate_color'))->__('Button Text Color');
        }

        //validation function
        protected function validate_1or2($arg) {
            if ($arg < 1) {
                return 1;
            }

            if ($arg > 2) {
                return 2;
            }

            return $arg;
        }
        
        //validation function
        protected function validate_color($arg) {
            if (strlen($arg) != 7)
                return '#ffffff';

            if (strpos($arg, '#') != 0)
                return '#ffffff';

            return $arg;
        }

    }

}