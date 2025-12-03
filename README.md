# CarSeller website

## Tree of the project

hw/
├── app/                        # Основна логика (Private)
│   ├── controllers/            # Обработка на заявки
│   │   ├── AdminController.php
│   │   └── CarController.php
│   │
│   ├── models/                 # Работа с база данни
│   │   └── CarModel.php
│   │
│   └── views/                  # HTML Шаблони
│       ├── admin/              # Админ панел
│       │   ├── create.php
│       │   ├── edit.php
│       │   ├── index.php
│       │   └── login.php
│       │
│       ├── car_detail.php      # Детайлен изглед
│       └── car_list.php        # Списък с коли
│
└── public/                     # Публичен достъп (Public)
    ├── css/
    │   └── style.css
    │
    ├── images/                 # Качени снимки
    │
    ├── .htaccess               # Настройки за URL
    └── index.php               # Router (Входна точка)

