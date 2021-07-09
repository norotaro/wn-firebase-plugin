<?php

namespace Norotaro\Firebase\Handlers;

use Yaml;

class Events
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        // for supporting multiple acocunts
        // we need to extend the settings form of this plugin
        // with a nested form for each available project
        $events->listen('backend.form.extendFields', 'Norotaro\Firebase\Handlers\Events@backendFormExtendFields');
    }

    public function backendFormExtendFields($widget)
    {
        // Only for the Settings model
        if (!$widget->model instanceof \Norotaro\Firebase\Models\Settings) {
            return;
        }

        if (!isset($widget->fields['default_project'])) {
            return;
        }

        $projectFields = [];
        $projects = collect(config('firebase.projects'))->keys();
        $configPath = plugins_path('norotaro/firebase/models/settings/project_fields.yaml');
        $fields = Yaml::parseFile($configPath);

        foreach ($projects as $p) {
            // replace project name in section label
            $fields['fields']['section']['label'] = str_replace('{project}', $p, $fields['fields']['section']['label']);
            // add fileupload field for credentials
            $fields['fields']['credentials']['form']['fields'][$p . 'Credentials'] = [
                'label' => 'File',
                'commentAbove' => "
                    <strong>Default value:</strong> <br />
                    <code>env('FIREBASE_CREDENTIALS', env('GOOGLE_APPLICATION_CREDENTIALS'))</code>
                ",
                'commentHtml' => true,
                'type' => 'fileupload',
                'mode' => 'file',
                'fileTypes' => 'json',
                'span' => 'auto',
            ];

            // add nested form for the project
            $projectFields[$p] = [
                'type' => 'nestedform',
                'usePanelStyles' => false,
                'form' => $fields,
            ];
        }

        $widget->addFields([
            'projects' => [
                'label' => 'Firebase project configurations',
                'type' => 'nestedform',
                'form' => [
                    'fields' => $projectFields,
                ],
            ],
        ]);
    }
}
