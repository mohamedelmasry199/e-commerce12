<?php

namespace App\Repositories\Dashboard;

use App\Models\Setting;

class SettingRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function getSetting()
    {
        return Setting::first();
    }
    public function updateSetting($data, $setting)
    {
        $setting->update($data);
        return $setting;
    }
}
