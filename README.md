project-bootstrap
=================

Shared project code maintained in a central repository

## Installation

<strike>Run the install script.</strike> install manually for now.

Define the following functions before requiring the bootstrap file:

- `get_app_env`     - returns a simple string of dev, stg, or prd for environment
- `get_app_loaders` - returns an array of `Lib\Loaders` for the application or an empty array.

### CI Installation notes

For CI, call `kern_api_entry_point()` after all of the loading but before the router validates the request and sends for 404.
