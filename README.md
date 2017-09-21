# Kernel

**Создание представления**

Чтобы создать новое представление нужно в директории _views_
создать папку и в ней создать файл _core.php_.
**Kernel** сам определит представление. Проверить работу представления можно перейдя
 по адресу `domain/{view_name}`. Представление главной страницы всегда должно быть`base`.<br>
 
 **Конфигурация проекта**
 
 Главный файл конфигурации **Kernel** - `manifest.json` он находится в директории `core`
  и имеет вид json дерева.
  
      {
        "base": {
          "name": "Project Kernel();",
          "version": "3.0.3.f0",
          "year": "2015",
          "company": "Quenix Software",
          "clanguage": "ru",
          "ctype": "UTF-8"
        },
        "module": [
          "db_connect", "kernel_tpl", "generate"
        ],
        "_status": {
          "enabled": true
        },
        "assets": {
          "jquery": "3.x",
          "template": "template.tpl.html",
          "css": [
            "css/bootstrap-responsive.css",
            "css/style.css"
          ],
          "js": [
            "js/bootstrap.min.js"
          ]
        },
        "db_config": {
          "db_host": "localhost",
          "db_user": "root",
          "db_pass": "",
          "db_name": "project_db"
        }
      }
 
В Manifest разрешается добавлять новые ветки и параметры. 
В представлениях в любой мамент можно получить любой параметр следующим способом<br>
    
    $_config->_getManifest()->{get_param};
    
Для подключения JavaScript и CSS файлов в представлениях

    // Подключение js файла
    $_config->js[] = _ASSETS_."/js/test.js";
        или
    $_config->js[] = "test.js";
    
    // Подключение css файла
    $_config->css[] = _ASSETS_."/css/test.css";
        или
    $_config->js[] = "test.css";
    
**ORM Atom**

Для работы с **ORM Atom** необходимо создать модель таблицы в директроии `model`

    <?php
    
    class users extends Atom
    {
        public $id;
        public $login;
        public $password;
    }
    
Для работы с **ORM Atom** в представлениях необходимо указать конфигурацию MySQLi 
в начале файла `core.php`

    Atom::setup($_config->_getMySQLi());
    
После необходимо показать с какими моделями будем работать

    Atom::model("users");
    
Теперь можно получить любую запись из подключенных моделей, например:

    //Выведет на экран логин пользователя c `id` = 1 из таблицы `users`
    $user = users::findById(1);
    echo $user->login;
    
Для получения всех данных с сортировкой можно использовать `users::findAll()`

    /*
     * Пример результата:
     * ID: 1 | Логин: first | Пароль: 123456789
     * ID: 2 | Логин: second | Пароль: 987654321
     */
    foreach (users::findAll("ORDER BY `id`") as $user){
        if(!empty($user)) {
            $_config->body .= "ID: " . $user->id;
            $_config->body .= " | Логин: " . $user->login;
            $_config->body .= " | Пароль: " . $user->password . "<br>";
        }
    }
    
Для получения данных по тегу можно использовать `users::findByTag()`

    /*
     * Пример результата:
     * ID: 1 | Логин: first | Пароль: 123456789
     */
    foreach (users::findByTag("login", "first", "ORDER BY `id`") as $user){
        if(!empty($user)) {
           $_config->body .= "ID: " . $user->id;
           $_config->body .= " | Логин: " . $user->login;
           $_config->body .= " | Пароль: " . $user->password . "<br>";
        }
    }
    
Чтобы обновить запись в таблице можно использовать метод `update()`

    //Запись под `id` = 1 получит новый логин "first" -> "second"
    $user = new users();
    
    $user->id = 1;
    $user->login = "second";
    
    echo $user->update() ? "Успешно" : "Неудача";
    
По этому же принцепу действует метод добавления `insert()`

    //Добавится запись под `id` = 3 и получит логин "third"
    $user = new users();
        
    $user->id = 3;
    $user->login = "third";
        
    echo $user->insert() ? "Успешно" : "Неудача";
    
Для удаления записи необходимо использовать метод `delete()`

    //Метод удалит запись с `id` = 3
    users::findById(3)->delete();