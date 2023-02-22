<?php

namespace Kfpl\LibraryBound;

use SoapClient;
use SoapFault;

class LibraryBoundClient
{
    private const BOOK_INFO_SERVICE = 'BookInfoPort';
    private const BOOK_INFO_ACTION = 'GetBookInfoByISBN';

    public function __construct(private string $url, private readonly string $user, private readonly string $password)
    {
        $this->url = $url . '/' . self::BOOK_INFO_SERVICE;
    }

    /**
     * Generates the WSDL from the url.
     */
    private function wsdl(): string
    {
        return $this->url . '?wsdl';
    }

    /**
     * Make the SoapClient request to the function using provided parameters.
     *
     *
     * @throws SoapFault
     */
    private function get($function, $parameters): SoapClient
    {
        return (new SoapClient($this->wsdl()))->{$function}($parameters + [
            'LoginName' => $this->user,
            'LoginPassword' => $this->password,
        ]);
    }

    /**
     * Get Book Info from an identifier (ISBN, UPC).
     *
     *
     * @throws SoapFault
     */
    public function bookInfo(string $identifier): SoapClient
    {
        return $this->get(self::BOOK_INFO_ACTION, [
            'ISBN' => $identifier,
        ]);
    }
}
