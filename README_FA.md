# مستندات فنی پروژه شطرنج آنلاین

## 📋 فهرست مطالب
- [معرفی پروژه](#معرفی-پروژه)
- [معماری فنی](#معماری-فنی)
- [پکیج‌های استفاده شده](#پکیج‌های-استفاده-شده)
- [مسیریابی (Routes)](#مسیریابی-routes)
- [مدل‌های داده](#مدل‌های-داده)
- [امنیت](#امنیت)
- [توسعه‌های آتی](#توسعه‌های-آتی)
- [نصب و راه‌اندازی](#نصب-و-راه‌اندازی)

## 🎯 معرفی پروژه

این پروژه یک سیستم شطرنج آنلاین است که با استفاده از Laravel 12 و Livewire 3 ساخته شده است. کاربران می‌توانند بازی‌های شطرنج آنلاین انجام دهند و حرکات به صورت real-time بین بازیکنان همگام‌سازی می‌شود.

### ویژگی‌های اصلی:
- ✅ احراز هویت کاربران
- ✅ ایجاد و مدیریت بازی‌های شطرنج
- ✅ رابط کاربری تعاملی با استفاده از chess.js و cm-chessboard
- ✅ همگام‌سازی real-time حرکات
- ✅ پنل مدیریت برای ادمین‌ها
- ✅ پشتیبانی از زبان فارسی
- ✅ رابط کاربری مدرن با Tailwind CSS

## 🏗️ معماری فنی

### Backend:
- **Laravel 12**: فریم‌ورک اصلی PHP
- **Livewire 3**: برای رابط‌های تعاملی بدون JavaScript اضافی
- **Laravel Reverb**: برای WebSocket و real-time communication
- **Laravel Queue**: برای پردازش غیرهمزمان حرکات
- **Laravel Broadcasting**: برای ارسال رویدادها به کلاینت‌ها

### Frontend:
- **Alpine.js**: برای تعاملات JavaScript ساده
- **Tailwind CSS 4**: برای استایل‌دهی
- **Chess.js**: موتور شطرنج برای اعتبارسنجی حرکات
- **CM-Chessboard**: رابط کاربری تخته شطرنج
- **Laravel Echo**: برای دریافت رویدادهای real-time

### Database:
- **MySQL/PostgreSQL**: پایگاه داده اصلی
- **Redis**: برای کش و صف‌ها (اختیاری)

## 📦 پکیج‌های استفاده شده

### Composer Dependencies (PHP):

#### پکیج‌های اصلی:
```json
{
    "laravel/framework": "^12.0",
    "livewire/livewire": "^3.6",
    "laravel/reverb": "^1.0",
    "laravel/socialite": "^5.23",
    "wire-elements/modal": "^3.0",
    "laravel-lang/common": "^6.7"
}
```

#### پکیج‌های توسعه:
```json
{
    "pestphp/pest": "^3.8",
    "laravel/pint": "^1.13",
    "laravel/sail": "^1.41",
    "fakerphp/faker": "^1.23"
}
```

### NPM Dependencies (JavaScript):

#### پکیج‌های اصلی:
```json
{
    "chess.js": "^1.4.0",
    "cm-chessboard": "^8.7.8",
    "laravel-echo": "^2.2.0",
    "pusher-js": "^8.4.0"
}
```

#### پکیج‌های توسعه:
```json
{
    "tailwindcss": "^4.0.0",
    "vite": "^7.0.4",
    "axios": "^1.11.0"
}
```

## 🛣️ مسیریابی (Routes)

### مسیرهای احراز هویت:
```php
// مسیرهای مهمان
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

// مسیرهای کاربران احراز هویت شده
Route::middleware('auth')->group(function () {
    Route::get('/logout', Logout::class)->name('logout');
});
```

### مسیرهای کاربران:
```php
Route::middleware('auth')->group(function () {
    // صفحه اصلی - لیست بازی‌ها
    Route::get('/', App\Livewire\User\Game\Index::class)->name('home');
    
    // مدیریت بازی‌ها
    Route::get('/user/game/index', App\Livewire\User\Game\Index::class)->name('user.game.index');
    Route::get('/user/game/play/{id}', App\Livewire\User\Game\Play::class)->name('user.game.play');
});
```

### مسیرهای ادمین:
```php
Route::middleware('auth')->group(function () {
    // پنل مدیریت
    Route::get('/admin/dashboard/index', App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard.index');
    Route::get('/admin/user/index', App\Livewire\Admin\User\Index::class)->name('admin.user.index');
    Route::get('/admin/game/index', App\Livewire\Admin\Game\Index::class)->name('admin.game.index');
});
```

## 🗄️ مدل‌های داده

### مدل Game:
```php
class Game extends Model
{
    protected $fillable = [
        'white_user_id',
        'black_user_id', 
        'turn',
        'fen'
    ];
    
    // روابط
    public function white() { return $this->belongsTo(User::class, 'white_user_id'); }
    public function black() { return $this->belongsTo(User::class, 'black_user_id'); }
    public function moves() { return $this->hasMany(Move::class)->orderBy('move_number'); }
}
```

### مدل Move:
```php
class Move extends Model
{
    protected $fillable = [
        'game_id',
        'user_id',
        'move_number',
        'from',
        'to', 
        'san',
        'fen_before',
        'fen_after',
        'meta'
    ];
    
    protected $casts = [
        'meta' => 'array'
    ];
}
```

### ساختار پایگاه داده:

#### جدول games:
- `id`: شناسه یکتا
- `white_user_id`: شناسه کاربر سفید
- `black_user_id`: شناسه کاربر سیاه
- `turn`: نوبت فعلی (white/black)
- `fen`: وضعیت فعلی بازی در فرمت FEN

#### جدول moves:
- `id`: شناسه یکتا
- `game_id`: شناسه بازی
- `user_id`: شناسه کاربر انجام‌دهنده حرکت
- `move_number`: شماره حرکت
- `from`: مبدا حرکت (مثل e2)
- `to`: مقصد حرکت (مثل e4)
- `san`: حرکت در فرمت Standard Algebraic Notation
- `fen_before`: وضعیت قبل از حرکت
- `fen_after`: وضعیت بعد از حرکت
- `meta`: اطلاعات اضافی (JSON)

## 🔒 امنیت

### احراز هویت و مجوزها:
- ✅ استفاده از Laravel Sanctum برای احراز هویت
- ✅ Middleware auth برای محافظت از مسیرها
- ✅ اعتبارسنجی ورودی‌ها با Laravel Validation
- ✅ CSRF Protection فعال

### امنیت داده‌ها:
- ✅ استفاده از Prepared Statements برای جلوگیری از SQL Injection
- ✅ اعتبارسنجی حرکات شطرنج با chess.js
- ✅ محدودیت دسترسی به بازی‌ها فقط برای بازیکنان مجاز

### امنیت real-time:
- ✅ استفاده از Private Channels برای WebSocket
- ✅ احراز هویت WebSocket با Laravel Echo
- ✅ اعتبارسنجی حرکات در سمت سرور

### توصیه‌های امنیتی اضافی:
```php
// اعمال Rate Limiting
Route::middleware(['auth', 'throttle:60,1'])->group(function () {
    // مسیرهای حساس
});

// اعتبارسنجی حرکات
public function handleMove($payload)
{
    // بررسی اینکه آیا کاربر مجاز به حرکت است
    if (!$this->isUserTurn()) {
        throw new UnauthorizedException();
    }
    
    // اعتبارسنجی حرکت با chess.js
    $chess = new Chess($this->game->fen);
    if (!$chess->move($payload['from'] . $payload['to'])) {
        throw new InvalidMoveException();
    }
}
```

## 🚀 توسعه‌های آتی

### ویژگی‌های پیشنهادی کوتاه‌مدت:
1. **سیستم امتیازدهی (ELO Rating)**
   - محاسبه امتیاز بازیکنان
   - رتبه‌بندی جهانی
   - تاریخچه امتیازات

2. **انواع بازی**
   - بازی با محدودیت زمان
   - بازی Blitz (5 دقیقه)
   - بازی Bullet (1 دقیقه)

3. **ویژگی‌های اجتماعی**
   - چت بین بازیکنان
   - سیستم دوستی
   - اشتراک‌گذاری بازی‌ها

### ویژگی‌های پیشنهادی میان‌مدت:
1. **هوش مصنوعی**
   - تحلیل بازی‌ها
   - پیشنهاد حرکت
   - تشخیص اشتباهات

2. **مسابقات**
   - تورنومنت‌های خودکار
   - لیگ‌های فصلی
   - جوایز و گواهینامه‌ها

3. **ویژگی‌های پیشرفته**
   - تحلیل بازی با Stockfish
   - ذخیره و اشتراک‌گذاری بازی‌ها
   - آموزش شطرنج

### ویژگی‌های پیشنهادی بلندمدت:
1. **پلتفرم کامل**
   - اپلیکیشن موبایل
   - API برای توسعه‌دهندگان
   - سیستم پرداخت

2. **هوش مصنوعی پیشرفته**
   - AI برای آموزش
   - تشخیص تقلب
   - تحلیل شخصیت بازیکن

## 🛠️ نصب و راه‌اندازی

### پیش‌نیازها:
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL/PostgreSQL
- Redis (اختیاری)

### مراحل نصب:

1. **کلون کردن پروژه:**
```bash
git clone [repository-url]
cd chess
```

2. **نصب وابستگی‌های PHP:**
```bash
composer install
```

3. **نصب وابستگی‌های JavaScript:**
```bash
npm install
```

4. **تنظیم فایل محیطی:**
```bash
cp .env.example .env
php artisan key:generate
```

5. **تنظیم پایگاه داده:**
```bash
php artisan migrate
php artisan db:seed
```

6. **ساخت فایل‌های frontend:**
```bash
npm run build
```

7. **راه‌اندازی سرور:**
```bash
php artisan serve
```

### تنظیمات محیطی مهم:
```env
# پایگاه داده
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=chess
DB_USERNAME=root
DB_PASSWORD=

# Broadcasting (برای real-time)
BROADCAST_CONNECTION=reverb
REVERB_APP_KEY=your-key
REVERB_APP_SECRET=your-secret
REVERB_APP_ID=your-app-id
REVERB_HOST=127.0.0.1
REVERB_PORT=8080

# Queue
QUEUE_CONNECTION=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```

### دستورات مفید:
```bash
# راه‌اندازی کامل (توسعه)
composer run dev

# تست‌ها
composer run test

# پاک کردن کش
php artisan optimize:clear

# مشاهده صف‌ها
php artisan queue:work
```

## 📞 پشتیبانی

برای گزارش باگ‌ها یا پیشنهادات، لطفاً از سیستم Issues استفاده کنید.

---

**توسعه‌دهنده:** [نام توسعه‌دهنده]  
**نسخه:** 1.0.0  
**آخرین به‌روزرسانی:** 2025
