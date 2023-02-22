# Library-Bound-for-Laravel

Use with `$result = LibraryBound::findItem(String $isbnOrUPC)`

If  there is an error, you can check with `$result->hasError()` and get the specific message with `$result->getErrorMessage()`.

If no error, then you can retrieve the item details with `$result->get()`, during an error this will return null.
