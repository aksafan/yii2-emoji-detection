<?php

namespace aksafan\emoji\source;

use function Emoji\_load_map;
use function Emoji\_load_regexp;
use function Emoji\detect_emoji;
use function Emoji\is_single_emoji;
use function Emoji\replace_emoji;
use function is_array;
use function is_string;

class EmojiWrapper
{
    private static array $map = [];

    private static string $regexp = '';

    public function __construct()
    {
        if (! self::$map) {
            self::$map = $this->loadMap();
        }
        if (! self::$regexp) {
            self::$regexp = $this->loadRegexp();
        }
    }

    public function detectEmoji(string $string): array
    {
        return detect_emoji($string);
    }

    public function isSingleEmoji(string $string)
    {
        return is_single_emoji($string);
    }

    public function replaceEmoji(string $string)
    {
        return replace_emoji($string);
    }

    /**
     * Returns array of emoji's data
     *
     * @return array
     */
    public function loadMap(): array
    {
        $map = _load_map();

        return is_array($map) ? $map : [];
    }

    /**
     * Returns reg exp to detect emoji
     *
     * @return string
     */
    public function loadRegexp(): string
    {
        $regexp =  _load_regexp();

        return is_string($regexp) ? $regexp : '';
    }
}
