<?php

namespace App\Form\Admin\Handler;

use App\Entity\Settings;
use App\Service\File\FileSaver;
use App\Service\Manager\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;

class SettingsFormHandler extends AbstractController
{
    public function __construct(
        public UserManager $settingsManager,
        public FileSaver   $fileSaver,
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function processEditForm(Settings $settings, Form $form): Settings
    {

        $newLogo = $form['logo']->getData();
        $dirImage = $settings->getLogoPath() ? $settings->getLogoPath() : uniqid();
        if ($newLogo != null) {
            $tempImageFileName = $newLogo ? $this->fileSaver->saveLogoUploadedFileIntoTemp($newLogo) : null;
            $this->settingsManager->saveLogoImage($settings, $tempImageFileName,$dirImage);
        }
//        if ($form['date']->getData()){
//            $interval=$form['date']->getData();
//            $date = new \DateTime($interval);
//            $settings->setComing($date);
//        }
        return $settings;
    }
}