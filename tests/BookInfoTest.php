<?php

namespace Kfpl\LibraryBound\Test;

use Kfpl\LibraryBound\DataTransferObject\ItemInfo;
use Kfpl\LibraryBound\LibraryBoundFacade as LibraryBound;

class BookInfoTest extends TestCase {
    public function test_can_find_good_record_with_isbn()
    {
        $result = LibraryBound::findItem('9781408855898');

        $bookInfo = new ItemInfo((object)[
            "Title" => "Harry Potter and the philosopher's stone",
            "Author" => "Rowling, J. K.",
            "ISBN" => "9781408855898",
            "Publisher" => "Raincoast Book Distribution Ltd.",
            "PublicationDate" => "2014-09-01",
            "PublicationPlace" => "Canada",
            "Edition" => "Hard Cover",
            "Availability" => "Available",
            "DiscountPrice" => 16.8,
            "ListPrice" => 24.0,
            "DiscountPercent" => 0.3,
        ]);

        $this->assertFalse($result->hasError());
        $this->assertEmpty($result->getErrorMessage());
        $this->asserTEquals($bookInfo, $result->get());
    }

    public function test_can_find_good_record_with_upc()
    {
        $result = LibraryBound::findItem('883929094806');

        $bookInfo = new ItemInfo((object)[
            "Title" => "Harry Potter and the philosopher's stone",
            "Publisher" => "Warner",
            "PublicationDate" => "1999-01-01",
            "PublicationPlace" => "California",
            "Edition" => "DVD",
            "DiscountPrice" => 24.49,
            "Availability" => "Out of Stock Indefinitely",
            "ListPrice" => 34.98,
            "DiscountPercent" => 0.3,
        ]);

        $this->assertFalse($result->hasError());
        $this->assertEmpty($result->getErrorMessage());
        $this->asserTEquals($bookInfo, $result->get());
    }

    public function test_can_return_nothing_when_provided_with_bad_data()
    {
        $result = LibraryBound::findItem('baddata');

        $this->assertTrue($result->hasError());
        $this->assertEquals("Error: 'baddata' is not a valid ISBN/UPC", $result->getErrorMessage());
        $this->assertNull($result->get());
    }
}