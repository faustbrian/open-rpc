## Table of Contents

1. [Overview](#doc-docs-readme) (`docs/README.md`)
2. [Content Descriptors](#doc-docs-content-descriptors) (`docs/content-descriptors.md`)
3. [Schemas](#doc-docs-schemas) (`docs/schemas.md`)
4. [Value Objects](#doc-docs-value-objects) (`docs/value-objects.md`)
<a id="doc-docs-readme"></a>

## Installation

Install via Composer:

```bash
composer require cline/open-rpc
```

## What is OpenRPC?

OpenRPC is a specification for describing JSON-RPC 2.0 APIs in a machine-readable format. Think of it as OpenAPI/Swagger for JSON-RPC. This package provides:

- **Complete value objects** for all OpenRPC specification components
- **Content descriptors** for common API patterns (pagination, filtering, sorting)
- **JSON Schema integration** for parameter and result validation
- **Spatie Laravel Data** integration for type-safe serialization

## Quick Start

### Create an OpenRPC Document

```php
<?php

use Cline\OpenRpc\ValueObject\DocumentValue;
use Cline\OpenRpc\ValueObject\InfoValue;
use Cline\OpenRpc\ValueObject\MethodValue;
use Cline\OpenRpc\ValueObject\ContentDescriptorValue;
use Spatie\LaravelData\DataCollection;

// Create API info
$info = new InfoValue(
    title: 'My API',
    description: 'A sample JSON-RPC API',
    termsOfService: 'https://example.com/tos',
    contact: null,
    license: null,
    version: '1.0.0',
);

// Define a method
$method = new MethodValue(
    name: 'user.get',
    tags: null,
    summary: 'Get a user by ID',
    description: 'Returns a user object for the given ID',
    externalDocs: null,
    params: new DataCollection(ContentDescriptorValue::class, [
        new ContentDescriptorValue(
            name: 'userId',
            summary: 'The user ID',
            description: null,
            required: true,
            schema: ['type' => 'integer', 'minimum' => 1],
            deprecated: false,
        ),
    ]),
    result: new ContentDescriptorValue(
        name: 'user',
        summary: 'The user object',
        description: null,
        required: true,
        schema: [
            'type' => 'object',
            'properties' => [
                'id' => ['type' => 'integer'],
                'name' => ['type' => 'string'],
                'email' => ['type' => 'string', 'format' => 'email'],
            ],
        ],
        deprecated: false,
    ),
    deprecated: false,
    servers: null,
    errors: null,
    links: null,
    paramStructure: null,
    examples: null,
);

// Create the document
$document = new DocumentValue(
    openrpc: '1.2.6',
    info: $info,
    servers: null,
    methods: new DataCollection(MethodValue::class, [$method]),
    components: null,
    externalDocs: null,
);

// Serialize to array/JSON
$spec = $document->toArray();
```

### Add Server Configuration

```php
use Cline\OpenRpc\ValueObject\ServerValue;
use Cline\OpenRpc\ValueObject\ServerVariableValue;
use Spatie\LaravelData\DataCollection;

$servers = new DataCollection(ServerValue::class, [
    new ServerValue(
        name: 'Production',
        url: 'https://api.example.com/rpc',
        summary: 'Production API server',
        description: null,
        variables: null,
    ),
    new ServerValue(
        name: 'Development',
        url: 'http://localhost:8080/rpc',
        summary: 'Local development server',
        description: null,
        variables: null,
    ),
]);

$document = new DocumentValue(
    openrpc: '1.2.6',
    info: $info,
    servers: $servers,
    methods: $methods,
    components: null,
    externalDocs: null,
);
```

## Specification Version

The `openrpc` field specifies which version of the OpenRPC specification your document conforms to. Current versions:

- `1.2.6` - Latest stable version
- `1.2.5`, `1.2.4`, etc. - Previous versions

## Value Objects

All OpenRPC specification components are represented as immutable value objects:

| Value Object | Description |
|-------------|-------------|
| `DocumentValue` | Root document container |
| `InfoValue` | API metadata (title, version, description) |
| `MethodValue` | RPC method definition |
| `ContentDescriptorValue` | Parameter/result schema |
| `ServerValue` | Server endpoint configuration |
| `ErrorValue` | Error response definition |
| `ComponentsValue` | Reusable components container |
| `ExampleValue` | Sample values |
| `ExamplePairingValue` | Request/response pairs |
| `TagValue` | Method categorization |
| `LinkValue` | Related resources |

## Next Steps

- **[Value Objects](value-objects)** - Complete API reference for all value objects
- **[Content Descriptors](content-descriptors)** - Pre-built descriptors for pagination, filtering, and sorting
- **[Schemas](schemas)** - Reusable JSON Schema definitions

<a id="doc-docs-content-descriptors"></a>

Content descriptors define the structure and metadata for method parameters and results. This package provides pre-built descriptors for common API patterns that follow JSON:API conventions.

## Overview

| Descriptor | Purpose |
|------------|---------|
| `CursorPaginatorContentDescriptor` | Cursor-based pagination parameters |
| `FieldsContentDescriptor` | Sparse fieldset selection |
| `FiltersContentDescriptor` | Query filtering parameters |
| `SortsContentDescriptor` | Sort order specification |
| `RelationshipsContentDescriptor` | Relationship inclusion |
| `MethodDataContentDescriptor` | Generic method data input |

## CursorPaginatorContentDescriptor

Generates content descriptor for cursor-based pagination, ideal for real-time data feeds where traditional offset pagination becomes inconsistent.

```php
use Cline\OpenRpc\ContentDescriptor\CursorPaginatorContentDescriptor;

$descriptor = CursorPaginatorContentDescriptor::create();

// Result:
// [
//     'name' => 'page',
//     'description' => 'The page to return. If not specified, the first page is returned.',
//     'schema' => [
//         '$ref' => '#/components/schemas/CursorPaginator',
//     ],
// ]
```

**Usage in methods:**

```php
$method = new MethodValue(
    name: 'users.list',
    params: new DataCollection(ContentDescriptorValue::class, [
        ContentDescriptorValue::from(CursorPaginatorContentDescriptor::create()),
    ]),
    // ...
);
```

**Client request example:**

```json
{
    "jsonrpc": "2.0",
    "method": "users.list",
    "params": {
        "page": {
            "cursor": "eyJpZCI6MTAwfQ==",
            "size": 25
        }
    },
    "id": 1
}
```

## FieldsContentDescriptor

Enables sparse fieldsets following JSON:API patterns. Clients specify exactly which fields they want, reducing payload size.

```php
use Cline\OpenRpc\ContentDescriptor\FieldsContentDescriptor;

$descriptor = FieldsContentDescriptor::create([
    'users' => ['id', 'name', 'email', 'created_at'],
    'posts' => ['id', 'title', 'content', 'published_at'],
]);

// Result:
// [
//     'name' => 'fields',
//     'description' => 'The fields to return for each resource...',
//     'schema' => [
//         'type' => 'object',
//         'properties' => [
//             'users' => [
//                 'name' => 'users',
//                 'type' => 'array',
//                 'items' => [
//                     'type' => 'string',
//                     'enum' => ['id', 'name', 'email', 'created_at'],
//                 ],
//             ],
//             'posts' => [
//                 'name' => 'posts',
//                 'type' => 'array',
//                 'items' => [
//                     'type' => 'string',
//                     'enum' => ['id', 'title', 'content', 'published_at'],
//                 ],
//             ],
//         ],
//     ],
// ]
```

**Client request example:**

```json
{
    "jsonrpc": "2.0",
    "method": "users.list",
    "params": {
        "fields": {
            "users": ["id", "name", "email"],
            "posts": ["id", "title"]
        }
    },
    "id": 1
}
```

Returns `null` if no fields are provided:

```php
$descriptor = FieldsContentDescriptor::create([]);
// Returns null
```

## FiltersContentDescriptor

Defines available filter fields for server-side data filtering. Ensures clients can only filter on explicitly allowed fields.

```php
use Cline\OpenRpc\ContentDescriptor\FiltersContentDescriptor;

$descriptor = FiltersContentDescriptor::create([
    'users' => ['name', 'email', 'active', 'role'],
    'posts' => ['title', 'published', 'author_id', 'category'],
]);

// Result:
// [
//     'name' => 'filters',
//     'description' => 'The filters to apply to the resources...',
//     'schema' => [
//         'type' => 'object',
//         'properties' => [
//             'users' => [
//                 'name' => 'users',
//                 'type' => 'array',
//                 'items' => [
//                     'type' => 'string',
//                     'enum' => ['name', 'email', 'active', 'role'],
//                 ],
//             ],
//             // ...
//         ],
//     ],
// ]
```

**Client request example:**

```json
{
    "jsonrpc": "2.0",
    "method": "users.list",
    "params": {
        "filters": {
            "users": {
                "active": true,
                "role": "admin"
            }
        }
    },
    "id": 1
}
```

## SortsContentDescriptor

Specifies sortable fields with automatic ascending/descending variants. Follows JSON:API convention where `-` prefix indicates descending order.

```php
use Cline\OpenRpc\ContentDescriptor\SortsContentDescriptor;

$descriptor = SortsContentDescriptor::create([
    'users' => ['name', 'created_at', 'email'],
    'posts' => ['title', 'published_at', 'views'],
]);

// Result includes both ascending and descending variants:
// [
//     'name' => 'sorts',
//     'description' => 'The sort order of the resources...',
//     'schema' => [
//         'type' => 'object',
//         'properties' => [
//             'users' => [
//                 'type' => 'array',
//                 'items' => [
//                     'type' => 'string',
//                     'enum' => [
//                         'name', 'created_at', 'email',        // ascending
//                         '-name', '-created_at', '-email',      // descending
//                     ],
//                 ],
//             ],
//             // ...
//         ],
//     ],
// ]
```

**Client request example:**

```json
{
    "jsonrpc": "2.0",
    "method": "users.list",
    "params": {
        "sorts": {
            "users": ["name", "-created_at"]
        }
    },
    "id": 1
}
```

This sorts users by name ascending, then by created_at descending.

## RelationshipsContentDescriptor

Defines which relationships can be eagerly loaded with each resource type, following JSON:API include patterns.

```php
use Cline\OpenRpc\ContentDescriptor\RelationshipsContentDescriptor;

$descriptor = RelationshipsContentDescriptor::create([
    'users' => ['profile', 'posts', 'comments', 'roles'],
    'posts' => ['author', 'comments', 'tags', 'category'],
]);

// Result:
// [
//     'name' => 'relationships',
//     'description' => 'The relationships to return for each resource...',
//     'schema' => [
//         'type' => 'object',
//         'properties' => [
//             'users' => [
//                 'type' => 'array',
//                 'items' => [
//                     'type' => 'string',
//                     'enum' => ['profile', 'posts', 'comments', 'roles'],
//                 ],
//             ],
//             // ...
//         ],
//     ],
// ]
```

**Client request example:**

```json
{
    "jsonrpc": "2.0",
    "method": "users.get",
    "params": {
        "userId": 123,
        "relationships": {
            "users": ["profile", "posts"]
        }
    },
    "id": 1
}
```

## MethodDataContentDescriptor

Creates content descriptors for method input data. Supports both direct schema definition and extraction from data classes.

### From Schema

```php
use Cline\OpenRpc\ContentDescriptor\MethodDataContentDescriptor;

$descriptor = MethodDataContentDescriptor::create([
    'type' => 'object',
    'required' => ['email', 'password'],
    'properties' => [
        'email' => [
            'type' => 'string',
            'format' => 'email',
        ],
        'password' => [
            'type' => 'string',
            'minLength' => 8,
        ],
        'remember' => [
            'type' => 'boolean',
            'default' => false,
        ],
    ],
]);

// Result:
// [
//     'name' => 'data',
//     'description' => 'The data that will be passed to the method.',
//     'schema' => [
//         'type' => 'object',
//         'required' => ['email', 'password'],
//         'properties' => [...],
//     ],
// ]
```

### From Data Class

```php
use Cline\OpenRpc\ContentDescriptor\MethodDataContentDescriptor;

// Data class must implement getValidationRules() method
class LoginData
{
    public static function getValidationRules(array $context): array
    {
        return [
            'type' => 'object',
            'required' => ['email', 'password'],
            'properties' => [
                'email' => ['type' => 'string', 'format' => 'email'],
                'password' => ['type' => 'string', 'minLength' => 8],
            ],
        ];
    }
}

$descriptor = MethodDataContentDescriptor::createFromData(LoginData::class);
```

## Complete Method Example

Combining all content descriptors in a list method:

```php
use Cline\OpenRpc\ValueObject\MethodValue;
use Cline\OpenRpc\ValueObject\ContentDescriptorValue;
use Cline\OpenRpc\ContentDescriptor\CursorPaginatorContentDescriptor;
use Cline\OpenRpc\ContentDescriptor\FieldsContentDescriptor;
use Cline\OpenRpc\ContentDescriptor\FiltersContentDescriptor;
use Cline\OpenRpc\ContentDescriptor\SortsContentDescriptor;
use Cline\OpenRpc\ContentDescriptor\RelationshipsContentDescriptor;
use Spatie\LaravelData\DataCollection;

$params = [];

// Add pagination
$params[] = ContentDescriptorValue::from(
    CursorPaginatorContentDescriptor::create()
);

// Add fields (if any)
if ($fields = FieldsContentDescriptor::create(['users' => ['id', 'name', 'email']])) {
    $params[] = ContentDescriptorValue::from($fields);
}

// Add filters
if ($filters = FiltersContentDescriptor::create(['users' => ['name', 'email', 'active']])) {
    $params[] = ContentDescriptorValue::from($filters);
}

// Add sorts
if ($sorts = SortsContentDescriptor::create(['users' => ['name', 'created_at']])) {
    $params[] = ContentDescriptorValue::from($sorts);
}

// Add relationships
if ($rels = RelationshipsContentDescriptor::create(['users' => ['profile', 'posts']])) {
    $params[] = ContentDescriptorValue::from($rels);
}

$method = new MethodValue(
    name: 'users.list',
    tags: null,
    summary: 'List users with pagination and filtering',
    description: 'Returns a paginated list of users with optional filtering, sorting, and relationship loading.',
    externalDocs: null,
    params: new DataCollection(ContentDescriptorValue::class, $params),
    result: new ContentDescriptorValue(
        name: 'users',
        summary: 'Paginated user list',
        description: null,
        required: true,
        schema: ['$ref' => '#/components/schemas/PaginatedUsers'],
        deprecated: false,
    ),
    deprecated: false,
    servers: null,
    errors: null,
    links: null,
    paramStructure: 'by-name',
    examples: null,
);
```

<a id="doc-docs-schemas"></a>

Schemas provide reusable JSON Schema definitions that can be referenced throughout your OpenRPC specification using `$ref` pointers. This package includes pre-built schemas for common patterns.

## CursorPaginatorSchema

Defines the structure for cursor-based pagination parameters. Used in conjunction with `CursorPaginatorContentDescriptor`.

```php
use Cline\OpenRpc\Schema\CursorPaginatorSchema;

$schema = CursorPaginatorSchema::create();

// Result:
// [
//     'name' => 'CursorPaginator',
//     'data' => [
//         'type' => 'object',
//         'required' => ['cursor'],
//         'properties' => [
//             'cursor' => [
//                 'type' => 'string',
//                 'description' => 'The cursor to start from...',
//             ],
//             'size' => [
//                 'type' => 'integer',
//                 'description' => 'The number of items to return per page...',
//             ],
//         ],
//     ],
// ]
```

### Adding to Components

```php
use Cline\OpenRpc\ValueObject\ComponentsValue;
use Cline\OpenRpc\ValueObject\SchemaValue;
use Cline\OpenRpc\Schema\CursorPaginatorSchema;

$cursorSchema = CursorPaginatorSchema::create();

$components = new ComponentsValue(
    contentDescriptors: null,
    schemas: [
        'CursorPaginator' => new SchemaValue(
            name: $cursorSchema['name'],
            data: $cursorSchema['data'],
        ),
    ],
    examples: null,
    links: null,
    errors: null,
    examplePairingObjects: null,
    tags: null,
);
```

### Referencing the Schema

Once added to components, reference it using `$ref`:

```php
use Cline\OpenRpc\ContentDescriptor\CursorPaginatorContentDescriptor;

$descriptor = CursorPaginatorContentDescriptor::create();
// Schema is: ['$ref' => '#/components/schemas/CursorPaginator']
```

## Custom Schemas

Create your own schemas using `SchemaValue`:

### User Schema

```php
use Cline\OpenRpc\ValueObject\SchemaValue;

$userSchema = new SchemaValue(
    name: 'User',
    data: [
        'type' => 'object',
        'required' => ['id', 'email'],
        'properties' => [
            'id' => [
                'type' => 'integer',
                'description' => 'Unique user identifier',
                'minimum' => 1,
            ],
            'email' => [
                'type' => 'string',
                'format' => 'email',
                'description' => 'User email address',
            ],
            'name' => [
                'type' => 'string',
                'description' => 'Display name',
                'minLength' => 1,
                'maxLength' => 255,
            ],
            'role' => [
                'type' => 'string',
                'enum' => ['user', 'admin', 'moderator'],
                'default' => 'user',
            ],
            'createdAt' => [
                'type' => 'string',
                'format' => 'date-time',
            ],
            'updatedAt' => [
                'type' => 'string',
                'format' => 'date-time',
            ],
        ],
    ],
);
```

### Pagination Response Schema

```php
$paginatedSchema = new SchemaValue(
    name: 'PaginatedResponse',
    data: [
        'type' => 'object',
        'required' => ['data', 'meta'],
        'properties' => [
            'data' => [
                'type' => 'array',
                'items' => [
                    '$ref' => '#/components/schemas/User',
                ],
            ],
            'meta' => [
                'type' => 'object',
                'properties' => [
                    'cursor' => [
                        'type' => 'object',
                        'properties' => [
                            'current' => ['type' => 'string', 'nullable' => true],
                            'prev' => ['type' => 'string', 'nullable' => true],
                            'next' => ['type' => 'string', 'nullable' => true],
                        ],
                    ],
                    'perPage' => ['type' => 'integer'],
                    'hasMore' => ['type' => 'boolean'],
                ],
            ],
        ],
    ],
);
```

### Error Response Schema

```php
$errorSchema = new SchemaValue(
    name: 'ValidationError',
    data: [
        'type' => 'object',
        'required' => ['field', 'message'],
        'properties' => [
            'field' => [
                'type' => 'string',
                'description' => 'Field that failed validation',
            ],
            'message' => [
                'type' => 'string',
                'description' => 'Human-readable error message',
            ],
            'code' => [
                'type' => 'string',
                'description' => 'Machine-readable error code',
            ],
        ],
    ],
);
```

## Complete Components Example

```php
use Cline\OpenRpc\ValueObject\ComponentsValue;
use Cline\OpenRpc\ValueObject\SchemaValue;
use Cline\OpenRpc\ValueObject\ErrorValue;
use Cline\OpenRpc\ValueObject\ContentDescriptorValue;
use Cline\OpenRpc\Schema\CursorPaginatorSchema;

$cursorSchema = CursorPaginatorSchema::create();

$components = new ComponentsValue(
    contentDescriptors: [
        'UserId' => new ContentDescriptorValue(
            name: 'userId',
            summary: 'User identifier',
            description: null,
            required: true,
            schema: ['type' => 'integer', 'minimum' => 1],
            deprecated: false,
        ),
    ],
    schemas: [
        'CursorPaginator' => new SchemaValue(
            name: $cursorSchema['name'],
            data: $cursorSchema['data'],
        ),
        'User' => new SchemaValue(
            name: 'User',
            data: [
                'type' => 'object',
                'required' => ['id', 'email'],
                'properties' => [
                    'id' => ['type' => 'integer'],
                    'email' => ['type' => 'string', 'format' => 'email'],
                    'name' => ['type' => 'string'],
                ],
            ],
        ),
        'PaginatedUsers' => new SchemaValue(
            name: 'PaginatedUsers',
            data: [
                'type' => 'object',
                'properties' => [
                    'data' => [
                        'type' => 'array',
                        'items' => ['$ref' => '#/components/schemas/User'],
                    ],
                    'meta' => ['$ref' => '#/components/schemas/PaginationMeta'],
                ],
            ],
        ),
        'PaginationMeta' => new SchemaValue(
            name: 'PaginationMeta',
            data: [
                'type' => 'object',
                'properties' => [
                    'cursor' => ['type' => 'string', 'nullable' => true],
                    'nextCursor' => ['type' => 'string', 'nullable' => true],
                    'prevCursor' => ['type' => 'string', 'nullable' => true],
                    'hasMore' => ['type' => 'boolean'],
                    'perPage' => ['type' => 'integer'],
                ],
            ],
        ),
    ],
    examples: null,
    links: null,
    errors: [
        'NotFound' => new ErrorValue(
            code: 404,
            message: 'Resource not found',
            data: null,
        ),
        'Unauthorized' => new ErrorValue(
            code: 401,
            message: 'Authentication required',
            data: null,
        ),
        'ValidationFailed' => new ErrorValue(
            code: -32602,
            message: 'Validation failed',
            data: [
                'type' => 'array',
                'items' => ['$ref' => '#/components/schemas/ValidationError'],
            ],
        ),
    ],
    examplePairingObjects: null,
    tags: null,
);
```

## Using References

Reference components throughout your specification:

```php
// In method parameters
$params = new DataCollection(ContentDescriptorValue::class, [
    new ContentDescriptorValue(
        name: 'userId',
        summary: null,
        description: null,
        required: true,
        schema: ['$ref' => '#/components/contentDescriptors/UserId'],
        deprecated: false,
    ),
]);

// In method results
$result = new ContentDescriptorValue(
    name: 'users',
    summary: 'List of users',
    description: null,
    required: true,
    schema: ['$ref' => '#/components/schemas/PaginatedUsers'],
    deprecated: false,
);

// In method errors
$errors = new DataCollection(ErrorValue::class, [
    ErrorValue::from(['$ref' => '#/components/errors/NotFound']),
    ErrorValue::from(['$ref' => '#/components/errors/Unauthorized']),
]);
```

## SchemaValue Serialization

`SchemaValue` has a custom `toArray()` method that outputs the schema in the format expected by OpenRPC:

```php
$schema = new SchemaValue(
    name: 'User',
    data: ['type' => 'object', 'properties' => [...]],
);

$array = $schema->toArray();
// Result: ['User' => ['type' => 'object', 'properties' => [...]]]
```

This format is required when placing schemas in the `components/schemas` section of an OpenRPC document.

## JSON Schema Features

The schema `data` array supports all JSON Schema Draft 7 features:

### Basic Types

```php
['type' => 'string']
['type' => 'integer']
['type' => 'number']
['type' => 'boolean']
['type' => 'array']
['type' => 'object']
['type' => 'null']
```

### String Constraints

```php
[
    'type' => 'string',
    'minLength' => 1,
    'maxLength' => 255,
    'pattern' => '^[a-z]+$',
    'format' => 'email', // email, uri, date-time, uuid, etc.
]
```

### Numeric Constraints

```php
[
    'type' => 'integer',
    'minimum' => 0,
    'maximum' => 100,
    'exclusiveMinimum' => 0,
    'multipleOf' => 5,
]
```

### Array Constraints

```php
[
    'type' => 'array',
    'items' => ['type' => 'string'],
    'minItems' => 1,
    'maxItems' => 10,
    'uniqueItems' => true,
]
```

### Object Constraints

```php
[
    'type' => 'object',
    'required' => ['id', 'name'],
    'properties' => [...],
    'additionalProperties' => false,
    'minProperties' => 1,
]
```

### Composition

```php
// anyOf
['anyOf' => [['type' => 'string'], ['type' => 'integer']]]

// oneOf
['oneOf' => [['$ref' => '#/components/schemas/Cat'], ['$ref' => '#/components/schemas/Dog']]]

// allOf (inheritance)
['allOf' => [['$ref' => '#/components/schemas/Base'], ['properties' => [...]]]]
```

<a id="doc-docs-value-objects"></a>

All OpenRPC specification components are represented as immutable value objects extending `Spatie\LaravelData\Data`. This ensures type safety, automatic serialization, and integration with Laravel's ecosystem.

## DocumentValue

The root container for an OpenRPC specification document.

```php
use Cline\OpenRpc\ValueObject\DocumentValue;

$document = new DocumentValue(
    openrpc: '1.2.6',                    // Required: OpenRPC spec version
    info: $info,                          // Required: API metadata
    servers: $servers,                    // Optional: Server endpoints
    methods: $methods,                    // Required: RPC methods
    components: $components,              // Optional: Reusable components
    externalDocs: $externalDocs,          // Optional: External documentation
);
```

**Properties:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `openrpc` | `string` | Yes | Semantic version of OpenRPC specification |
| `info` | `InfoValue` | Yes | API metadata |
| `servers` | `DataCollection<ServerValue>` | No | Available server endpoints |
| `methods` | `DataCollection<MethodValue>` | Yes | RPC method definitions |
| `components` | `ComponentsValue` | No | Reusable specification components |
| `externalDocs` | `ExternalDocumentationValue` | No | External documentation links |

## InfoValue

Metadata about the API including title, version, and contact information.

```php
use Cline\OpenRpc\ValueObject\InfoValue;
use Cline\OpenRpc\ValueObject\ContactValue;
use Cline\OpenRpc\ValueObject\LicenseValue;

$info = new InfoValue(
    title: 'My API',
    description: 'A JSON-RPC 2.0 API',
    termsOfService: 'https://example.com/tos',
    contact: new ContactValue(
        name: 'API Support',
        url: 'https://example.com/support',
        email: 'support@example.com',
    ),
    license: new LicenseValue(
        name: 'MIT',
        url: 'https://opensource.org/licenses/MIT',
    ),
    version: '1.0.0',
);
```

**Properties:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `title` | `string` | Yes | API title |
| `description` | `?string` | No | Detailed description (CommonMark) |
| `termsOfService` | `?string` | No | URL to terms of service |
| `contact` | `?ContactValue` | No | Contact information |
| `license` | `?LicenseValue` | No | License information |
| `version` | `string` | Yes | API version |

## MethodValue

Defines an RPC method with its parameters, result, and metadata.

```php
use Cline\OpenRpc\ValueObject\MethodValue;
use Cline\OpenRpc\ValueObject\ContentDescriptorValue;
use Spatie\LaravelData\DataCollection;

$method = new MethodValue(
    name: 'user.create',
    tags: null,
    summary: 'Create a new user',
    description: 'Creates a user with the provided data',
    externalDocs: null,
    params: new DataCollection(ContentDescriptorValue::class, [
        new ContentDescriptorValue(
            name: 'email',
            summary: 'User email address',
            description: null,
            required: true,
            schema: ['type' => 'string', 'format' => 'email'],
            deprecated: false,
        ),
        new ContentDescriptorValue(
            name: 'name',
            summary: 'User display name',
            description: null,
            required: true,
            schema: ['type' => 'string', 'minLength' => 1],
            deprecated: false,
        ),
    ]),
    result: new ContentDescriptorValue(
        name: 'user',
        summary: 'Created user object',
        description: null,
        required: true,
        schema: ['$ref' => '#/components/schemas/User'],
        deprecated: false,
    ),
    deprecated: false,
    servers: null,
    errors: null,
    links: null,
    paramStructure: 'by-name',
    examples: null,
);
```

**Properties:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `name` | `string` | Yes | Unique method identifier |
| `tags` | `DataCollection<TagValue>` | No | Categorization tags |
| `summary` | `?string` | No | Brief description |
| `description` | `?string` | No | Detailed description |
| `externalDocs` | `?ExternalDocumentationValue` | No | External documentation |
| `params` | `DataCollection<ContentDescriptorValue>` | Yes | Method parameters |
| `result` | `?ContentDescriptorValue` | No | Return value descriptor |
| `deprecated` | `bool` | No | Deprecation flag |
| `servers` | `DataCollection<ServerValue>` | No | Method-specific servers |
| `errors` | `DataCollection<ErrorValue>` | No | Possible error responses |
| `links` | `DataCollection<LinkValue>` | No | Related resources |
| `paramStructure` | `?string` | No | `by-position` or `by-name` |
| `examples` | `DataCollection<ExamplePairingValue>` | No | Example request/response pairs |

## ContentDescriptorValue

Describes a parameter, result, or error with its schema and metadata.

```php
use Cline\OpenRpc\ValueObject\ContentDescriptorValue;

$descriptor = new ContentDescriptorValue(
    name: 'userId',
    summary: 'User identifier',
    description: 'The unique identifier for a user in the system',
    required: true,
    schema: [
        'type' => 'integer',
        'minimum' => 1,
        'description' => 'Positive integer ID',
    ],
    deprecated: false,
);
```

**Properties:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `name` | `string` | Yes | Unique identifier |
| `summary` | `?string` | No | Brief description |
| `description` | `?string` | No | Detailed description |
| `required` | `bool` | No | Whether parameter is required |
| `schema` | `?array` | No | JSON Schema definition |
| `deprecated` | `bool` | No | Deprecation flag |

## ServerValue

Defines an API server endpoint.

```php
use Cline\OpenRpc\ValueObject\ServerValue;
use Cline\OpenRpc\ValueObject\ServerVariableValue;

$server = new ServerValue(
    name: 'Production',
    url: 'https://api.example.com/{version}/rpc',
    summary: 'Production API endpoint',
    description: 'Main production server with regional routing',
    variables: [
        'version' => new ServerVariableValue(
            default: 'v1',
            description: 'API version',
            enum: ['v1', 'v2'],
        ),
    ],
);
```

**Properties:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `name` | `string` | Yes | Server identifier |
| `url` | `string` | Yes | Server URL (supports variables) |
| `summary` | `?string` | No | Brief description |
| `description` | `?string` | No | Detailed description |
| `variables` | `?array<string, ServerVariableValue>` | No | URL template variables |

## ErrorValue

Defines an error response following JSON-RPC 2.0 error format.

```php
use Cline\OpenRpc\ValueObject\ErrorValue;

$error = new ErrorValue(
    code: -32602,
    message: 'Invalid params',
    data: [
        'field' => 'email',
        'reason' => 'Invalid email format',
    ],
);
```

**Properties:**

| Property | Type | Required | Description |
|----------|------|----------|-------------|
| `code` | `int` | Yes | Numeric error code |
| `message` | `string` | Yes | Human-readable message |
| `data` | `mixed` | No | Additional error data |

**Standard JSON-RPC 2.0 Error Codes:**

| Code | Message | Description |
|------|---------|-------------|
| -32700 | Parse error | Invalid JSON |
| -32600 | Invalid Request | Invalid JSON-RPC request |
| -32601 | Method not found | Method does not exist |
| -32602 | Invalid params | Invalid method parameters |
| -32603 | Internal error | Server error |
| -32000 to -32099 | Server error | Reserved for implementation |

## ComponentsValue

Container for reusable specification components.

```php
use Cline\OpenRpc\ValueObject\ComponentsValue;
use Cline\OpenRpc\ValueObject\SchemaValue;

$components = new ComponentsValue(
    contentDescriptors: [
        'UserId' => new ContentDescriptorValue(...),
    ],
    schemas: [
        'User' => new SchemaValue(
            name: 'User',
            data: [
                'type' => 'object',
                'required' => ['id', 'email'],
                'properties' => [
                    'id' => ['type' => 'integer'],
                    'email' => ['type' => 'string', 'format' => 'email'],
                    'name' => ['type' => 'string'],
                ],
            ],
        ),
    ],
    examples: null,
    links: null,
    errors: [
        'NotFound' => new ErrorValue(
            code: 404,
            message: 'Resource not found',
            data: null,
        ),
    ],
    examplePairingObjects: null,
    tags: null,
);
```

**Properties:**

| Property | Type | Description |
|----------|------|-------------|
| `contentDescriptors` | `?array<string, ContentDescriptorValue>` | Reusable parameter/result descriptors |
| `schemas` | `?array<string, SchemaValue>` | JSON Schema definitions |
| `examples` | `?array<string, ExampleValue>` | Reusable examples |
| `links` | `?array<string, LinkValue>` | Reusable links |
| `errors` | `?array<string, ErrorValue>` | Reusable error definitions |
| `examplePairingObjects` | `?array<string, ExamplePairingValue>` | Reusable example pairs |
| `tags` | `?array<string, TagValue>` | Reusable tags |

## SchemaValue

Named JSON Schema definition for use in components.

```php
use Cline\OpenRpc\ValueObject\SchemaValue;

$schema = new SchemaValue(
    name: 'Pagination',
    data: [
        'type' => 'object',
        'properties' => [
            'page' => ['type' => 'integer', 'minimum' => 1],
            'perPage' => ['type' => 'integer', 'minimum' => 1, 'maximum' => 100],
        ],
    ],
);

// Converts to: { "Pagination": { "type": "object", ... } }
$array = $schema->toArray();
```

## ExampleValue

Sample values for documentation and testing.

```php
use Cline\OpenRpc\ValueObject\ExampleValue;

$example = new ExampleValue(
    name: 'valid-user',
    summary: 'A valid user object',
    description: 'Example of a complete user with all fields',
    value: json_encode([
        'id' => 123,
        'email' => 'user@example.com',
        'name' => 'John Doe',
    ]),
    externalValue: null,
);
```

## ExamplePairingValue

Groups parameter examples with their corresponding results.

```php
use Cline\OpenRpc\ValueObject\ExamplePairingValue;
use Cline\OpenRpc\ValueObject\ExampleValue;
use Spatie\LaravelData\DataCollection;

$pairing = new ExamplePairingValue(
    name: 'get-user-by-id',
    description: 'Get an existing user by their ID',
    summary: 'Successful user retrieval',
    params: new DataCollection(ExampleValue::class, [
        new ExampleValue(
            name: 'userId',
            summary: null,
            description: null,
            value: '123',
            externalValue: null,
        ),
    ]),
    result: new DataCollection(ExampleValue::class, [
        new ExampleValue(
            name: 'user',
            summary: null,
            description: null,
            value: json_encode(['id' => 123, 'name' => 'John']),
            externalValue: null,
        ),
    ]),
);
```

## ReferenceValue

Creates `$ref` pointers to reusable components.

```php
use Cline\OpenRpc\ValueObject\ReferenceValue;

$ref = new ReferenceValue(
    ref: '#/components/schemas/User',
);
```

## Supporting Value Objects

### ContactValue

```php
$contact = new ContactValue(
    name: 'API Support',
    url: 'https://example.com/support',
    email: 'api@example.com',
);
```

### LicenseValue

```php
$license = new LicenseValue(
    name: 'MIT',
    url: 'https://opensource.org/licenses/MIT',
);
```

### TagValue

```php
$tag = new TagValue(
    name: 'users',
    summary: 'User management methods',
    description: 'Methods for creating, reading, updating, and deleting users',
    externalDocs: null,
);
```

### LinkValue

```php
$link = new LinkValue(
    name: 'GetUserById',
    summary: 'Get the user by ID',
    description: null,
    method: 'user.get',
    params: ['userId' => '$response.id'],
    server: null,
);
```

### ExternalDocumentationValue

```php
$docs = new ExternalDocumentationValue(
    description: 'Full API documentation',
    url: 'https://docs.example.com/api',
);
```

### ServerVariableValue

```php
$variable = new ServerVariableValue(
    default: 'v1',
    description: 'API version',
    enum: ['v1', 'v2', 'beta'],
);
```
