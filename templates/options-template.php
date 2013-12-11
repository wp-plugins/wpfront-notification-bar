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

/**
 * Template for WPFront Notification Bar Options
 *
 * @author Syam Mohan <syam@wpfront.com>
 * @copyright 2013 WPFront.com
 */
?>

<div class="wrap">
    <?php screen_icon(WPFront_Notification_Bar::OPTIONSPAGE_SLUG); ?>
    <h2><?php echo $this->__('WPFront Notification Bar Settings'); ?></h2>

    <div id="wpfront-notification-bar-options" class="inside">
        <form method="post" action="options.php"> 
            <?php @settings_fields(WPFront_Notification_Bar::OPTIONS_GROUP_NAME); ?>
            <?php @do_settings_sections(WPFront_Notification_Bar::OPTIONSPAGE_SLUG); ?>

            <?php if ($_GET['settings-updated'] == 'true' || $_GET['updated'] == 'true') { ?>
                <div class="updated">
                    <p>
                        <strong><?php echo $this->__('If you have a caching plugin, clear the cache for the new settings to take effect.'); ?></strong>
                    </p>
                </div>
            <?php } ?>

            <h3><?php echo $this->__('Display'); ?></h3>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <?php echo $this->options->enabled_label(); ?>
                    </th>
                    <td>
                        <input type="checkbox" name="<?php echo $this->options->enabled_name(); ?>" <?php echo $this->options->enabled() ? 'checked' : ''; ?> />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->position_label(); ?>
                    </th>
                    <td>
                        <select name="<?php echo $this->options->position_name(); ?>">
                            <option value="1" <?php echo $this->options->position() == '1' ? 'selected' : ''; ?>><?php echo $this->__('Top'); ?></option>
                            <option value="2" <?php echo $this->options->position() == '2' ? 'selected' : ''; ?>><?php echo $this->__('Bottom'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->fixed_position_label(); ?>
                    </th>
                    <td>
                        <input type="checkbox" name="<?php echo $this->options->fixed_position_name(); ?>" <?php echo $this->options->fixed_position() ? 'checked' : ''; ?> />&#160;<span class="description"><?php echo $this->__('[Sticky Bar, bar will stay at position regardless of scrolling.]'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->height_label(); ?>
                    </th>
                    <td>
                        <input class="seconds" name="<?php echo $this->options->height_name(); ?>" value="<?php echo $this->options->height(); ?>" />&#160;<?php echo $this->__('px'); ?>&#160;<span class="description">[<?php echo $this->__('Set 0px to auto fit contents.'); ?>]</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->display_after_label(); ?>
                    </th>
                    <td>
                        <input class="seconds" name="<?php echo $this->options->display_after_name(); ?>" value="<?php echo $this->options->display_after(); ?>" />&#160;<?php echo $this->__('second(s)'); ?>&#160;<span class="description">[<?php echo $this->__('Set 0 second(s) to display immediately.'); ?>]</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->animate_delay_label(); ?>
                    </th>
                    <td>
                        <input class="seconds" name="<?php echo $this->options->animate_delay_name(); ?>" value="<?php echo $this->options->animate_delay(); ?>" />&#160;<?php echo $this->__('second(s)'); ?>&#160;<span class="description">[<?php echo $this->__('Set 0 second(s) for no animation.'); ?>]</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->close_button_label(); ?>
                    </th>
                    <td>
                        <input type="checkbox" name="<?php echo $this->options->close_button_name(); ?>" <?php echo $this->options->close_button() ? 'checked' : ''; ?> />&#160;<span class="description"><?php echo $this->__('[Displays a close button at the top right corner of the bar.]'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->auto_close_after_label(); ?>
                    </th>
                    <td>
                        <input class="seconds" name="<?php echo $this->options->auto_close_after_name(); ?>" value="<?php echo $this->options->auto_close_after(); ?>" />&#160;<?php echo $this->__('second(s)'); ?>&#160;<span class="description">[<?php echo $this->__('Set 0 second(s) to disable auto close.'); ?>]</span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->display_shadow_label(); ?>
                    </th>
                    <td>
                        <input type="checkbox" name="<?php echo $this->options->display_shadow_name(); ?>" <?php echo $this->options->display_shadow() ? 'checked' : ''; ?> />
                    </td>
                </tr>
            </table>

            <h3><?php echo $this->__('Content'); ?></h3>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <?php echo $this->options->message_label(); ?>
                    </th>
                    <td>
                        <textarea rows="5" cols="75" name="<?php echo $this->options->message_name(); ?>"><?php echo $this->options->message(); ?></textarea>
                        <br />
                        <span class="description"><?php echo esc_html($this->__('[HTML tags are allowed. e.g. Add <br /> for break.]')); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->display_button_label(); ?>
                    </th>
                    <td>
                        <input type="checkbox" name="<?php echo $this->options->display_button_name(); ?>" <?php echo $this->options->display_button() ? 'checked' : ''; ?> />&#160;<span class="description"><?php echo $this->__('[Displays a button next to the message.]'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->button_text_label(); ?>
                    </th>
                    <td>
                        <input name="<?php echo $this->options->button_text_name(); ?>" value="<?php echo $this->options->button_text(); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->button_action_label(); ?>
                    </th>
                    <td>
                        <label>
                            <input type="radio" name="<?php echo $this->options->button_action_name(); ?>" value="1" <?php echo $this->options->button_action() == 1 ? 'checked' : ''; ?> />
                            <span><?php echo $this->options->button_action_url_label(); ?></span>
                        </label>
                        <input class="URL" name="<?php echo $this->options->button_action_url_name(); ?>" value="<?php echo $this->options->button_action_url(); ?>" />
                        <br />
                        <label>
                            <input type="checkbox" name="<?php echo $this->options->button_action_new_tab_name(); ?>" <?php echo $this->options->button_action_new_tab() ? 'checked' : ''; ?> />
                            <span><?php echo $this->options->button_action_new_tab_label(); ?></span>
                        </label>
                        <br />
                        <label>
                            <input type="radio" name="<?php echo $this->options->button_action_name(); ?>" value="2" <?php echo $this->options->button_action() == 2 ? 'checked' : ''; ?> />
                            <span><?php echo $this->options->button_action_javascript_label(); ?></span>
                        </label>
                        <br />
                        <textarea rows="5" cols="75" name="<?php echo $this->options->button_action_javascript_name(); ?>"><?php echo $this->options->button_action_javascript(); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->button_action_close_bar_label(); ?>
                    </th>
                    <td>
                        <input type="checkbox" name="<?php echo $this->options->button_action_close_bar_name(); ?>" <?php echo $this->options->button_action_close_bar() ? 'checked' : ''; ?> />
                    </td>
                </tr>
            </table>

            <h3><?php echo $this->__('Color'); ?></h3>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <?php echo $this->__('Bar Color'); ?>
                    </th>
                    <td>
                        <div class="color-selector" color="<?php echo $this->options->bar_from_color(); ?>"></div>&#160;<span><?php echo $this->options->bar_from_color(); ?></span>
                        <input type="hidden" name="<?php echo $this->options->bar_from_color_name(); ?>" value="<?php echo $this->options->bar_from_color(); ?>" />
                        &#160;&#160;
                        <div class="color-selector" color="<?php echo $this->options->bar_to_color(); ?>"></div>&#160;<span><?php echo $this->options->bar_to_color(); ?></span>
                        <input type="hidden" name="<?php echo $this->options->bar_to_color_name(); ?>" value="<?php echo $this->options->bar_to_color(); ?>" />
                        &#160;&#160;
                        <span class="description"><?php echo $this->__('[Select two different colors to create a gradient.]'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->message_color_label(); ?>
                    </th>
                    <td>
                        <div class="color-selector" color="<?php echo $this->options->message_color(); ?>"></div>&#160;<span><?php echo $this->options->message_color(); ?></span>
                        <input type="hidden" name="<?php echo $this->options->message_color_name(); ?>" value="<?php echo $this->options->message_color(); ?>" />
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->__('Button Color'); ?>
                    </th>
                    <td>
                        <div class="color-selector" color="<?php echo $this->options->button_from_color(); ?>"></div>&#160;<span><?php echo $this->options->button_from_color(); ?></span>
                        <input type="hidden" name="<?php echo $this->options->button_from_color_name(); ?>" value="<?php echo $this->options->button_from_color(); ?>" />
                        &#160;&#160;
                        <div class="color-selector" color="<?php echo $this->options->button_to_color(); ?>"></div>&#160;<span><?php echo $this->options->button_to_color(); ?></span>
                        <input type="hidden" name="<?php echo $this->options->button_to_color_name(); ?>" value="<?php echo $this->options->button_to_color(); ?>" />
                        &#160;&#160;
                        <span class="description"><?php echo $this->__('[Select two different colors to create a gradient.]'); ?></span>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <?php echo $this->options->button_text_color_label(); ?>
                    </th>
                    <td>
                        <div class="color-selector" color="<?php echo $this->options->button_text_color(); ?>"></div>&#160;<span><?php echo $this->options->button_text_color(); ?></span>
                        <input type="hidden" name="<?php echo $this->options->button_text_color_name(); ?>" value="<?php echo $this->options->button_text_color(); ?>" />
                    </td>
                </tr>
            </table>

            <?php @$this->submit_button(); ?>
        </form>
    </div>
</div>

<script type="text/javascript">
    (function($) {
        function setColorPicker(div) {
            div.ColorPicker({
                color: div.attr('color'),
                onShow: function(colpkr) {
                    $(colpkr).fadeIn(500);
                    return false;
                }, onHide: function(colpkr) {
                    $(colpkr).fadeOut(500);
                    return false;
                },
                onChange: function(hsb, hex, rgb) {
                    div.css('backgroundColor', '#' + hex);
                    div.next().text('#' + hex).next().val('#' + hex);
                }
            }).css('backgroundColor', div.attr('color'));
        }

        $('#wpfront-notification-bar-options').find(".color-selector").each(function(i, e) {
            setColorPicker($(e));
        });
    })(jQuery);
</script>