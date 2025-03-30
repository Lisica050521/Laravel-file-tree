# 🌳 Laravel File Tree Project

Проект для работы с древовидной структурой данных. Реализует:
- Хранение иерархических структур в PostgreSQL
- Получение данных в виде дерева/плоского списка
- Добавление/удаление элементов с каскадным удалением

### 1. Установка
```bash
git clone https://github.com/Lisica050521/Laravel-file-tree
cd laravel-file-tree
composer install
```

### 2. Настройка БД
1. Создайте БД PostgreSQL:
```bash
psql -U postgres -c "CREATE DATABASE laravel_file_tree;"
psql -U postgres -c "CREATE USER irina WITH PASSWORD '123';"
psql -U postgres -c "GRANT ALL PRIVILEGES ON DATABASE laravel_file_tree TO irina;"
```

2. Настройте `.env`:
```ini
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel_file_tree
DB_USERNAME=irina
DB_PASSWORD=123
```

### 3. Запуск
```bash
php artisan migrate
php artisan serve --port=8000
```

## 📚 API Endpoints

### Получение данных
```http
GET http://127.0.0.1:8000/api/tree
```
```json
[
  {
    "id": 1,
    "name": "Root",
    "children": [
      {
        "id": 2,
        "name": "Child 1",
        "children": [...]
      }
    ]
  }
]
```

```http
GET http://127.0.0.1:8000/api/flat
```
```json
[
  {"id": 1, "name": " Root", "level": 0},
  {"id": 2, "name": "-- Child 1", "level": 1}
]
```

### Управление данными
```http
POST http://127.0.0.1:8000/api/nodes
Body: {"name": "New Node", "parent_id": 1}

DELETE http://127.0.0.1:8000/api/nodes/{id}
```

## 🧪 Тестирование

### Через cURL
```bash
# Получить дерево
curl http://127.0.0.1:8000/api/tree

# Добавить узел
curl.exe -X POST "http://127.0.0.1:8080/api/nodes" `
  -H "Content-Type: application/json" `
  -d '{\"name\":\"New Node\", \"parent_id\":1}'
```

### Через Tinker
```bash
php artisan tinker
```
```php
// Создать тестовые данные
$root = App\Models\Node::create(['name' => 'Root']);

// Получить плоский список
App\Models\Node::getFlatTree();
```

## 🏗 Архитектура

### Модель Node
```php
protected $fillable = ['name', 'parent_id'];

// Связи
public function parent(): BelongsTo
public function children(): HasMany

// Методы
public static function getTree(?int $parentId = null): array
public static function getFlatTree(?int $parentId = null, int $level = 0): array
```

## 📝 Примечания
- Реализовано без сторонних пакетов
- Каскадное удаление через `onDelete('cascade')`
- Для сложных запросов рекомендуется добавить индексы
