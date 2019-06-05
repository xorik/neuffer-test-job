<?php

use App\CsvParser;
use App\Exceptions\FileIsNotExistsException;
use App\Exceptions\OpenFileException;
use PHPUnit\Framework\TestCase;

class CsvParserTest extends TestCase
{
    /** @var CsvParser */
    private $parser;

    protected function setUp(): void
    {
        $this->parser = new CsvParser();
    }

    public function testLoadNotFound()
    {
        $this->expectException(FileIsNotExistsException::class);
        $this->expectExceptionMessage('Can\'t find file: not-exists.csv');

        $this->parser->load('not-exists.csv');
    }

    public function testLoad()
    {
        $result = $this->parser->load(__DIR__.'/test.csv');

        $this->assertCount(3, $result);
        $this->assertEquals([-97, 90], $result[0]);
        $this->assertEquals([72, -58], $result[1]);
        $this->assertEquals([-1, 10], $result[2]);
    }

    public function testSave()
    {
        $path = sys_get_temp_dir().'/test.csv';

        $this->parser->save($path, [[1, 2], [3, 4]]);
        $data = file_get_contents($path);
        unlink($path);

        $this->assertEquals("1;2\n3;4\n", $data);
    }

    public function testSaveInvalid()
    {
        $this->expectException(OpenFileException::class);
        $this->expectExceptionMessage('Error opening file: /bad/file');

        $this->parser->save('/bad/file', []);
    }
}
