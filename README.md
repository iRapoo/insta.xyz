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
    
