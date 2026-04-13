## Breaking changes

- minimum PHP version is now `7.0`
- runtime Guzzle dependency removed
- legacy helper methods were removed in favor of fluent resources
- sandbox no longer falls back to the old hardcoded Apiary mock URL
- HTTP 4xx and 5xx responses now raise package exceptions

Main replacements:

- `simpleQuotes()` -> `quotes()->create()`
- `createBooking()` -> `bookings()->create()`
- `getSingleBooking()` -> `bookings()->find()`
- `confirmBooking()` -> `bookings()->action($id, 'confirm', $payload)`
- `createOrder()` -> `orders()->create()`
- `searchLocations()` -> `locations()->get(['q' => ...])`
- `getByPostcode()` -> `postcode()`
- `frequent-rates` -> `frequentRates()->get()`
