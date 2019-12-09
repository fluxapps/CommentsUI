Comments ui

### Usage

#### Composer
First add the following to your `composer.json` file:
```json
"require": {
  "srag/commentsui": ">=0.1.0"
},
```
And run a `composer install`.

If you deliver your plugin, the plugin has it's own copy of this library and the user doesn't need to install the library.

Tip: Because of multiple autoloaders of plugins, it could be, that different versions of this library exists and suddenly your plugin use an older or a newer version of an other plugin!

So I recommand to use [srag/librariesnamespacechanger](https://packagist.org/packages/srag/librariesnamespacechanger) in your plugin.

#### Trait usage
Your class in this you want to use CommentsUI needs to use the trait `CommentsUITrait`
```php
...
use srag\CommentsUI\x\Utils\CommentsUITrait;
...
class x {
...
use CommentsUITrait;
...
```

#### Comment ActiveRecord
First you need to init the `Comment` active record class with your own table name prefix. Please add this very early in your plugin code
self::comments()->withTableNamePrefix(self::COMMENT_TABLE_NAME_PREFIX)->withPlugin(self::plugin());
```

Add an update step to your `dbupdate.php`
```php
...
<#x>
<?php
\srag\CommentsUI\x\Comment\Repository::getInstance()->installTables();
?>
```

and not forget to add an uninstaller step in your plugin class too
```php
...
self::comments()->dropTables();
...
```

#### Async ctrl class
```php
...
use srag\CommentsUI\x\Ctrl\AbstractCtrl;
...
/**
 * ...
 *
 * @ilCtrl_isCalledBy srag\Plugins\x\Comment\Ctrl\XCtrl: ilUIPluginRouterGUI
 */
class XCtrl extends AbstractCtrl {
	/**
	 * @inheritdoc
	 */
	public function getCommentsArray(int $report_obj_id, int $report_user_id): array {
		...
	}
}
```

#### Languages
Expand you plugin class for installing languages of the library to your plugin
```php
...
	/**
	 * @inheritdoc
	 */
	public function updateLanguages($a_lang_keys = null) {
		parent::updateLanguages($a_lang_keys);

		self::comments()->installLanguages();
	}
...
```

#### UI usage
```php
...
use srag\Plugins\x\Comment\Ctrl\XCtrl;
...
self::output()->getHTML(self::commentsUI()->withCtrlClass(new XCtrl()));
```

### Requirements
* ILIAS 5.3 or ILIAS 5.4
* PHP >=7.0

### Adjustment suggestions
* External users can report suggestions and bugs at https://plugins.studer-raimann.ch/goto.php?target=uihk_srsu_LCOMMENTSUI
* Adjustment suggestions by pull requests via github
* Customer of studer + raimann ag: 
	* Adjustment suggestions which are not yet worked out in detail by Jira tasks under https://jira.studer-raimann.ch/projects/LCOMMENTSUI
	* Bug reports under https://jira.studer-raimann.ch/projects/LCOMMENTSUI
