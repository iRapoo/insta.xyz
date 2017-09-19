<?

define('IF_CON', "{% if ");
define('IF_ELSE', "{% else %}");
define('IF_END', "{% endif %}");

define('CON_S', "{% ");
define('CON_F', " %}");

define('STAMP', "Разработан на платформе Quenix Kernel();");
define('YEAR', (($_config->_getManifest()->year==date("Y")) ? date("Y") : $_config->_getManifest()->base->year.'-'.date("Y")));

session_start();

class Kernel extends Manifest
{
	
	var $values;
	var $if_val;
    var $html;

    function _setDefine(){
    	foreach($this->_getManifest()->base as $keys => $value) {
			$key = CON_S.mb_strtolower($keys).CON_F;
			$this->values[$key] = $value;
		}
    }
	
	function html($tpl_name) {
      if(empty($tpl_name) || !file_exists($tpl_name)){
        return false;
      } else {
        $this->html = join(file($tpl_name));
      }
    }
	
	function set_constant($key, $var){
		$this->if_val[$key] = !empty($var) ? true : false;
		$key = CON_S.mb_strtolower($key).CON_F;
		$this->values[$key] = $var;
	}
	
	function set_if($key,$val){
		$this->if_val[$key] = $val;
	}
	
	function clear_con($start_str) {
		preg_match("/".IF_CON."(.+?)".CON_F."/", $start_str, $m);
		$final_str = str_replace($m[0], "", $start_str);
		$final_str = str_replace(IF_ELSE, "", $final_str);
		$final_str = str_replace(IF_END, "", $final_str);
		return $final_str;
	}

	function get_html() {
		if(!empty($this->values)){
			$key = CON_S.'stamp'.CON_F; //Creat define STAMP
			$this->values[$key] = STAMP; //-----------------
			$key = CON_S.'year'.CON_F; //Creat define YEAR
			$this->values[$key] = YEAR; //-----------------

			foreach($this->values as $find => $replace) {
				$this->html = str_replace($find, $replace, $this->html);
			}
		}

		if(($num = substr_count($this->html, IF_CON)) != 0) {
			for($i=0;$i<$num;$i++) {
				
			
				$first_pos = stripos($this->html, IF_CON);
				$last_pos = stripos($this->html, IF_END)+strlen(IF_END);

				$start_str = substr($this->html, $first_pos, ($last_pos-$first_pos));
				$start_str_n = str_replace(array("\n","\r"), '', $start_str);

				preg_match('/\{\% if (.+?) \%\}/', $start_str_n, $m);
				$if_exp = $m[1];

				switch($if_exp) {
					case "LOGIN":
						$if_fin = (isset($_SESSION['id'])) ? true : false;
						break;
					case "ADMIN":
						$if_fin = (isset($_SESSION['rank']) and $_SESSION['rank'] == "a") ? true : false;
						break;
					case "MODER":
						$if_fin = (isset($_SESSION['rank']) and $_SESSION['rank'] == "m") ? true : false;
						break;
					case "USER":
						$if_fin = (isset($_SESSION['rank']) and $_SESSION['rank'] == "u") ? true : false;
						break;
					case "ROOT":
						$if_fin = (isset($_SESSION['rank']) and $_SESSION['rank'] == 'a' or isset($_SESSION['rank']) and $_SESSION['rank'] == 'm') ? true : false;
						break;
					case "MAN":
						$if_fin = (isset($_SESSION['sex']) and $_SESSION['sex'] == 0) ? true : false;
						break;
					case "WOM":
						$if_fin = (isset($_SESSION['sex']) and $_SESSION['sex'] == 1) ? true : false;
						break;
					default:
					
						foreach($this->if_val as $key => $val) {

							if($if_exp == $key) {
								$if_fin = $val;
								break(2);
							}
						}
					
						echo "ERROR 15: Условное выражение не найдено! Выражение: ".$if_exp." из строки ".$start_str."<br/>";
						preg_match("/".IF_CON.CON_F."(.+?)".IF_END."/", $start_str_n, $m);
						$finish_str = str_replace($m[1], "", $start_str_n);
						$finish_str = $this->clear_con($finish_str);
						break;
				}

				if(isset($if_fin))
				if(substr_count($start_str, IF_ELSE) != 0) {
					if($if_fin) {
						preg_match("/".IF_ELSE."(.+?)".IF_END."/", $start_str_n, $m);
						$finish_str = str_replace($m[1], "", $start_str_n);
						$finish_str = $this->clear_con($finish_str);
					} else {
						preg_match("/".CON_F."(.+?)".IF_ELSE."/", $start_str_n, $m);
						$finish_str = str_replace($m[1], "", $start_str_n);
						$finish_str = $this->clear_con($finish_str);
					}
				} else {
					if($if_fin) {
						$finish_str = $this->clear_con($start_str);
					} else {
						preg_match("/".CON_F."(.+?)".IF_END."/", $start_str_n, $m);
						$finish_str = str_replace($m[1], "", $start_str_n);
						$finish_str = $this->clear_con($finish_str);
					}
				}
				$this->html = str_replace($start_str, $finish_str, $this->html, $count);
				$num-=$count-1;
			}
		}
		return $this->html;
	}

	function _setHtml($tpl_name){ // <-- enter templates
		$this->_setDefine(); // <-- set define vars "manifest->base"
    	$this->html($tpl_name);
    }

	function _getHtml(){ // <-- print templates
    	return $this->get_html();
    }

    function _setVar($key,$var){ // <-- new constant
    	$this->set_constant($key, $var);
    }

    function _setIf($key,$val){ // <-- new if
    	$this->set_if($key,$val);
    }

}