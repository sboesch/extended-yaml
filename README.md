# Extended Yaml

Extended Yaml is a subset of Yaml, providing support for the magic `$extends` property.

## Installation

    composer require sboesch/extended-yaml

## Example

### Input

```yaml
user_types:
  user:
    first_name: null
    last_name: null
    email: null
    password: null
    enabled: 1
    roles: [ROLE_USER]
  admin:
    $extends: 'user_types.user'
    roles: [ROLE_USER, ROLE_ADMIN]
    
users:
  admin:
    $extends: 'user_types.admin'

```

### Output

```yaml
user_types:
  user:
    first_name: null
    last_name: null
    email: null
    password: null
    enabled: 1
    roles: [ROLE_USER]
  admin:
    first_name: null
    last_name: null
    email: null
    password: null
    enabled: 1
    roles: [ROLE_USER, ROLE_ADMIN]
    
users:
  admin:
    first_name: null
    last_name: null
    email: null
    password: null
    enabled: 1
    roles: [ROLE_USER, ROLE_ADMIN]

```
