<?php

print("Let's search this flag!<br/>");
$hidden_flag = new hidden_flag();
$hidden_flag->run();

Class hidden_flag {
	const URL = "http://192.168.1.35/";
	const FOLDER = ".hidden/";
	const FULL_URL = self::URL . self::FOLDER;
	const NBR_OF_FILES = 26;

	private string $tree;
	// All the subdirectories in a path
	private $explore_path = ["", "", ""];
	private $subdirectories = [];

	/*
	**	Get the full directory tree
	*/

	public function __Construct() {
		print("Searching in " . self::FULL_URL . "<br/>");
		$this->tree = file_get_contents(self::FULL_URL);
	}

	/*
	**	Get all possibilities depending on which depth we're at
	*/

	private function get_path($depth, $i) {
		if ($depth == 0)
			$url = self::FULL_URL;
		if ($depth == 1)
			$url = self::FULL_URL.$this->explore_path[0].'/';
		if ($depth == 2)
			$url = self::FULL_URL.$this->explore_path[0].'/'.$this->explore_path[1].'/';
		$this->html = file_get_contents($url);
		preg_match_all('#<a href="(.*)">(.*)</a>#', $this->html, $rep);
		$this->possibilities = $rep[1];
		unset($this->possibilities[0]);
		$this->possibilities = array_values($this->possibilities);
		return ($this->possibilities[$i]);
	}

	/*
	**	Explore all until the file content of a README starts with a number
	*/

	public function run() {
		$i = 1;
		while ($i < self::NBR_OF_FILES) {
			$this->explore_path[0] = $this->get_path(0, $i);
			$j = 0;
			while ($j < self::NBR_OF_FILES) {
				$this->explore_path[1] = $this->get_path(1, $j);
				$k = 0;
				while ($k < self::NBR_OF_FILES) {
					$this->explore_path[2] = $this->get_path(2, $k);
					if (is_numeric(file_get_contents(self::FULL_URL.implode("", $this->explore_path).'README')[0])) {
						echo "flag : ".file_get_contents(self::FULL_URL.implode("", $this->explore_path).'README'). "was found at path ".self::FULL_URL.implode("", $this->explore_path);
						return (0);
					}
					$k++;
				}
				$j++;
			}
			$i++;
		}
	}

}

?>
