<?php
/*************************
 * atom_orm.php v1.0.1     **
 * for project Kernel    **
 * Rapoo (c) 19.09.2017  **
 *************************/

class Atom extends Manifest
{

    private static $db;
    private static $stack;

    static public function setup(mysqli $dbi, $enc = "utf8"){
        if (is_object($dbi)){
            self::$db = $dbi;
            self::$stack = new SplStack();
            return self::setEncoding($enc);
        }else{
            throw new Exception("Параметр $dbi не является объектом mysqli", 1);
            return false;
        }
    }

    static function setEncoding($enc){
        $result = self::$db->query("SET NAMES '$enc'");
        self::$stack->push("SET NAMES '$enc' [".($result ? "TRUE" : self::getError())."]");
        return $result ? true : false;
    }

    static function getError(){
        return self::$db->error." [".self::$db->errno."]";
    }

    private static function escape($string) {
        return mysqli_real_escape_string(self::$db,$string);
    }

    private static function _getVars(){
        return array_filter(get_class_vars(get_called_class()),function($elem){
            if (!is_object($elem)) return true;
        });
    }

    static function findById($id){
        if (is_numeric($id)){												//Если число, то ищем по идентификатору
            $query = "SELECT * FROM `".get_called_class()."` WHERE `".key(self::_getVars())."` = $id LIMIT 1";
            $result = self::$db->query($query);								//Отправляем запрос
            self::$stack->push($query." [".$result->num_rows."]");			//Заносим запрос в стек
            if ($result->num_rows == 1){									//Если запрос вернул строку
                $row = $result->fetch_object();								//Строку запроса в класс
                $cName = get_called_class();								//Получем название класса
                $rClass = new $cName();										//Создаем экземпляр класса
                foreach ($row as $key => $value) $rClass->$key = $value;	//Переносим свойства класса
                return $rClass;												//Возвращаем класс
            } else return false;											//Если строка не найдена, то ложь
        } else return false;												//Если не число возвращаем ложь
    }

    public function update(){									//Сохраняем объект - UPDATE
        $id = key(self::_getVars());						//Получаем идентификатор
        if (!isset($this->$id) || empty($this->$id)) return $this->Add();	//Если пусто, добавляем
        $query = "UPDATE `".get_called_class()."` SET ";	//Формируем запрос
        $columns = self::_getVars();						//Получем колонки таблицы
        $Update = array();									//Массив обновления
        foreach ($columns as $k => $v) {					//перебираем все колонки
            if ($id != $k)    //Убираем идентификатор из запроса
                $Update[] = "`".$k."` = ".self::RenderField($this->$k);	//Оборачиваем в оболочки
        }
        $query .= join(", ",$Update);						//Дополняем запрос данными
        $query .= " WHERE `$id` = ".self::escape($this->$id)." LIMIT 1";	//Дополняем запрос уточнениями
        $result = self::$db->query($query);
        self::$stack->push($query." [".($result ? "TRUE" : self::getError())."]");	//Стек результатов
        return ($result) ? true : false;					//Возвращаем ответ
    }

    private static function RenderField($field){
        $r = "";															//Строка для возвращения
        switch (gettype($field)) {											//Селектор типа передаваемого поля
            case "integer":	case "float":									//Тип int или float
            $r = $field;
            break;
            case "NULL": 	$r = "NULL";  break;							//Тип NULL
            case "boolean": $r = ($field) ? "true" : "false"; break;		//Тип boolean
            case "string":													//если тип строковой
                $p_function = "/^[a-zA-Z_]+\((.)*\)/";						//Шаблон на функцию
                preg_match($p_function, $field,$mathes);					//Поиск соврадений на функцию
                if (isset($mathes[0])){										//Совпадения есть, это функция
                    $p_value = "/\((.+)\)/";								//Шаблон для выборки значения функции
                    preg_match($p_value, $field,$mValue);					//Выборка значений
                    if (isset($mValue[0]) && !empty($mValue[0])){			//Если данные между скобок существуют и не пустые
                        $pv = trim($mValue[0],"()");						//Убираем скобки по концам
                        $pv = "'".self::escape($pv)."'";					//Экранируем то что в скобках
                        $r = preg_replace($p_value, "($pv)" , $field);		//Меняем под функцию
                    }
                    else $r = $field;										//Возвращаем функцию без параметров
                }
                else $r = "'".self::escape($field)."'";						//Если просто строка экранируем
                break;
            default: $r = "'".self::escape($field)."'";	break;				//По умолчанию экранируем
        }
        return $r;															//Возвращаем результат
    }

    public function insert(){									//Добавляем объект - INSERT
        $query = "INSERT INTO `".get_called_class()."` (";	//Подготавливаем запрос
        $columns = self::_getVars();						//Получем колонки
        $q_column = array();								//Массив полей для вставки
        $q_data = array();									//Массив данных для вставки
        foreach ($columns as $k => $v){						//Пробегаемся по столбцам
            $q_column[] = "`".$k."`";						//Обертываем в кавычки
            $q_data[] 	= self::RenderField($this->$k);		//Рендерим обертку для данных
        }
        $query .= join(", ",$q_column).") VALUES (";		//Дополняем запрос столбцами
        $query .= join(", ",$q_data).")";					//Дополняем запрос данными
        $result = self::$db->query($query);					//Делаем запрос
        $insert_id = self::$db->insert_id;					//Получаем идентификатор вставки
        self::$stack->push($query." [".($result ? $insert_id : self::getError())."]");	//Стек результатов
        return ($result) ? $insert_id : false;				//Возвращаем ответ
    }

    public function delete(){								//Удаляем объект - DELETE
        $id = key(self::_getVars());						//Выбираем идентификатор
        if (!empty($this->$id)){							//Если идентификатор не пустой
            $qDel = "DELETE FROM `".get_called_class()."` WHERE `$id` = ".$this->$id." LIMIT 1";
            $rDel = self::$db->query($qDel);				//Запрос на удаление
            self::$stack->push($qDel." [".($rDel ? "TRUE" : self::getError())."]");	//Стек результатов
            return $rDel ? true:false;						//Возвращаем ответ
        } else return false;								//Отрицательный ответ
    }

}