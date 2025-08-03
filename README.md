# Website using PHP

This application built with [CodeIgniter 4](https://codeigniter.com/) PHP framework.

## Project Structure

```
.
├── app/                # Application code (controllers, models, views, config, etc.)
├── public/             # Web root (index.php, assets, front, admin)
├── system/             # CodeIgniter core framework files
├── writable/           # Writable directory for cache, logs, sessions, uploads
├── .env                # Environment configuration (not committed)
├── .env.example        # Example environment configuration
├── composer.json       # Composer dependencies (if present)
└── ...
```

## Setup

1. **Clone the repository:**
   ```sh
   git clone <your-repo-url>
   cd AmberCapital
   ```

2. **Install dependencies:**
   ```sh
   composer install
   ```

3. **Copy the example environment file and configure:**
   ```sh
   cp .env.example .env
   ```
   Edit `.env` to set your database, encryption, and session settings.

4. **Set writable permissions:**
   ```sh
   chmod -R 0777 writable
   ```

5. **Set your web server's document root to the `public/` directory.**

## Configuration

- **Database:**  
  Configure your database settings in `.env`:
  ```
  database.default.hostname = localhost
  database.default.database = your_db
  database.default.username = your_user
  database.default.password = your_pass
  database.default.DBDriver = MySQLi
  ```

- **Encryption:**  
  Generate and set an encryption key:
  ```sh
  php spark key:generate
  ```
  Then set `encryption.key = ...` in your `.env`.

- **Session:**  
  By default, sessions use file storage. You can change the driver in `.env`:
  ```
  session.driver = 'CodeIgniter\Session\Handlers\FileHandler'
  session.savePath = writable/session
  ```

## Running

- **Development server:**
  ```sh
  php spark serve
  ```
  Visit [http://localhost:8080](http://localhost:8080).

## Testing

- **Run tests:**
  ```sh
  php vendor/bin/phpunit
  ```

## License

This project is based on CodeIgniter 4, which is MIT licensed. See the LICENSE file for more information.
