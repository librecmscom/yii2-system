# yii2-system


[![Build Status](https://travis-ci.org/yuncms/yii2-system.svg?branch=master)](https://travis-ci.org/yuncms/yii2-system)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require yuncms/yii2-system
```

or add

```
"yuncms/yii2-system": "~2.0.0"
```

to the `require` section of your `composer.json` file.

集成一些常用的方法和类

Add this to your main configuration's components array

```php
'components' => [
    'settings' => [
        'class' => 'yuncms\system\components\Settings'
    ],
    ...
]
```

## License

this is released under the MIT License. See the bundled [LICENSE.md](LICENSE.md)
for details.