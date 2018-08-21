<?php

use aksafan\emoji\source\EmojiDetector;
use PHPUnit\Framework\TestCase;

class GetEmojiMapTest extends TestCase
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
        $emoji = $this->emoji->getEmojiMap();
        $this->assertArrayHasKey('1F63B', $emoji);
    }

    public function testEmojiWithZJW()
    {
        $emoji = $this->emoji->getEmojiMap();
        $this->assertArrayHasKey('1F468-200D-1F469-200D-1F466-200D-1F466', $emoji);
    }
}
