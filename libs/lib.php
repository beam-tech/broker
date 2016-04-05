<?
	/**
	 * возвращает SHA1-хэш строку
	 * @param string $string - строка, которую необходимо зашифровать
	 * @param string $salt - соль
	 * @param string $numOfIter - кол-во итераций
	 *
	 * @return string $string хэш строка
	 */
	function getHash($string, $salt, $numOfIter = 1){
		for ($i = 0; $i < $numOfIter; $i++)
			$string = sha1($string . $salt);
		return $string;
	}

	/**
	 * Возвращает сгенерированную соль
	 * @param $n - кол-во символов	
	 *
	 * @return string $salt - соль
	 */
	function getSalt($n = 11){
		mb_internal_encoding("UTF-8");
		$salt = str_replace('=', '', base64_encode(md5(microtime())));
		$salt = mb_substr($salt,1,$n);
		return $salt;
	}
	/**
	 * Ожидание данных типа число().
	 */
	function clearInt($int){
		if(!preg_match('/^[0-9]+$/',$int))
			return false;
		return $int;
	}
	/**
	 * Ожидание данных типа сторока.
	 */
	function clearStr($str) {
		if(!preg_match('!^[a-zA-Z0-9]+$!',$str))
			return false;
		return $str;
	}
	//YYYY-MM-DD 
	function clearDate($date){
		if (preg_match('/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/',$date))	
			return $date;
        else
			return false;
	}
	// dead code
	function clearCur($str) {
		if ($str === '')
			return 0;
		if(!preg_match("!^[0-9]+$!",$str))
			return false;
		return $str;
	}

	function checkData(array $curs){
		foreach ($curs as $cur) {
			if($cur === false)
				return false;
		}
		return true;
	}