<?php

use aksafan\emoji\source\EmojiDetector;
use PHPUnit\Framework\TestCase;

class DetectAllWithSingleParamTests extends TestCase
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
        $emoji = $this->emoji->detectAllWIthSingleParam($string, EmojiDetector::EMOJI);
        $this->assertCount(1, $emoji);
        $this->assertEquals('😻', $emoji[0]);
    }

    public function testDetectEmojiWithZJW()
    {
        $string = '👨‍👩‍👦‍👦';
        $emoji = $this->emoji->detectAllWIthSingleParam($string, EmojiDetector::SHORT_NAME);
        $this->assertCount(1, $emoji);
        $this->assertEquals('man-woman-boy-boy', $emoji[0]);
    }

    public function testDetectEmojiWithZJW2()
    {
        $string = '👩‍❤️‍👩';
        $emoji = $this->emoji->detectAllWIthSingleParam($string, EmojiDetector::NUM_POINTS);
        $this->assertCount(1, $emoji);
        $this->assertEquals('6', $emoji[0]);
    }

    public function testDetectEmojiWithSkinTone()
    {
        $string = '👍🏼';
        $emoji = $this->emoji->detectAllWIthSingleParam($string, EmojiDetector::POINTS_HEX);
        $this->assertCount(1, $emoji);
        $this->assertEquals(
            [
                '1F44D',
                '1F3FC',
            ],
            $emoji[0]
        );
    }

    public function testDetectMultipleEmoji()
    {
        $string = '👍🏼️';
        $emoji = $this->emoji->detectAllWIthSingleParam($string, EmojiDetector::HEX_STR);
        $this->assertCount(1, $emoji);
        $this->assertEquals('1F44D-1F3FC', $emoji[0]);
    }

    public function testDetectFlagEmoji()
    {
        $string = '👍🏼️';
        $emoji = $this->emoji->detectAllWIthSingleParam($string, EmojiDetector::SKIN_TONE);
        $this->assertCount(1, $emoji);
        $this->assertEquals('skin-tone-3', $emoji[0]);
    }

    public function testDetectNumbers()
    {
        $string = '0️⃣5️⃣5️⃣0️⃣➖0️⃣8️⃣8️⃣9️⃣8️⃣4️⃣️';
        $emoji = $this->emoji->detectAllWIthSingleParam($string, EmojiDetector::EMOJI);
        $this->assertCount(11, $emoji);
        $this->assertEquals('0️⃣', $emoji[0]);
    }

    public function testDetectInternationalNumbers()
    {
        $string = '➕9️⃣9️⃣6️⃣ 5️⃣5️⃣1️⃣ 7️⃣7️⃣5️⃣ 2️⃣7️⃣7️⃣';
        $emoji = $this->emoji->detectAllWIthSingleParam($string, EmojiDetector::SHORT_NAME);
        $this->assertCount(13, $emoji);
        $this->assertEquals('heavy_plus_sign', $emoji[0]);
    }

    public function testDetectWithWrongParam()
    {
        $string = '➕9️⃣9️⃣6️⃣ 5️⃣5️⃣1️⃣ 7️⃣7️⃣5️⃣ 2️⃣7️⃣7️⃣';
        $emoji = $this->emoji->detectAllWIthSingleParam($string, 'Wrong param');
        $this->assertCount(0, $emoji);
        $this->assertEquals([], $emoji);
    }
}
