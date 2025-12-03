🚗 Система за управление на Автопарк

Това е уеб базирано приложение за управление на автомобилен инвентар, разработено по архитектурата MVC (Model-View-Controller). Проектът разделя логиката на две основни части: публичен каталог за клиенти и защитен административен панел за управление.

📂 Структура на Проекта

/
├── app/                            # 🔒 Backend логика (недостъпна от браузъра)
│   ├── controllers/                # Обработват заявките
│   │   ├── AdminController.php     # Админ логика (Вход, Добавяне, Редакция)
│   │   └── CarController.php       # Публична логика (Каталог, Детайли)
│   ├── models/                     # Връзка с базата данни
│   │   └── CarModel.php            # CRUD операции (PDO/MySQL)
│   └── views/                      # HTML Шаблони
│       ├── admin/                  # Панел за управление
│       ├── car_detail.php          # Страница на автомобил
│       └── car_list.php            # Начален каталог
│
└── public/                         # 🌍 Frontend (Входна точка)
    ├── css/                        # Стилове
    ├── images/                     # Качени снимки
    ├── .htaccess                   # URL пренаписване (Pretty URLs)
    └── index.php                   # Главен рутер (Router)


✨ Функционалности

🏠 Публична част

Каталог: Разглеждане на всички налични автомобили с филтър за статус (Наличен/Продаден).

Детайлен преглед: Пълна техническа информация, галерия със снимки и описание.

Адаптивен дизайн: Оптимизиран изглед за мобилни устройства и десктоп.

🔑 Админ панел

Автентикация: Защитен вход с парола (Сесии).

Управление (CRUD):

Добавяне на нови автомобили.

Редактиране на информация и статус.

Изтриване на записи.

Галерия: Поддръжка на множество снимки (разделени със запетая или нов ред).

Статистика: Бърз преглед на наличностите в табличен вид.

🚀 Инсталация и Настройки

1. База данни

Създайте база данни с име autopark и изпълнете следната SQL заявка за създаване на таблицата:

CREATE TABLE `cars` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `make` varchar(50) NOT NULL,
  `model` varchar(50) NOT NULL,
  `year` int(11) NOT NULL,
  `mileage` int(11) DEFAULT 0,
  `price` decimal(10,2) NOT NULL,
  `engine_type` varchar(50) DEFAULT NULL,
  `transmission_type` varchar(50) DEFAULT NULL,
  `fuel_consumption_city` decimal(4,1) DEFAULT NULL,
  `fuel_consumption_highway` decimal(4,1) DEFAULT NULL,
  `color` varchar(30) DEFAULT NULL,
  `extras` text DEFAULT NULL,
  `comments` text DEFAULT NULL,
  `image_url` text DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


2. Конфигурация

Уверете се, че настройките за връзка в app/models/CarModel.php съвпадат с вашия MySQL сървър:

$host = 'localhost';
$db   = 'autopark';
$user = 'root';
$pass = '';


3. Стартиране

Поставете папката hw в основната директория на вашия сървър (напр. htdocs за XAMPP).

Уверете се, че модулът mod_rewrite е включен в Apache.

Отворете в браузъра: http://localhost/hw/public/

🛠 Технологии

Backend: PHP 7.4+ (PDO, Sessions)

Frontend: HTML5, CSS3 (Flexbox/Grid), JavaScript

Database: MySQL / MariaDB
