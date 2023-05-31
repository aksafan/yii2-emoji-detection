<?php

namespace aksafan\emoji\source;

use function array_key_exists;
use function count;
use function in_array;
use function is_string;

class EmojiDetector
{
    public const EMOJI = 'emoji';
    public const SHORT_NAME = 'short_name';
    public const NUM_POINTS = 'num_points';
    public const POINTS_HEX = 'points_hex';
    public const HEX_STR = 'hex_str';
    public const SKIN_TONE = 'skin_tone';
    private const PARAMS = [
        self::EMOJI,
        self::SHORT_NAME,
        self::NUM_POINTS,
        self::POINTS_HEX,
        self::HEX_STR,
        self::SKIN_TONE,
    ];

    private EmojiWrapper $emojiService;

    public function __construct()
    {
        $this->emojiService = new EmojiWrapper();
    }

    /**
     * Detects all emojis in the given string and returns all details about them.
     *
     * @param string $string String to check for emoji
     *
     * @return array With details about each emoji found in the given string. An empty array will be returned in order of error
     */
    public function detectAll(string $string): array
    {
        return $this->emojiService->detectEmoji($string);
    }

    /**
     * Detects all emojis in the given string and returns given param about these emojis.
     * Possible params are: emoji, short_name, num_points, points_hex, hex_str, skin_tone.
     * They are in class constants.
     *
     * @param string $string String to check for emoji
     * @param string $param Param which should be returned for every emoji
     *
     * @return array Param value about each emoji found in the given string. An empty array will be returned in order of error
     */
    public function detectAllWIthSingleParam(string $string, string $param): array
    {
        $result = [];
        if (!in_array($param, self::PARAMS, true) || empty($emojis = $this->detectAll($string))) {
            return $result;
        }

        foreach ($emojis as $emoji) {
            if (array_key_exists($param, $emoji)) {
                $result[] = $emoji[$param];
            }
        }

        return $result;
    }

    /**
     * Replaces all emojis found in given string. For default, replaces with an empty string.
     *
     * @param string $string String to check for emoji
     * @param string $replace The replacement value that replaces found search values. An empty string for default
     *
     * @return string The string with the replaced values. The given string will be returned in order of error
     */
    public function replaceEmojis(string $string, string $replace = ''): string
    {
        if (empty($emojis = $this->detectAll($string))) {
            return $string;
        }

        $stringToChange = $string;
        foreach ($emojis as $emoji) {
            if (array_key_exists('emoji', $emoji)) {
                $stringToChange = str_replace($emoji['emoji'], $replace, $stringToChange);
            }
        }

        return is_string($stringToChange) ? $stringToChange : $string;
    }

    /**
     * Returns emojis amount found in given string.
     *
     * @param string $string String to check for emoji
     *
     * @return int Amount of emojis in the given string
     */
    public function countEmojis(string $string): int
    {
        return count($this->detectAll($string));
    }

    /**
     * Returns boolean whether given string has one or more emoji, or doesn't have at all.
     *
     * @param string $string String to check for emoji
     *
     * @return bool Whether given string has one or more emoji, or doesn't have at all
     */
    public function isEmoji(string $string): bool
    {
        return (bool) $this->detectAll($string);
    }

    /**
     * Returns boolean whether given string has just one simple emoji at all or not.
     *
     * @param string $string String to check for emoji
     *
     * @return bool True - if string is consist of one single emoji character, False - if string has 0 emoji, or more than 1 emoji, or 1 emoji and additional text
     */
    public function isSingleEmoji(string $string): bool
    {
        return (bool) $this->emojiService->isSingleEmoji($string);
    }

    /**
     * Returns the mapping array of emoji hex unicode code point lists to short names.
     * Source - Slack's emoji.json.
     * Can be found here - https://raw.githubusercontent.com/iamcal/emoji-data/master/emoji_pretty.json
     *
     * @return array Key-values pairs of emoji hex unicode and its short (friendly) name. Empty array will be returned in order of error.
     */
    public function getEmojiMap(): array
    {
        return $this->emojiService->loadMap();
    }

    /**
     * Returns regexp (based on emoji hex unicodes) for detecting emoji.
     *
     * @return string Regexp to detect emoji from. Empty string will be returned in order of error.
     */
    public function getEmojiRegexp(): string
    {
        return $this->emojiService->loadRegexp();
    }
}
