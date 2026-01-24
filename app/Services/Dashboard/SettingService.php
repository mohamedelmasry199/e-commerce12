<?php

namespace App\Services\Dashboard;

use App\Repositories\Dashboard\SettingRepository;
use App\Utils\ImageManager;

class SettingService
{
    /**
     * Create a new class instance.
     */
    protected $settingRepository;
    protected $imageManager;
    public function __construct(SettingRepository $settingRepository , ImageManager $imageManager)
    {
        $this->settingRepository = $settingRepository;
        $this->imageManager = $imageManager;
    }
    public function getSetting()
    {
        $setting = $this->settingRepository->getSetting();
        return $setting ? $setting : abort(404);
    }
    public function updateSetting($data, $id)
    {
        $setting =$this->getSetting();
        if(isset($data['logo']) && $data['logo'] != null){
            $this->imageManager->deleteImageFromLocal($setting->logo);
            $data['logo']= $this->imageManager->uploadSingleImage('/', $data['logo'],'settings');
        }
        if(isset($data['favicon']) && $data['favicon'] != null){
            $this->imageManager->deleteImageFromLocal($setting->favicon);
            $data['favicon']= $this->imageManager->uploadSingleImage('/', $data['favicon'],'settings');
        }
        return $this->settingRepository->updateSetting($data, $setting);
    }
}
