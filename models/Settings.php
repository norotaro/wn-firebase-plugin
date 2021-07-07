<?php

namespace Norotaro\Firebase\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'norotaro_firebase_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    public function getDefaultProjectOptions($value, $formData)
    {
        $projects = collect(config('firebase.projects'))->keys();
        return $projects->combine($projects);
    }

    /**
     * return only attributes that has values
     * and attach credential files
     */
    public function getProjectsAttribute()
    {
        $value = $this->attributes['projects'];

        $projects = $this->projectConfigFilter($value);

        // attach credential files from attachOne relations
        foreach ($value as $projectKey => $val) {
            if (!empty($this->{$projectKey . 'Credentials'})) {
                $projects[$projectKey]['credentials']['file'] = $this->{$projectKey . 'Credentials'}->getLocalPath();
            }
        }

        return $projects;
    }

    /**
     * filter empty values from projects config
     * the value 0 has to be consider as not empty
     */
    private function projectConfigFilter(&$config)
    {
        foreach ($config as $k => $v) {
            if (is_array($v)) {
                $config[$k] = $this->projectConfigFilter($v);
                if (!count($v)) unset($config[$k]);
            } else {
                if (is_null($v) || $v === '') unset($config[$k]);
            }
        }

        return $config;
    }
}
