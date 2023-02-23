<?php

namespace Kfpl\LibraryBound;

use Illuminate\Support\Str;
use Kfpl\LibraryBound\DataTransferObject\ItemInfo;

class LibraryBoundResponse
{
    private string $errorMessage = "";
    private ?ItemInfo $item = null;

    public function __construct($response) {
        if ($response->GetBookInfoByISBNResult->Status !== "OK") {
            $this->errorMessage = $response->GetBookInfoByISBNResult->Status;
        } else {
            $this->item = new ItemInfo($response->GetBookInfoByISBNResult->BookInfo);
        }
    }

    public function get(): ?ItemInfo
    {
        return $this->item;
    }

    public function hasError(): bool
    {
        return !empty($this->errorMessage);
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}