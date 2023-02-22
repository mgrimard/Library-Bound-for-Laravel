<?php

namespace Kfpl\LibraryBound\Test;

use Kfpl\LibraryBound\DataTransferObject\ItemInfo;
use Kfpl\LibraryBound\LibraryBoundClient;
use Kfpl\LibraryBound\LibraryBoundFacade as LibraryBound;
use Kfpl\LibraryBound\LibraryBoundResponse;
use SoapClient;

class ItemInfoTest extends TestCase {
    public function test_can_find_good_record_with_isbn()
    {
        $mock = $this->mock(SoapClient::class);
        $mock->expects('GetBookInfoByISBN')
            ->with(['ISBN' => '9781408855898', 'LoginName' => '', 'LoginPassword' => ''])
            ->andReturn((object) [
                'GetBookInfoByISBNResult' => (object) [
                    'Status' => '',
                    'BookInfo' => (object) [
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
                    ]
                ]
            ])
            ->getMock();

        $client = new LibraryBoundClient($mock, '', '');
        $result = $client->findItem('9781408855898');

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
        $this->assertEquals($bookInfo, $result->get());
    }

    public function test_can_find_good_record_with_upc()
    {
        $mock = $this->mock(SoapClient::class);
        $mock->expects('GetBookInfoByISBN')
            ->with(['ISBN' => '883929094806', 'LoginName' => '', 'LoginPassword' => ''])
            ->andReturn((object) [
                'GetBookInfoByISBNResult' => (object) [
                    'Status' => '',
                    'BookInfo' => (object) [
                        "Title" => "Harry Potter and the philosopher's stone",
                        "Publisher" => "Warner",
                        "PublicationDate" => "1999-01-01",
                        "PublicationPlace" => "California",
                        "Edition" => "DVD",
                        "DiscountPrice" => 24.49,
                        "Availability" => "Out of Stock Indefinitely",
                        "ListPrice" => 34.98,
                        "DiscountPercent" => 0.3,
                    ]
                ]
            ])
        ->getMock();

        $client = new LibraryBoundClient($mock, '', '');
        $result = $client->findItem('883929094806');

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
        $this->assertEquals($bookInfo, $result->get());
    }

    public function test_returns_error_when_provided_with_bad_data()
    {
        $mock = $this->mock(SoapClient::class);
        $mock->expects('GetBookInfoByISBN')
            ->with(['ISBN' => 'baddata', 'LoginName' => '', 'LoginPassword' => ''])
            ->andReturn((object) [
                'GetBookInfoByISBNResult' => (object) [
                    'Status' => "Error: 'baddata' is not a valid ISBN/UPC",
                ]
            ])
            ->getMock();

        $client = new LibraryBoundClient($mock, '', '');
        $result = $client->findItem('baddata');

        $this->assertTrue($result->hasError());
        $this->assertEquals("Error: 'baddata' is not a valid ISBN/UPC", $result->getErrorMessage());
        $this->assertNull($result->get());
    }

    public function test_returns_error_when_provided_with_invalid_credentials()
    {
        $mock = $this->mock(SoapClient::class);
        $mock->expects('GetBookInfoByISBN')
            ->with(['ISBN' => 'baddata', 'LoginName' => '', 'LoginPassword' => ''])
            ->andReturn((object) [
                'GetBookInfoByISBNResult' => (object) [
                    'Status' => "Error: login name 'https://prod.librarybound.com/vip/services/BookInfoPort' is not a username for LBI's system",
                ]
            ])
            ->getMock();

        $client = new LibraryBoundClient($mock, '', '');
        $result = $client->findItem('baddata');

        $this->assertTrue($result->hasError());
        $this->assertEquals("Error: login name 'https://prod.librarybound.com/vip/services/BookInfoPort' is not a username for LBI's system", $result->getErrorMessage());
        $this->assertNull($result->get());
    }
}