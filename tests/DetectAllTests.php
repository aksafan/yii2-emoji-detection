<?php

use aksafan\emoji\source\EmojiDetector;
use PHPUnit\Framework\TestCase;

/**
 * Source library unit tests with yii2 wrapper, plus additional tests
 */
class DetectAllTests extends TestCase
{
    /** @var $emoji EmojiDetector */
    private $emoji;

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        $this->emoji = new EmojiDetector;
        parent::__construct($name, $data, $dataName);
    }

    public function testDetectSimpleEmoji()
    {
        $string = '😻';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(1, $emoji);
        $this->assertEquals('😻', $emoji[0]['emoji']);
        $this->assertEquals('heart_eyes_cat', $emoji[0]['short_name']);
        $this->assertEquals('1F63B', $emoji[0]['hex_str']);
    }

    public function testDetectEmojiWithZJW()
    {
        $string = '👨‍👩‍👦‍👦';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(1, $emoji);
        $this->assertEquals('man-woman-boy-boy', $emoji[0]['short_name']);
        $this->assertEquals('1F468-200D-1F469-200D-1F466-200D-1F466', $emoji[0]['hex_str']);
    }

    public function testDetectEmojiWithZJW2()
    {
        $string = '👩‍❤️‍👩';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(1, $emoji);
        $this->assertEquals('woman-heart-woman', $emoji[0]['short_name']);
        $this->assertEquals('1F469-200D-2764-FE0F-200D-1F469', $emoji[0]['hex_str']);
    }

    public function testDetectEmojiWithSkinTone()
    {
        $string = '👍🏼';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(1, $emoji);
        $this->assertEquals('👍🏼', $emoji[0]['emoji']);
        $this->assertEquals('+1', $emoji[0]['short_name']);
        $this->assertEquals('1F44D-1F3FC', $emoji[0]['hex_str']);
        $this->assertEquals('skin-tone-3', $emoji[0]['skin_tone']);
    }

    public function testDetectMultipleEmoji()
    {
        $string = '👩❤️';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(2, $emoji);
        $this->assertEquals('woman', $emoji[0]['short_name']);
        $this->assertEquals('heart', $emoji[1]['short_name']);
    }

    public function testDetectFlagEmoji()
    {
        $string = '🇩🇪';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(1, $emoji);
        $this->assertEquals('flag-de', $emoji[0]['short_name']);
    }

    public function testDetectSymbolWithModifier()
    {
        $string = '♻️';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(1, $emoji);
        $this->assertEquals('recycle', $emoji[0]['short_name']);
    }

    public function testDetectCharacterSymbol()
    {
        $string = '™️';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(1, $emoji);
        $this->assertEquals('tm', $emoji[0]['short_name']);
    }

    public function testDetectEmojiWithZJW3()
    {
        $string = '🏳️‍🌈';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(1, $emoji);
        $this->assertEquals('rainbow-flag', $emoji[0]['short_name']);
        $this->assertEquals('1F3F3-FE0F-200D-1F308', $emoji[0]['hex_str']);
    }

    public function testDetectText()
    {
        $string = 'This has no emoji.';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(0, $emoji);
    }

    public function testDetectInText()
    {
        $string = 'This has an 🎉 emoji.';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(1, $emoji);
        $this->assertEquals('tada', $emoji[0]['short_name']);
    }

    public function testDetectGenderModifier()
    {
        // Added in June 2017 http://www.unicode.org/Public/emoji/5.0/emoji-test.txt
        $string = 'guardswoman 💂‍♀️';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(1, $emoji);
        $this->assertEquals('female-guard', $emoji[0]['short_name']);
    }

    public function testDetectGenderAndSkinToneModifier()
    {
        // Added in June 2017 http://www.unicode.org/Public/emoji/5.0/emoji-test.txt
        $string = 'guardswoman 💂🏼‍♀️';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(1, $emoji);
        $this->assertEquals('female-guard', $emoji[0]['short_name']);
    }

    public function testDetectNumbers()
    {
        $string = '0️⃣5️⃣5️⃣0️⃣➖0️⃣8️⃣8️⃣9️⃣8️⃣4️⃣️';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(11, $emoji);
        $this->assertEquals(null, $emoji[0]['short_name']);
    }

    public function testDetectInternationalNumbers()
    {
        $string = '➕9️⃣9️⃣6️⃣ 5️⃣5️⃣1️⃣ 7️⃣7️⃣5️⃣ 2️⃣7️⃣7️⃣';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(13, $emoji);
        $this->assertEquals('heavy_plus_sign', $emoji[0]['short_name']);
    }

    public function testDetectMechanicalArmEmoji()
    {
        // Added in Jan 2020 https://www.unicode.org/Public/emoji/13.0/emoji-test.txt
        $string = '🦾';
        $emoji = $this->emoji->detectAll($string);
        $this->assertCount(1, $emoji);
        $this->assertSame('mechanical_arm', $emoji[0]['short_name']);
    }
}
