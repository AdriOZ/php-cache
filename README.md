# php-cache
Little implementation of a cache system in PHP

## How to use
The class oz\Cache requires a little configuration using the oz\CacheConfiguration class. The params are:
- folder: The path where the cache files are going to be stored.
- extension: The extension the files are going to have.
- hashMethod: The names of the files are encoded to be unique. The hash method can be sha1, md5... and all methods that the function hash of PHP can use.

So, you can have multiple cache directories. The oz\CacheConfiguration class provides a simple default configuration:
- folder: /.cache
- extension: .cache
- hashMethod: sha1

After configuring the cache, it can be used as an array as it implements the ArrayAccess interface:

```php
use oz\CacheConfiguration;
use oz\Cache;

$cacheConfiguration = CacheConfiguration::getDefaultConfiguration();
$cache = new Cache($cacheConfiguration);
```

### Saving data
```php
$cache['foo_text'] = 'This is stored as text';
$cache['foo_number'] = 3000;
$cache['foo_bool'] = true;
$cache['foo_object'] = new \stdClass();
$cache['foo_array'] = array(
  'foo_1' => 'You',
  'foo_2' => 'can',
  'foo_3' => 'store',
  'foo_4' => 'the',
  'foo_5' => 'basic',
  'foo_6' => 'data',
  'foo_7' => 'types'
);
```

### Checking if a key exists
```php
isset($cache['foo_text']);  # True
isset($cache['foo_txt']);   # False
```

### Getting the data
```php
echo $cache['foo_number'];  # 3000
echo $cache['foo_text];     # 'This is stored as text'
```

### Removing data
```php
unset($cache['foo_text']);
echo $cache['foo_text'];    # Notice: ... doesn't exist
```

### That's all
Have fun ;)
