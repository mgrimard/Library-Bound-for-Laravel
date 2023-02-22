<?php

namespace Kfpl\LibraryBound;

use Illuminate\Support\Facades\Facade;

class LibraryBoundFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'librarybound';
    }
}
