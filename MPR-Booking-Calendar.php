<?php

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
                <select id="mpr-bc-selector-month"></select>
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
    }

    function update($new_instance, $old_instance){
    }
}