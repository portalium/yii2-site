<?php

namespace portalium\site\components;

use yii;
use yii\base\Component;

class TimeZoneHelper extends Component
{
    public static function getFormattedTimeZones()
    {

        $timezones = json_decode(file_get_contents(Yii::getAlias('@portalium/site/assets/timezones.json')), true);

        $formattedTimezones = [];
        foreach ($timezones as $timezone) {
            if (isset($timezone['utc']) && is_array($timezone['utc'])) {
                foreach ($timezone['utc'] as $city) {
                    $formattedTimezones[] = [
                        'timezone' => $city,
                        'name' => $timezone['text'] . " (" . $city . ")"
                    ];
                }
            }
        }

        return $formattedTimezones;
    }

    public static function getOffset($timezone)
    {
        try {
            $tz = new \DateTimeZone($timezone);
            $datetime = new \DateTime('now', $tz);
            return $tz->getOffset($datetime);
        } catch (\Exception $e) {
            return 0;
        }
    }
}
