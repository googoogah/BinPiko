# Інформаційно-аналітична система обліку генерації, споживання та відключень електроенергії в умовах воєнного стану

Цей проект розроблений для моніторингу та аналізу генерації, споживання та відключень електроенергії в умовах воєнного стану. Він дозволяє оперативно збирати, обробляти та аналізувати дані щодо електричних мереж для прийняття ефективних управлінських рішень.

##  Ми розпочали роботу над нашим проєктом у середовищі розробки Bubble. Цей етап включав створення основних сторінок сайту, структури та дизайну. Bubble дозволив нам швидко протестувати ідеї та представити першу версію продукту.

Ми створили простий, інтуїтивний дизайн, що відповідає вимогам користувачів.
Головне меню: Додали вкладки для основних функцій сайту:
Споживання: Можливо, ця вкладка відповідає за моніторинг використання електроенергії.
Відключення: Інформація про поточні або заплановані відключення.
Генерація: Ймовірно, моніторинг генерації електроенергії.
About: Сторінка з інформацією про проєкт.

На головній сторінці розмістили блок для вводу API-ключа, що дозволяє користувачам отримувати дані про стан електромережі. Кнопка "Оновити" реалізована для синхронізації даних після вводу ключа.

У верхній частині сайту додали кнопку "Log in", яка дозволяє користувачам входити в систему. Реалізовано: Авторизацію за допомогою електронної пошти та пароля. Можливо, передбачено функцію реєстрації нових користувачів.

Кнопка "Help?" веде до документації або сторінки підтримки, яка пояснює, як використовувати сайт.

Перевіряли роботу кожної вкладки для забезпечення стабільності. Тестували процес введення API-ключа, щоб упевнитися, що дані коректно передаються на сервер і відображаються користувачам.

## Після аналізу функціональних обмежень Bubble ми вирішили перейти на більш гнучке рішення, використовуючи PHP для розробки бекенду та MySQL як базу даних.
# Недоліки Bubble
Обмежена гнучкість
Bubble пропонує інтуїтивний конструктор, але він обмежує можливості для складних або унікальних рішень. Користувачі залежать від функцій, передбачених платформою, що ускладнює створення специфічних або інноваційних функціоналів.
Продуктивність
Програми, створені на Bubble, часто мають проблеми з продуктивністю, особливо під час обробки великих обсягів даних або при високих навантаженнях на сервер. Вартість
Використання Bubble може стати дорогим, особливо якщо потрібні розширені функції чи більші ресурси для масштабування. Залежність від платформи
Наша програма повністю залежить від Bubble. У разі проблем із доступом до платформи, зміни політики чи збоїв, весь проєкт може опинитися під загрозою. Обмежений доступ до коду
Bubble є платформою з низьким рівнем коду (low-code), що обмежує доступ до справжнього коду проєкту. Це ускладнює кастомізацію, інтеграцію з зовнішніми системами та створення високопродуктивних рішень. Складність міграції
Дані й логіка Bubble важко перенести на інші платформи чи системи, що створює проблеми під час масштабування чи змін архітектури.

# Переваги PHP у поєднанні з MySQL
Гнучкість і контроль
PHP надає повний контроль над кодом, що дозволяє створювати будь-які кастомізовані рішення, враховуючи особливості вашого проєкту. Масштабованість
PHP та MySQL забезпечують можливість легкої інтеграції нових функцій і підтримують високі навантаження, що важливо для масштабування. Відкритий вихідний код
PHP та MySQL є безкоштовними та з відкритим кодом, що знижує витрати на розробку та дозволяє використовувати величезну кількість бібліотек, фреймворків та інструментів. Підтримка великих обсягів даних
MySQL — це потужна реляційна база даних, яка забезпечує швидкий доступ до великих обсягів даних і дозволяє виконувати складні запити. Портативність
PHP працює на багатьох операційних системах і серверах. Це забезпечує гнучкість у виборі хостингу та інфраструктури. Широка підтримка спільноти
PHP має велику спільноту розробників, що гарантує наявність документації, прикладів коду, форумів та готових рішень. Ефективність продуктивності
На відміну від Bubble, проєкти на PHP працюють безпосередньо на сервері, що підвищує швидкість та знижує затримки. Легкість інтеграції
PHP дозволяє легко інтегрувати сторонні API, системи управління вмістом (CMS), системи аналітики, платіжні шлюзи тощо.

## Ми створили базову структуру нового проєкту, включаючи директорії для PHP-файлів, статичних ресурсів (CSS, JavaScript, зображення) та конфігурацій. Цей крок заклав основу для нової архітектури сайту.
# Розробка базової структури сайту
Створено архітектуру проєкту з розподілом файлів за директоріями: PHP-файли для бекенду. CSS для стилізації. Конфігураційні файли для налаштування бази даних і сервера. Адмін-панель

Реалізовано інтерфейс для адміністратора з навігацією: Доступ до розділів: "Схема ліній передач", "Діаграми", "Графіки", "Перегляд БД", "Робота з БД". Кнопка для виходу з системи. Функціонал для додавання користувачів






