<?php

namespace Norotaro\Firebase;

class Plugin extends \System\Classes\PluginBase
{
    public function register()
    {
        \App::register(\Kreait\Laravel\Firebase\ServiceProvider::class);
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'norotaro.firebase::lang.settings.menu',
                'description' => 'norotaro.firebase::lang.settings.menu_description',
                'category'    => 'norotaro.firebase::lang.plugin.name',
                'icon'        => 'icon-link',
                'class'       => Models\Settings::class,
                'keywords'    => 'firebase',
                'permissions' => ['norotaro.firebase.access_settings'],
            ]
        ];
    }

    public function boot()
    {
        Models\Settings::extend(function ($model) {
            $availableProjects = config('firebase.projects');

            // create a relationship to save the credentials
            // for each available project
            foreach ($availableProjects as $k => $v) {
                $model->attachOne[$k . 'Credentials'] = \System\Models\File::class;
            }
        });

        \Event::subscribe(Handlers\Events::class);

        // overwrite the Firebase package configurations
        // with the configurations set in the plugin
        $settings = Models\Settings::instance();
        $packageConfig = config('firebase');
        $pluginConfig = [
            'projects' => $settings->projects,
        ];

        if ($settings->default_project) {
            $pluginConfig['default'] = $settings->default_project;
        }

        config([
            'firebase' => array_replace_recursive($packageConfig, $pluginConfig),
        ]);
    }
}
