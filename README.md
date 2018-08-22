# yii2-emoji-detection
Yii2 wrapper for aaronpk's Emoji Detection (https://github.com/aaronpk/emoji-detector-php).
The library provides all aaronpk's Emoji Detection tools and features with various enhancements and Yii2 syntax.


[![Latest Stable Version](https://poser.pugx.org/aksafan/yii2-emoji-detection/v/stable)](https://packagist.org/packages/aksafan/yii2-emoji-detection)
[![Total Downloads](https://poser.pugx.org/aksafan/yii2-emoji-detection/downloads)](https://packagist.org/packages/aksafan/yii2-emoji-detection)
[![Build Status](https://travis-ci.org/aksafan/yii2-emoji-detection.svg?branch=master)](https://travis-ci.org/aksafan/yii2-emoji-detection)

# Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/). Check the [composer.json](https://github.com/aksafan/yii2-emoji-detection/blob/master/composer.json) for this extension's requirements and dependencies. Read this [composer.json](https://github.com/aaronpk/emoji-detector-php/blob/master/composer.json) for source library requirements.

To install, either run

```
$ php composer.phar require aksafan/yii2-emoji-detection
```

or add

```
"aksafan/yii2-emoji-detection": "*"
```

to the `require` section of your `composer.json` file.


Configuration
-------------

To use this extension, you have to configure the EmojiDetector class in your application configuration:

```php
return [
    //....
    'components' => [
        'emojiDetector' => [
             'class' => 'aksafan\emoji\source\EmojiDetector\EmojiDetector',
        ],
    ]
];
```

Also add this to your Yii.php file in the root directory of the project for IDE code autocompletion.

```php
/**
 * Class WebApplication
 * Include only Web application related components here.
 *
 * @property \aksafan\emoji\source\EmojiDetector $emojiDetector
 */
class WebApplication extends yii\web\Application
{
}
```

Now u can get access to extension's methods through:

```php
Yii::$app->emojiDetector
```


Basic Usage
-----------

### Detect Emoji

```php
$input = "Hello 👍🏼 World 👨‍👩‍👦‍👦";
$emoji = Yii::$app->emojiDetector->detectAll($input);

print_r($emoji);
```

The method returns an array with details about each emoji found in the string.

```
Array
(
  [0] => Array
    (
      [emoji] => 👨‍👩‍👦‍👦
      [short_name] => man-woman-boy-boy
      [num_points] => 7
      [points_hex] => Array
        (
          [0] => 1F468
          [1] => 200D
          [2] => 1F469
          [3] => 200D
          [4] => 1F466
          [5] => 200D
          [6] => 1F466
        )
      [hex_str] => 1F468-200D-1F469-200D-1F466-200D-1F466
      [skin_tone] =>
    )
  [1] => Array
    (
      [emoji] => 👍🏼
      [short_name] => +1
      [num_points] => 2
      [points_hex] => Array
        (
          [0] => 1F44D
          [1] => 1F3FC
        )

      [hex_str] => 1F44D-1F3FC
      [skin_tone] => skin-tone-3
    )
)
```

* `emoji` - The emoji sequence found, as the original byte sequence. You can output this to show the original emoji.
* `short_name` - The short name of the emoji, as defined by [Slack's emoji data](https://github.com/iamcal/emoji-data).
* `num_points` - The number of unicode code points that this emoji is composed of.
* `points_hex` - An array of each unicode code point that makes up this emoji. These are returned as hex strings. This will also include "invisible" characters such as the ZWJ character and skin tone modifiers.
* `hex_str` - A list of all unicode code points in their hex form separated by hyphens. This string is present in the [Slack emoji data](https://github.com/iamcal/emoji-data) array.
* `skin_tone` - If a skin tone modifier was used in the emoji, this field indicates which skin tone, since the `short_name` will not include the skin tone.


### Detect Emoji and return only one specific param

```php
$input = "Hello 👍🏼 World 👨‍👩‍👦‍👦";
$emoji = Yii::$app->emojiDetector->detectAllWIthSingleParam($input, aksafan\emoji\source\EmojiDetector::EMOJI);

print_r($emoji);
```

The method returns an array with details about each emoji found in the string.

```
Array
(
  [0] => Array
    (
      👨‍👩‍👦‍👦
    )
  [1] => Array
    (
      👍🏼
    )
)
```

```php
$input = "Hello 👍🏼 World 👨‍👩‍👦‍👦";
$emoji = Yii::$app->emojiDetector->detectAllWIthSingleParam($input, aksafan\emoji\source\EmojiDetector::SHORT_NAME);

print_r($emoji);
```

```
Array
(
  [0] => Array
    (
      man-woman-boy-boy
    )
  [1] => Array
    (
      +1
    )
)
```

Possible params:
* `aksafan\emoji\source\EmojiDetector::EMOJI` - The emoji sequence found, as the original byte sequence. You can output this to show the original emoji.
* `aksafan\emoji\source\EmojiDetector::SHORT_NAME` - The short name of the emoji, as defined by [Slack's emoji data](https://github.com/iamcal/emoji-data).
* `aksafan\emoji\source\EmojiDetector::NUM_POINTS` - The number of unicode code points that this emoji is composed of.
* `aksafan\emoji\source\EmojiDetector::POINTS_HEX` - An array of each unicode code point that makes up this emoji. These are returned as hex strings. This will also include "invisible" characters such as the ZWJ character and skin tone modifiers.
* `aksafan\emoji\source\EmojiDetector::HEX_STR` - A list of all unicode code points in their hex form separated by hyphens. This string is present in the [Slack emoji data](https://github.com/iamcal/emoji-data) array.
* `aksafan\emoji\source\EmojiDetector::SKIN_TONE` - If a skin tone modifier was used in the emoji, this field indicates which skin tone, since the `short_name` will not include the skin tone.



### Replace Emoji with given replacer

```php
$input = "Hello 👍🏼 World 👨‍👩‍👦‍👦";
$emoji = Yii::$app->emojiDetector->replaceEmojis($input); //Default replacer is ''
// "Hello  World "
```

```php
$input = "Hello 👍🏼 World 👨‍👩‍👦‍👦";
$emoji = Yii::$app->emojiDetector->replaceEmojis($input, '1');
// "Hello 1 World 1"
```

```php
$input = "0️⃣5️⃣5️⃣0️⃣";
$emoji = Yii::$app->emojiDetector->replaceEmojis($input, '2');
// "2222"
```


### Count Emojis in text

```php
$input = "Hello 👍🏼 World 👨‍👩‍👦‍👦";
$emoji = Yii::$app->emojiDetector->countEmojis($input);
// 2
```

```php
$input = "0️⃣5️⃣5️⃣0️⃣";
$emoji = Yii::$app->emojiDetector->countEmojis($input);
// 4
```


### Test if a string is a single emoji

Since simply counting the number of unicode characters in a string does not tell you how many visible emoji are in the string, determining whether a single character is an emoji is more involved.

```php
$emoji = Yii::$app->emojiDetector->isSingleEmoji('👨‍👩‍👦‍👦');
// true
```

```php
$emoji =Yii::$app->emojiDetector->isSingleEmoji('Emoji with text 👨‍👩‍👦‍👦');
// false
```

```php
$emoji =Yii::$app->emojiDetector->isSingleEmoji('😻🐈');
// false
```


### Test if a string has one or more emoji

```php
$emoji = Yii::$app->emojiDetector->isEmoji('👨‍👩‍👦‍👦');
// true
```

```php
$emoji =Yii::$app->emojiDetector->isEmoji('Emoji with text 👨‍👩‍👦‍👦');
// true
```

```php
$emoji =Yii::$app->emojiDetector->isEmoji('😻🐈');
// true
```

```php
$emoji =Yii::$app->emojiDetector->isEmoji('Just text');
// false
```


### Get Emojis' map

```php
$emoji = Yii::$app->emojiDetector->getEmojiMap();

print_r($emoji);
```

The method returns an array of key-values pairs of emoji hex unicode and its short (friendly) name.

```
Array
(
  [0023-FE0F-20E3] => hash
  [002A-FE0F-20E3] => keycap_star
  [0030-FE0F-20E3] => zero
  [0031-FE0F-20E3] => one
  [0032-FE0F-20E3] => two
  [0033-FE0F-20E3] => three
  [0034-FE0F-20E3] => four
  [0035-FE0F-20E3] => five
  ...
  [2B55] => o
  [3030-FE0F] => wavy_dash
  [303D-FE0F] => part_alternation_mark
  [3297-FE0F] => congratulations
  [3299-FE0F] => secret
)
```


### Get Emojis' regexp. The method returns a string with regexp (build on emojis' map) to detect emojis

```php
$emoji = Yii::$app->emojiDetector->getEmojiRegexp();
// "/(?:\x{1F468}\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F468}|\x{1F469}\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F469}|\x{1F469}\x{200D}\x{2764}\x{FE0F}\x{200D}\x{1F48B}\x{200D}\x{1F468}|\x{1F3F4}\x{E0067}\x{E0062}\x{E0073}\x{E0063}\x{E0074}\x{E007F}|\x{1F3F4}\x{E0067}\x{E0062}\x{E0065}\x{E006E}\x{E0067}\x{E007F}|\x{1F3F4}\x{E0067}\x{E0062}\x{E0077}\x{E006C}\x{E0073}\x{E007F}...)"
```


License
-------

Copyright 2018 by Anton Khainak.

Available under the MIT license.

Emoji Detection data sourced from [aaronpk/emoji-detector-php](https://github.com/aaronpk/emoji-detector-php) under the MIT license.