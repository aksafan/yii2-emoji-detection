<?php

use aksafan\emoji\source\EmojiDetector;
use PHPUnit\Framework\TestCase;

class IsEmojiTest extends TestCase
{
    /** @var $emoji EmojiDetector */
    private $emoji;

    public function __construct(string $name = null, array $data = [], string $dataName = '')
    {
        $this->emoji = new EmojiDetector;
        parent::__construct($name, $data, $dataName);
    }

    public function testSingleEmoji()
    {
        $string = '😻';
        $emoji = $this->emoji->isEmoji($string);
        $this->assertEquals(true, $emoji);
    }

    public function testSingleCompositeEmoji()
    {
        $string = '👨‍👩‍👦‍👦';
        $emoji = $this->emoji->isEmoji($string);
        $this->assertEquals(true, $emoji);
    }

    public function testMultipleEmoji()
    {
        $string = '😻🐈';
        $emoji = $this->emoji->isEmoji($string);
        $this->assertEquals(true, $emoji);
    }

    public function testSingleEmojiWithText()
    {
        $string = 'kitty 😻';
        $emoji = $this->emoji->isEmoji($string);
        $this->assertEquals(true, $emoji);
    }


    public function testSingleNumberEmoji()
    {
        $string = '7️⃣';
        $emoji = $this->emoji->isEmoji($string);
        $this->assertEquals(true, $emoji);
    }

    public function testSingleNumberEmojiWithText()
    {
        $string = 'number 7️⃣️⃣';
        $emoji = $this->emoji->isEmoji($string);
        $this->assertEquals(true, $emoji);
    }

    public function testMultiplyNumberEmoji()
    {
        $string = '7️⃣5️⃣ 2️⃣7️⃣7️⃣';
        $emoji = $this->emoji->isEmoji($string);
        $this->assertEquals(true, $emoji);
    }

    public function testMultiplyNumberEmojiWithText()
    {
        $string = 'number 7️⃣5️⃣ 2️⃣7️⃣7️⃣';
        $emoji = $this->emoji->isEmoji($string);
        $this->assertEquals(true, $emoji);
    }

    public function testWithoutEmojiWithText()
    {
        $string = 'number';
        $emoji = $this->emoji->isEmoji($string);
        $this->assertEquals(false, $emoji);
    }
}
