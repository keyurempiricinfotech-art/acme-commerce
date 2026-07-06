# Storefront API

Laravel 11 (PHP 8.3) backend for Acme Commerce storefront workflows. The codebase follows MVC entry points with a thin service/repository layer for business operations and persistence, Eloquent models for domain relationships, Sanctum for API authentication, and queued jobs/listeners for asynchronous work.

## Architecture

- API routes are versioned under `/api/v1`.
- Controllers live in `App\\Http\\Controllers\\Api\\V1` and return JSON resources.
- Services coordinate validation-sensitive workflows for products, carts, and orders.
- Repositories hide query details for product and order persistence.
- Product reads use cache entries keyed by product id; writes clear those keys.
- Policies protect product management and customer order access.
- Orders, carts, products, categories, addresses, and users are represented with Eloquent relationships.

## Known Analysis Hooks

- `ProductController@index` intentionally accesses category data inside a loop after loading products.
- `ProductController@show` and `ProductService` use cache keys that must be invalidated by related product changes.
- Sanctum-protected routes and policies are registered for authenticated workflows.
- Existing feature tests cover product listing and order service behavior.
