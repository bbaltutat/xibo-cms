<?php
/*
 * Xibo - Digital Signage - http://www.xibo.org.uk
 * Copyright (C) 2006-2015 Daniel Garner
 *
 * This file is part of Xibo.
 *
 * Xibo is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * Xibo is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Xibo.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace Xibo\Widget;

use Slim\Slim;
use Xibo\Entity\User;
use Xibo\Exception\ControllerNotImplemented;
use Xibo\Exception\NotFoundException;
use Xibo\Factory\MediaFactory;
use Xibo\Helper\Config;
use Xibo\Helper\Log;
use Xibo\Helper\Sanitize;


abstract class Module implements ModuleInterface
{
    /**
     * @var Slim
     */
    protected $app;

    /**
     * @var \Xibo\Entity\Module $module
     */
    protected $module;

    /**
     * @var \Xibo\Entity\Widget $widget Widget
     */
    public $widget;

    /**
     * @var User $user
     */
    protected $user;

    /**
     * @var \Xibo\Entity\Region $region The region this module is in
     */
    protected $region;

    /**
     * @var int $codeSchemaVersion The Schema Version of this code
     */
    protected $codeSchemaVersion = -1;

    /**
     * Create the controller
     */
    public function __construct()
    {
        $this->app = Slim::getInstance();
    }

    /**
     * Get the App
     * @return Slim
     */
    protected function getApp()
    {
        return $this->app;
    }

    /**
     * Set the Widget
     * @param \Xibo\Entity\Widget $widget
     */
    final public function setWidget($widget)
    {
        $this->widget = $widget;
    }

    /**
     * Set the Module
     * @param \Xibo\Entity\Module $module
     */
    final public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * Get the module
     * @return \Xibo\Entity\Module
     */
    final public function getModule()
    {
        return $this->module;
    }

    /**
     * Set the regionId
     * @param \Xibo\Entity\Region $region
     */
    final public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * Set User
     * @param User $user
     */
    final public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * Set the duration
     * @param int $duration
     */
    final protected function setDuration($duration)
    {
        $this->widget->duration = $duration;
    }

    /**
     * Save the Module
     */
    protected final function saveSettings()
    {
        // Save
        $this->module->save();
    }

    /**
     * Set Option
     * @param string $name
     * @param string $value
     */
    final protected function setOption($name, $value)
    {
        $this->widget->setOptionValue($name, 'attrib', $value);
    }

    /**
     * Get Option or Default
     * @param string $name
     * @param mixed [Optional] $default
     * @return mixed
     */
    final public function getOption($name, $default = null)
    {
        return $this->widget->getOptionValue($name, $default);
    }

    /**
     * Get User
     * @return User
     */
    final protected function getUser()
    {
        return $this->user;
    }

    /**
     * Get Raw Node Value
     * @param string $name
     * @param mixed $default
     * @return mixed
     */
    final public function getRawNode($name, $default = null)
    {
        return $this->widget->getOptionValue($name, $default);
    }

    /**
     * Set Raw Node Value
     * @param $name
     * @param $value
     */
    final protected function setRawNode($name, $value)
    {
        $this->widget->setOptionValue($name, 'cdata', $value);
    }

    /**
     * Assign Media
     * @param int $mediaId
     */
    final protected function assignMedia($mediaId)
    {
        $this->widget->assignMedia($mediaId);
    }

    /**
     * Unassign Media
     * @param int $mediaId
     */
    final protected function unassignMedia($mediaId)
    {
        $this->widget->unassignMedia($mediaId);
    }

    /**
     * Get WidgetId
     * @return int
     */
    final protected function getWidgetId()
    {
        return $this->widget->widgetId;
    }

    /**
     * Get the PlaylistId
     * @return int
     */
    final protected function getPlaylistId()
    {
        return $this->widget->playlistId;
    }

    /**
     * Get the Module type
     * @return string
     */
    final public function getModuleType()
    {
        return $this->module->type;
    }

    /**
     * Get the Module Name
     * @return string
     */
    final public function getModuleName()
    {
        return $this->module->name;
    }

    /**
     * Get the duration
     * @return int
     */
    final public function getDuration()
    {
        return $this->widget->duration;
    }

    /**
     * Save the Widget
     */
    final protected function saveWidget()
    {
        $this->widget->save();
    }

    /**
     * Delete Widget
     */
    public function delete()
    {
        // By default this doesn't do anything
        // Module specific delete functionality should go here in the super class
    }

    /**
     * Get Name
     * @return string
     */
    public function getName()
    {
        Log::debug('Media assigned: ' . count($this->widget->mediaIds));

        if (count($this->widget->mediaIds) > 0) {
            $media = MediaFactory::getById($this->widget->mediaIds[0]);
            $name = $media->name;
        } else {
            $name = $this->module->name;
        }

        return $this->getOption('name', $name);
    }

    /**
     * Preview code for a module
     * @param double $width
     * @param double $height
     * @param int [Optional] $scaleOverride
     * @return string
     */
    public function preview($width, $height, $scaleOverride = 0)
    {
        if ($this->module->previewEnabled == 0)
            return $this->previewIcon();

        return $this->previewAsClient($width, $height, $scaleOverride);
    }

    /**
     * Preview Icon
     * @return string
     */
    public function previewIcon()
    {
        return '<div style="text-align:center;"><img alt="' . $this->getModuleType() . ' thumbnail" src="theme/default/img/forms/' . $this->getModuleType() . '.gif" /></div>';
    }

    /**
     * Preview as the Client
     * @param double $width
     * @param double $height
     * @param int [Optional] $scaleOverride
     * @return string
     */
    public function previewAsClient($width, $height, $scaleOverride = 0)
    {
        $widthPx = $width . 'px';
        $heightPx = $height . 'px';

        $url = $this->getApp()->urlFor('module.getResource', ['regionId' => $this->region->regionId, 'id' => $this->getWidgetId()]);

        return '<iframe scrolling="no" src="' . $url . '?raw=true&preview=true&scale_override=' . $scaleOverride . '&width=' . $width . '&height=' . $height . '" width="' . $widthPx . '" height="' . $heightPx . '" style="border:0;"></iframe>';
    }

    /**
     * Default code for the hover preview
     * @return string
     */
    public function HoverPreview()
    {
        // Default Hover window contains a thumbnail, media type and duration
        $output = '<div class="well">';
        $output .= '<div class="preview-module-image"><img alt="' . __($this->module->name) . ' thumbnail" src="theme/default/img/forms/' . $this->module->type . '.gif" /></div>';
        $output .= '<div class="info">';
        $output .= '    <ul>';
        $output .= '    <li>' . __('Type') . ': ' . $this->module->name . '</li>';
        $output .= '    <li>' . __('Name') . ': ' . $this->getName() . '</li>';
        $output .= '    <li>' . __('Duration') . ': ' . $this->widget->duration . ' ' . __('seconds') . '</li>';
        $output .= '    </ul>';
        $output .= '</div>';
        $output .= '</div>';

        return $output;
    }

    /**
     * Default Get Resource
     * @param int $displayId
     * @return mixed
     * @throws ControllerNotImplemented
     */
    public function getResource($displayId = 0)
    {
        throw new ControllerNotImplemented();
    }

    /**
     * Get Resource Url
     * @param $uri
     * @return string
     */
    protected function getResourceUrl($uri)
    {
        $isPreview = (Sanitize::getCheckbox('preview') == 1);

        if ($isPreview)
            $uri = $this->getApp()->urlFor('home') . 'modules/' . $uri;

        return $uri;
    }

    /**
     * Render a template and return the results
     * @param $data
     * @param string $template
     * @return mixed
     */
    protected function renderTemplate($data, $template = 'get-resource')
    {
        // Get the Twig Engine
        return $this->getApp()->view()->getInstance()->render($template . '.twig', $data);
    }

    /**
     * Get the the Transition for this media
     * @param string $type Either "in" or "out"
     * @return string
     */
    public function getTransition($type)
    {
        switch ($type) {
            case 'in':
                $code = $this->getOption('transIn');
                break;

            case 'out':
                $code = $this->getOption('transOut');
                break;

            default:
                $code = '';
                trigger_error(_('Unknown transition type'), E_USER_ERROR);
        }

        if ($code == '')
            return __('None');

        // Look up the real transition name
        $transition = $this->user->TransitionAuth('', $code);

        return __($transition[0]['transition']);
    }

    /**
     * Default behaviour for install / upgrade
     * this should be overridden for new modules
     */
    public function installOrUpdate()
    {
        if ($this->module->renderAs != 'native')
            throw new ControllerNotImplemented(__('Module must implement InstallOrUpgrade'));
    }

    /**
     * Installs any files specific to this module
     */
    public function installFiles()
    {

    }

    public function installModule($name, $description, $imageUri, $previewEnabled, $assignable, $settings)
    {

        Log::notice('Request to install module with name: ' . $name, 'module', 'InstallModule');

        try {
            // Validate some things.
            if ($this->type == '')
                throw new Exception(__('Module has not set the module type'));

            if ($name == '')
                throw new Exception(__('Module has not set the module name'));

            if ($description == '')
                throw new Exception(__('Module has not set the description'));

            if (!is_numeric($previewEnabled))
                throw new Exception(__('Preview Enabled variable must be a number'));

            if (!is_numeric($assignable))
                throw new Exception(__('Assignable variable must be a number'));

            $dbh = \Xibo\Storage\PDOConnect::init();

            $sth = $dbh->prepare('
                    INSERT INTO `module` (`Module`, `Name`, `Enabled`, `RegionSpecific`, `Description`,
                        `ImageUri`, `SchemaVersion`, `ValidExtensions`, `PreviewEnabled`, `assignable`, `render_as`, `settings`)
                    VALUES (:module, :name, :enabled, :region_specific, :description,
                        :image_uri, :schema_version, :valid_extensions, :preview_enabled, :assignable, :render_as, :settings);
                ');

            Log::notice('Executing SQL', 'module', 'InstallModule');

            $sth->execute(array(
                'module' => $this->module->type,
                'name' => $name,
                'enabled' => 1,
                'region_specific' => 1,
                'description' => $description,
                'image_uri' => $imageUri,
                'schema_version' => $this->codeSchemaVersion,
                'valid_extensions' => '',
                'preview_enabled' => $previewEnabled,
                'assignable' => $assignable,
                'render_as' => 'html',
                'settings' => json_encode($settings)
            ));
        } catch (Exception $e) {
            Log::error($e->getMessage());

            throw new Exception(__('Unable to install module. Please check the Error Log'));
        }
    }

    public function upgradeModule($name, $description, $imageUri, $previewEnabled, $assignable, $settings)
    {

        try {
            // Validate some things.
            if ($this->module->moduleId == '')
                throw new Exception(__('This module does not exist - should you have called Install?'));

            if ($name == '')
                throw new Exception(__('Module has not set the module name'));

            if ($description == '')
                throw new Exception(__('Module has not set the description'));

            if (!is_numeric($previewEnabled))
                throw new Exception(__('Preview Enabled variable must be a number'));

            if (!is_numeric($assignable))
                throw new Exception(__('Assignable variable must be a number'));

            $dbh = \Xibo\Storage\PDOConnect::init();

            $sth = $dbh->prepare('
                    UPDATE `module` SET `Name` = :name, `Description` = :description,
                        `ImageUri` = :image_uri, `SchemaVersion` = :schema_version, `PreviewEnabled` = :preview_enabled,
                        `assignable` = :assignable, `settings` = :settings
                     WHERE ModuleID = :module_id
                ');

            $sth->execute(array(
                'name' => $name,
                'description' => $description,
                'image_uri' => $imageUri,
                'schema_version' => $this->codeSchemaVersion,
                'preview_enabled' => $previewEnabled,
                'assignable' => $assignable,
                'settings' => $settings,
                'module_id' => $this->module->moduleId
            ));
        } catch (Exception $e) {

            Log::error($e->getMessage());

            throw $e;
        }
    }

    /**
     * Form for updating the module settings
     */
    public function settingsForm()
    {
        return null;
    }

    /**
     * Process any module settings
     */
    public function settings()
    {
        return array();
    }

    /**
     * Get Module Setting
     * @param string $setting
     * @param mixed $default
     * @return mixed
     */
    public function getSetting($setting, $default = NULL)
    {
        if (isset($this->module->settings[$setting]))
            return $this->module->settings[$setting];
        else
            return $default;
    }

    /**
     * Get Media Id
     * @return int
     * @throws NotFoundException
     */
    protected function getMediaId()
    {
        if (count($this->widget->mediaIds) <= 0)
            throw new NotFoundException(__('No file to return'));

        return $this->widget->mediaIds[0];
    }

    /**
     * Return File
     */
    protected function download()
    {
        $media = MediaFactory::getById($this->getMediaId());

        // This widget is expected to output a file - usually this is for file based media
        // Get the name with library
        $libraryLocation = Config::GetSetting('LIBRARY_LOCATION');
        $libraryPath = $libraryLocation . $media->storedAs;
        $attachmentName = Sanitize::getString('attachment', $media->storedAs);

        $size = filesize($libraryPath);

        // Issue some headers
        $this->getApp()->etag($media->md5);
        $this->getApp()->expires('+1 week');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: Binary');
        header('Content-disposition: attachment; filename="' . $attachmentName . '"');
        header('Content-Length: ' . $size);

        // Send via Apache X-Sendfile header?
        if (Config::GetSetting('SENDFILE_MODE') == 'Apache') {
            header("X-Sendfile: $libraryPath");
        }
        // Send via Nginx X-Accel-Redirect?
        else if (Config::GetSetting('SENDFILE_MODE') == 'Nginx') {
            header("X-Accel-Redirect: /download/" . $attachmentName);
        }
        else {
            // Return the file with PHP
            readfile($libraryPath);
        }
    }

}
