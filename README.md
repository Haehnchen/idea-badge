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
    cache_dir:            '%kernel.cache_dir%/poser-badges'
    route_path:           '/badges/{id}/{provider}'
    badge_controller:     'espend_idea_badge_bundle.badge.controller:showAction'
```