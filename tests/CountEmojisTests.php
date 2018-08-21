<?php

use aksafan\emoji\source\EmojiDetector;
use PHPUnit\Framework\TestCase;

class CountEmojisTests extends TestCase
{
    /** @var $emoji EmojiDetector */
    private $emoji;

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        $this->emoji = new EmojiDetector;
        parent::__construct($name, $data, $dataName);
    }

    public function testCountSimpleEmoji()
    {
        $string = '😻';
        $emoji = $this->emoji->countEmojis($string);
        $this->assertEquals(1, $emoji);
    }

    public function testCountEmojiWithZJW()
    {
        $string = '👨‍👩‍👦‍👦';
        $emoji = $this->emoji->countEmojis($string);
        $this->assertEquals(1, $emoji);
    }

    public function testCountEmojiWithZJW2()
    {
        $string = '👩‍❤️‍👩';
        $emoji = $this->emoji->countEmojis($string);
        $this->assertEquals(1, $emoji);
    }

    public function testCountEmojiWithSkinTone()
    {
        $string = '👍🏼';
        $emoji = $this->emoji->countEmojis($string);
        $this->assertEquals(1, $emoji);
    }

    public function testCountMultipleEmoji()
    {
        $string = '👩❤️';
        $emoji = $this->emoji->countEmojis($string);
        $this->assertEquals(2, $emoji);
    }

    public function testCountFlagEmoji()
    {
        $string = '🇩🇪';
        $emoji = $this->emoji->countEmojis($string);
        $this->assertEquals(1, $emoji);
    }
    
    public function testCountText()
    {
        $string = 'This has no emoji.';
        $emoji = $this->emoji->countEmojis($string);
        $this->assertEquals(0, $emoji);
    }

    public function testCountInText()
    {
        $string = 'This has an 🎉 emoji.';
        $emoji = $this->emoji->countEmojis($string);
        $this->assertEquals(1, $emoji);
    }

    public function testCountNumbers()
    {
        $string = '0️⃣5️⃣5️⃣0️⃣➖0️⃣8️⃣8️⃣9️⃣8️⃣4️⃣️';
        $emoji = $this->emoji->countEmojis($string);
        $this->assertEquals(11, $emoji);
    }

    public function testCountInternationalNumbers()
    {
        $string = '➕9️⃣9️⃣6️⃣ 5️⃣5️⃣1️⃣ 7️⃣7️⃣5️⃣ 2️⃣7️⃣7️⃣';
        $emoji = $this->emoji->countEmojis($string);
        $this->assertEquals(13, $emoji);
    }
}
