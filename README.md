# Laravel Telegram Notification

## Instalasi

1. Install library melalui terminal:
    ```bash
    composer require laravel-notification-channels/telegram
    ```

2. Tambahkan baris berikut ke file `.env` di proyek Anda:
    ```plaintext
    TELEGRAM_BOT_TOKEN="isi dengan bot telegram kalian yang kalian dapatkan dari bot father"
    ```

## Konfigurasi

3. Buka file `config/service.php` kemudian tambahkan kode berikut di baris akhir:
    ```php
    'telegram-bot-api' => [
        'token' => env('TELEGRAM_BOT_TOKEN', 'YOUR BOT TOKEN HERE')
    ],
    ```

    Sehingga menjadi seperti ini:
    ```php
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'telegram-bot-api' => [
        'token' => env('TELEGRAM_BOT_TOKEN', 'token bot kamu')
    ],
    ```

## Membuat Notifikasi

4. Ketikkan perintah berikut di terminal untuk membuat notifikasi:
    ```bash
    php artisan make:notification TelegramNotification
    ```

    File `TelegramNotification` akan terbuat di `app/Notifications/TelegramNotification.php`. Copy dan paste kode berikut ke dalam file tersebut:
    ```php
    <?php

    namespace App\Notifications;

    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Notifications\Messages\MailMessage;
    use Illuminate\Notifications\Notification;
    use NotificationChannels\Telegram\TelegramMessage;

    class TelegramNotification extends Notification
    {
        use Queueable;

        /**
         * Create a new notification instance.
         *
         * @return void
         */
        public function __construct()
        {
            //
        }

        /**
         * Get the notification's delivery channels.
         *
         * @param  mixed  $notifiable
         * @return array
         */
        public function via($notifiable)
        {
            return ['telegram'];
        }

        /**
         * Get the telegram representation of the notification.
         *
         * @param  mixed  $notifiable)
         * @return TelegramMessage
         */
        public function toTelegram($notifiable)
        {
            return TelegramMessage::create()
                ->to($notifiable->telegram_chat_id)
                ->content('Hello, this is a test notification.');
        }

        /**
         * Get the array representation of the notification.
         *
         * @param  mixed  $notifiable
         * @return array
         */
        public function toArray($notifiable)
        {
            return [
                //
            ];
        }
    }
    ```

## Menambahkan Kolom ke Tabel User

5. Tambahkan kode berikut ke migration `user` di bawah `password`:
    ```php
    $table->string('telegram_chat_id')->nullable();
    ```

## Membuat Controller untuk Mengirimkan Notifikasi

6. Buat controller dengan perintah berikut:
    ```bash
    php artisan make:controller SendNotificationController
    ```

    Setelah controller terbuat, copy dan paste atau ganti seluruh kode pada controller tersebut dengan kode berikut:
    ```php
    <?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use App\Notifications\TelegramNotification;
    use Illuminate\Http\Request;

    class SendNotificationController extends Controller
    {
        public function index()
        {
            $user = User::all();
            foreach ($user as $key => $u) {
                $u->notify(new TelegramNotification());
            }
        }
    }
    ```

## Menambahkan Route

7. Tambahkan route berikut di `routes/api.php`:
    ```php
    Route::get('send-notif', [SendNotificationController::class, 'index']);
    ```

    Selanjutnya, coba akses:
    ```
    http://127.0.0.1:8000/api/send-notif
    ```

    Jika pesan masuk ke Telegram, maka setup ini berhasil diterapkan.
