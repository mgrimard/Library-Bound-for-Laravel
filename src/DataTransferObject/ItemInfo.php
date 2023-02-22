<?php

namespace Kfpl\LibraryBound\DataTransferObject;

use stdClass;

class ItemInfo
{
    public string $title;
    public string $author;
    public string $isbn;
    public string $publisher;
    public string $publicationDate;
    public string $publicationPlace;
    public string $edition;
    public string $availability;
    public float $discountPrice;
    public float $listPrice;
    public float $discountPercent;

    public function __construct(StdClass $response) {
        $this->title = $response->Title ?? "";
        $this->author = $response->Author ?? "";
        $this->isbn = $response->ISBN ?? "";
        $this->publisher = $response->Publisher ?? "";
        $this->publicationDate = $response->PublicationDate ?? "";
        $this->publicationPlace = $response->PublicationPlace ?? "";
        $this->edition = $response->Edition ?? "";
        $this->availability = $response->Availability ?? "";
        $this->discountPrice = $response->DiscountPrice;
        $this->listPrice = $response->ListPrice;
        $this->discountPercent = $response->DiscountPercent;
    }
}