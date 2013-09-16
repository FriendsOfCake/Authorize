# Authorize plugin

[![Build Status](https://travis-ci.org/FriendsOfCake/Authorize.png?branch=master)](https://travis-ci.org/FriendsOfCake/Authorize)
[![Coverage Status](https://coveralls.io/repos/FriendsOfCake/Authorize/badge.png)](https://coveralls.io/r/FriendsOfCake/Authorize)

Plugin containing some authorize classes for AuthComponent.

Current classes:
- AclAuthorize, row based Acl. AuthComponent adapter, to use together with AclBehavior created acos
- HabtmDbAcl. AclComponent adapter, for User habtm Group Acl. (for database acl only)

## Requirements

- PHP 5.2.8
- CakePHP 2.x

## Installation

_[Manual]_

- Download this: http://github.com/FriendsOfCake/Authorize/zipball/master
- Unzip that download.
- Copy the resulting folder to app/Plugin
- Rename the folder you just copied to Authorize

_[GIT Submodule]_

In your app directory type:
```
git submodule add git://github.com/FriedsOfCake/Authorize.git Plugin/Authorize
git submodule init
git submodule update
```

_[GIT Clone]_

In your plugin directory type
```
git clone git://github.com/FriendsOfCake/Authorize.git Authorize
```

## Usage

In `app/Config/bootstrap.php` add: `CakePlugin::load('Authorize');`

## Configuration AclAuthorize:

Setup the authorize class

Example:
```php
    //in $components
    public $components = array(
        'Auth' => array(
            'authorize' => array(
                'Controller',
                'Authorize.Acl' => array('actionPath' => 'Models/')
            )
        )
    );
    //Or in beforeFilter()
    $this->Auth->authorize = array(
        'Controller',
        'Authorize.Acl' => array('actionPath' => 'Models/')
    );
```
In the above example `ControllerAuthorize` is checked first. If your `Controller::isAuthorized()`
returns true on admin routing, AclAuthorize will only be checked for non-admin urls.
Also you need to set `actionPath` in a similar way which is used with Actions- and CrudAuthorize.

## Configuration HabtmDbAcl:

Setup the HabtmDbAcl adapter

in app/Config/core.php
```php
Configure::write('Acl.classname', 'Authorize.HabtmDbAcl');
```

Make sure if you need to alter settings for HabtmDbAcl, you pass those to
AclComponent ``$settings['habtm']``, and have it loaded before any Auth configuration.
```php
    //in $components
    public $components = array(
        'Acl' => array('habtm' => array(
            'userModel' => 'Users.User',
            'groupAlias' => 'Group'
        )),
        'Auth' => array(
            //your Auth settings
        )
    );
```
