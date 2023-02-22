<?php

namespace Kfpl\LibraryBound;

use SoapClient;
use SoapFault;
use stdClass;

class LibraryBoundClient
{
    private const BOOK_INFO_ACTION = 'GetBookInfoByISBN';

    public function __construct(private readonly SoapClient $soapClient, private readonly string $user, private readonly string $password)
    {
        //
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
    private function get(string $function, array $parameters): StdClass
    {
        return $this->soapClient->{$function}($parameters + [
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
    public function findItem(string $identifier): LibraryBoundResponse
    {
        return new LibraryBoundResponse($this->get(self::BOOK_INFO_ACTION, [
            'ISBN' => $identifier,
        ]));
    }
}
