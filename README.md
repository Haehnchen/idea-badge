espendIdeaBadge
=================
[![Total Downloads](https://poser.pugx.org/espend/idea-badge/downloads.png)](https://packagist.org/packages/espend/idea-badge)
[![Latest Stable Version](https://poser.pugx.org/espend/idea-badge/v/stable.png)](https://packagist.org/packages/espend/idea-badge)

### Install

``` bash
$ php composer.phar require espend/idea-badge
```

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new espend\IdeaBadgeBundle\espendIdeaBadgeBundle(),
    );
}
```

### Configuration

``` yaml
# app/config/routing.yml

espend_poser_extra:
    resource: .
    type: espend_idea_badge
```

## Basic Usage

``` yaml
# app/config/config.yml

espend_idea_badge:
    badge_lifetime:       3600
    route_path:           '/badges/{id}/{provider}'
    badge_controller:     'espend_idea_badge_bundle.badge.controller:showAction'
    monthly_storage_path: '%kernel.root_dir%/../var/badge_monthly_storage_path.json'
```

## Urls

```
/badge/{pluginId}/downloads
/badge/{pluginId}/last-month
/badge/{pluginId}/version
```

## Run tests

```
vendor/bin/phpunit tests/
```