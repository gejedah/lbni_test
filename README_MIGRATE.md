Migration steps to finish upgrading to CodeIgniter 4

1) Install CodeIgniter 4 (preferred: appstarter) via Composer in project root:
   composer create-project codeigniter4/appstarter:latest .
   - This will install framework files and create a canonical CI4 structure. It will overwrite conflicting files; review carefully.

   OR, if you already have a composer.json, run:
   composer require codeigniter4/framework

2) Move the generated `app` folder files into this project (we already created app/Controllers, app/Models, app/Config). Ensure the following exist:
   - system/ (from vendor/codeigniter4/framework or appstarter)
   - writable/ (for logs, cache, session)
   - public/ (we added public/; replace public/index.php with the one from appstarter if needed)

3) Update `app/Config/App.php` and `app/Config/Database.php` with your settings (baseURL, DB credentials).

4) Set webserver document root to the `public/` folder.
   Quick test with built-in server:
   php -S localhost:8080 -t public

5) Test endpoints:
   http://localhost:8080/so
   http://localhost:8080/sales_order/list?tipe=Door%20to%20Door&ada_asuransi=1

6) Migrate other controllers/models/views manually from `application/` to `app/` following CI4 conventions.

Notes:
- CI4 controllers use PSR-4 namespaces (App\\Controllers) and extend App\\Controllers\\BaseController.
- Models extend CodeIgniter\\Model and live in App\\Models.
- Routes are defined in app/Config/Routes.php (we added the basic routes).

If you want, I can run `composer create-project` here (requires composer available in the environment). Ask me to proceed and I'll run it.
