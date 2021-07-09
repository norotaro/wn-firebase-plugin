# Firebase for WinterCMS

A WinterCMS plugin for the [Firebase for Laravel package](https://github.com/kreait/laravel-firebase).

- [Installation](#installation)
- [Configuration](#configuration)
  - [Service account](#service-account)
- [Usage](#usage)
- [Support](#support)
- [License](#license)

## Installation

First install the plugin with composer:
```sh
composer require norotaro/wn-firebase-plugin
```

Then run the migration files with:

```sh
php artisan winter:up
```

## Configuration

This plugin provides a web interface to configure the original Laravel package, the settings set in this form override the package settings.

You can configure the package without the web interface provided by this plugin following the [instructions of the package](https://github.com/kreait/laravel-firebase#configuration).

**Any configuration saved in the web interface will override the package configuration.**

### Service account

In order to access a Firebase project and its related services using a server SDK, requests must be authenticated. For server-to-server communication this is done with a Service Account.

If you don't already have generated a Service Account, you can do so by following the instructions from the official documentation pages at https://firebase.google.com/docs/admin/setup#initialize_the_sdk.

## Usage

As specified in the original package:

| Component | [Automatic Injection](https://laravel.com/docs/5.8/container#automatic-injection) | [Facades](https://laravel.com/docs/facades) | [`app()`](https://laravel.com/docs/helpers#method-app) |
| --- | --- | --- | --- |
| [Authentication](https://firebase-php.readthedocs.io/en/stable/authentication.html) | `\Kreait\Firebase\Auth` | `Firebase::auth()` | `app('firebase.auth')` |
| [Cloud Firestore](https://firebase-php.readthedocs.io/en/stable/cloud-firestore.html) | `\Kreait\Firebase\Firestore` | `Firebase::firestore()` | `app('firebase.firestore')` |
| [Cloud&nbsp;Messaging&nbsp;(FCM)](https://firebase-php.readthedocs.io/en/stable/cloud-messaging.html) | `\Kreait\Firebase\Messaging` | `Firebase::messaging()` | `app('firebase.messaging')` |
| [Dynamic&nbsp;Links](https://firebase-php.readthedocs.io/en/stable/dynamic-links.html) | `\Kreait\Firebase\DynamicLinks` | `Firebase::dynamicLinks()` | `app('firebase.dynamic_links')` |
| [Realtime Database](https://firebase-php.readthedocs.io/en/stable/realtime-database.html) | `\Kreait\Firebase\Database` | `Firebase::database()` | `app('firebase.database')` |
| [Remote Config](https://firebase-php.readthedocs.io/en/stable/remote-config.html) | `\Kreait\Firebase\RemoteConfig` | `Firebase::remoteConfig()` | `app('firebase.remote_config')` |
| [Cloud Storage](https://firebase-php.readthedocs.io/en/stable/cloud-storage.html) | `\Kreait\Firebase\Storage` | `Firebase::storage()` | `app('firebase.storage')` |

Once you have retrieved a component, please refer to the [documentation of the Firebase PHP Admin SDK](https://firebase-php.readthedocs.io)
for further information on how to use it.

**You don't need and should not use the `new Factory()` pattern described in the SDK documentation, this is already
done for you with the Laravel Service Provider. Use Dependency Injection, the Facades or the `app()` helper instead**

## Suport

- [Issue Tracker (WinterCMS Plugin)](https://github.com/norotaro/wn-firebase-plugin/issues/)
- [Issue Tracker (Laravel Package)](https://github.com/kreait/laravel-firebase/issues/)
- [Bug Reports (Admin SDK)](https://github.com/kreait/firebase-php/issues/)
- [Feature Requests and Discussions (Admin SDK)](https://github.com/kreait/firebase-php/discussions)
- [Stack Overflow](https://stackoverflow.com/questions/tagged/firebase+php)

## License

Firebase for WinterCMS is licensed under the [MIT License](LICENSE).

Your use of Firebase is governed by the [Terms of Service for Firebase Services](https://firebase.google.com/terms/).