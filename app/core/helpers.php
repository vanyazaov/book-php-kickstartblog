<?php

	/**
	 * Преобразование символов HTML в сущности.
	 *
	 * @param  string  $value
	 * @return string
	 */
    function e ($value) {
        return htmlentities($value, ENT_QUOTES, 'UTF-8', false);
    }
