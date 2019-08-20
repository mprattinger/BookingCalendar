<?php

//namespace MPR\Wordpress\BookingCalendar;
require_once("Services/CalendarService.php");

class MPR_BookingCalendar extends WP_Widget
{
    public function __construct()
    {
        $widget_ops = array(
            "classname" => "mpr_bookingcalendar",
            "description" => "Dieses Widget soll gebuchte Zeiten in einem Kalender anzeigen",
        );
        parent::__construct("mpr_bookingcalendar", "MPR Booking Calendar", $widget_ops);
    }

    public function widget($args, $instance)
    {
        ?>
        <div class="mpr-bc-container">
            <div class="mpr-bc-selector">
                <select id="mpr-bc-selector-month">
                    <option value="1">Januar</option>
                    <option value="2">Februar   </option>
                    <option value="3">März</option>
                    <option value="4">April</option>
                    <option value="5">Mai</option>
                    <option value="6">Juni</option>
                    <option value="7">Juli</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Dezember</option>
                </select>
                <select id="mpr-bc-selector-year"></select>
            </div>
            <div class="mpr-bc-table">
                <div class="mpr-bc-cell mpr-bc-header">
                    M
                </div>
                <div class="mpr-bc-cell mpr-bc-header">
                    D
                </div>
                <div class="mpr-bc-cell mpr-bc-header">
                    M
                </div>
                <div class="mpr-bc-cell mpr-bc-header">
                    D
                </div>
                <div class="mpr-bc-cell mpr-bc-header">
                    F
                </div>
                <div class="mpr-bc-cell mpr-bc-header">
                    S
                </div>
                <div class="mpr-bc-cell mpr-bc-header">
                    S
                </div>
            </div>
            <div class="mpr-bc-month-toggler">
            <a href="#" id="mpr-bc-toggler-prev"><< Zurück</a><span>|</span><a href="#" id="mpr-bc-toggler-next">Weiter >></a>
            </div>
        </div>
        <?php
    }

    public function form($instance){
        $calid = !empty($instance['mpr-bc-calid']) ? $instance['mpr-bc-calid'] : esc_html__('', 'text_domain');
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('mpr-bc-calid')); ?>">
                <?php esc_attr_e('Google Kalender Id:', 'text_domain');?>
            </label>
            <input
                class="widefat"
                id="<?php echo esc_attr($this->get_field_id('mpr-bc-calid')); ?>"
                name="<?php echo esc_attr($this->get_field_name('mpr-bc-calid')); ?>"
                type="text"
                value="<?php echo esc_attr($calid); ?>">
        </p>
        <?php
    }

    function update($new_instance, $old_instance){
        $instance = array();

        $instance['mpr-bc-calid'] = (!empty($new_instance['mpr-bc-calid'])) ? strip_tags($new_instance['mpr-bc-calid']) : '';

        return $instance;
    }
}