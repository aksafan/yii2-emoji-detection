<?php

use aksafan\emoji\source\EmojiDetector;
use PHPUnit\Framework\TestCase;

class ReplaceEmojisTests extends TestCase
{
    /** @var $emoji EmojiDetector */
    private $emoji;

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        $this->emoji = new EmojiDetector;
        parent::__construct($name, $data, $dataName);
    }

    public function testReplaceSimpleEmoji()
    {
        $string = '😻';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('', $emoji);
    }

    public function testReplaceEmojiWithZJW()
    {
        $string = '👨‍👩‍👦‍👦';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('', $emoji);
    }

    public function testReplaceEmojiWithZJW2()
    {
        $string = '👩‍❤️‍👩';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('', $emoji);
    }

    public function testReplaceEmojiWithSkinTone()
    {
        $string = '👍🏼';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('', $emoji);
    }

    public function testReplaceMultipleEmoji()
    {
        $string = '👩❤️';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('', $emoji);
    }

    public function testReplaceFlagEmoji()
    {
        $string = '🇩🇪';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('', $emoji);
    }

    public function testReplaceSymbolWithModifier()
    {
        $string = '♻️';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('', $emoji);
    }

    public function testReplaceCharacterSymbol()
    {
        $string = '™️';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('', $emoji);
    }

    public function testReplaceEmojiWithZJW3()
    {
        $string = '🏳️‍🌈';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('', $emoji);
    }

    public function testReplaceText()
    {
        $string = 'This has no emoji.';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('This has no emoji.', $emoji);
    }

    public function testReplaceInText()
    {
        $string = 'This has an 🎉 emoji.';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('This has an  emoji.', $emoji);
    }

    public function testReplaceGenderModifier()
    {
        $string = 'guardswoman 💂‍♀️';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('guardswoman ', $emoji);
    }

    public function testReplaceGenderAndSkinToneModifier()
    {
        $string = 'guardswoman 💂🏼‍♀️';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('guardswoman ', $emoji);
    }

    public function testReplaceNumbers()
    {
        $string = '0️⃣5️⃣5️⃣0️⃣➖0️⃣8️⃣8️⃣9️⃣8️⃣4️⃣';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('', $emoji);
    }

    public function testReplaceInternationalNumbers()
    {
        $string = '➕9️⃣9️⃣6️⃣ 5️⃣5️⃣1️⃣ 7️⃣7️⃣5️⃣ 2️⃣7️⃣7️⃣';
        $emoji = $this->emoji->replaceEmojis($string);
        $this->assertEquals('   ', $emoji);
    }

    public function testReplaceInTextWithReplaceText()
    {
        $string = 'This has an 🎉 emoji.';
        $emoji = $this->emoji->replaceEmojis($string, 'Emoji replacer');
        $this->assertEquals('This has an Emoji replacer emoji.', $emoji);
    }

    public function testReplaceNumbersWithReplaceText()
    {
        $string = '0️⃣5️⃣5️⃣0️⃣➖0️⃣8️⃣8️⃣9️⃣8️⃣4️⃣';
        $emoji = $this->emoji->replaceEmojis($string, '1');
        $this->assertEquals('11111111111', $emoji);
    }
}
