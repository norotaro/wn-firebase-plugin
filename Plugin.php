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
                // 'category'    => 'Users',
                'icon'        => 'icon-fire',
                'class'       => \Norotaro\Firebase\Models\Settings::class,
                'keywords'    => 'firebase',
                'permissions' => ['norotaro.firebase.access_settings'],
            ]
        ];
    }

    public function boot()
    {
        Models\Settings::extend(function ($model) {
            $availableProjects = config('firebase.projects');

            foreach ($availableProjects as $k => $v) {
                $model->attachOne[$k . 'Credentials'] = \System\Models\File::class;
            }
        });

        \Event::subscribe(Handlers\Events::class);

        // overwrite firebase package configuration with
        // the configuration established in the plugin
        $settings = Models\Settings::instance();
        $packageConfig = config('firebase');
        $pluginConfig = [
            'default' => $settings->default_project,
            'projects' => $settings->projects,
        ];

        config([
            'firebase' => array_replace_recursive($packageConfig, $pluginConfig),
        ]);
    }
}
