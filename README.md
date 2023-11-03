menggunakan services yang sudah di buat
1. crud work
2. login sactum word
3. upload image/file work
4. import and export excel maatwebsite/excel work
5. dompof work
6. livewire -masih not work XXX ini tidak bisa error
7. firebase

CrudGeneratorImageService.php
CrudGeneratorService.php
ExcelGeneratorService.php
LoginGeneratorSactumService.php
RemoveGeneratorService.php

pindahkan file tersebut ke app/console/commands
lalu buka kernel.php yang ada di app/console/
lalu tambahkan kode ini
	protected $commands = [
        // ...
        \App\Console\Commands\CrudGeneratorService::class,
        \App\Console\Commands\RemoveGeneratorService::class,
        \App\Console\Commands\LoginGeneratorSactumService::class,
    ];

1#crud api
	crud-generator:create-api {name} {fields}
	ex: crud-generator:create-api images "cc,aa,bb"
	Menampilkan Daftar Gambar (GET):

	URL: /api/images
	Metode: GET
	Membuat Gambar Baru (POST):

	URL: /api/images
	Metode: POST
	Menampilkan Detail Gambar (GET):

	URL: /api/images/{id}
	Metode: GET
	{id} adalah ID gambar yang ingin Anda tampilkan.
	Mengganti Gambar (PUT):

	URL: /api/images/{id}
	Metode: PUT
	{id} adalah ID gambar yang ingin Anda perbarui.
	Menghapus Gambar (DELETE):

	URL: /api/images/{id}
	Metode: DELETE
	{id} adalah ID gambar yang ingin Anda hapus.
2#login
jalankan
	composer require laravel/sanctum
lalu
	php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
lalu
	php artisan migrate
lalu
	php artisan crud-generator:login
lalu tambahkan kode ini di routes/api.php
	use App\Http\Controllers\API\AuthController;
	Route::post('/register', [AuthController::class, 'register']);
	Route::post('/login', [AuthController::class, 'login']);
	Route::group(['middleware' => ['auth:sanctum']], function () {
	    Route::post('/logout', [AuthController::class, 'logout']);
	    Route::put('/user-update/{id}', [AuthController::class, 'update']);
	});
3. upload image
php artisan crud-generator:image {name} {fields}
ex : php artisan crud-generator:image gambar "profile_id"
4. import and export excel

	menggunakan composer.json
	"maatwebsite/excel": "^3.1"
	atau
	composer require maatwebsite/excel

	tambahkan config/app
	'providers' => [
	    ...
	    Maatwebsite\Excel\ExcelServiceProvider::class,
	]


	'aliases' => [
	    ...
	    'Excel' => Maatwebsite\Excel\Facades\Excel::class,
	]

	jalankan
	php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"

5. export ke pdf menggunakan dompdf
	crud-generator:excel {name} {fields}
	ex: php artisan crud-generator:excel siswa "nama,nisn,alamat"

