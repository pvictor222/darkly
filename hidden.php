<?php

print("Let's search this flag!<br/>");
$hidden_flag = new hidden_flag();
$hidden_flag->run();
//$search = new search();
//$search->run();

Class hidden_flag {
	const URL = "http://192.168.1.35/";
	const FOLDER = ".hidden/";
	const FULL_URL = self::URL . self::FOLDER;
	const NBR_OF_FILES = 26;

	private string $tree;
	private int $i;

	/*
	**	Get the full directory tree
	*/

	public function __Construct() {
		print("Searching in " . self::FULL_URL . "<br/>");
		$this->tree = file_get_contents(self::FULL_URL);
		//print_r($this->tree);
	}

	public function run() {
		$i = 0;
		$read_me = file_get_contents(self::FULL_URL."README");
		print("<br/>salut ".$read_me."<br/>");
		preg_match_all('#<a href="(.*)">(.*)</a>#', $this->tree, $rep);
		print(split('<', $rep[0][1]));
		$url = self::FULL_URL.split('<', split('>', $rep[0][1])[1])[0];
		print_r($url);
		while ($i < self::NBR_OF_FILES) {

			//print("<br/>i = " . $i . " / url = " . file_get_contents(self::FULL_URL));
			$i++;
		}
	}

}

Class search {

	const ROOT = "http://192.168.1.35/.hidden/";
	const NB_PAR_PAGE = 26;

	/**
	 * @is_good integer
	 */
	private $i = 0;

	/**
	 * @html String
	 */
	private $html;

	/**
	 * @way array
	 */
	private $way = ["", "", ""];

	/**
	 * @possibilities array
	 */
	private $possibilities = [];


	public function __Construct() {

		$this->html = file_get_contents(self::ROOT);
	}

	private function get_way($type, $integer) {

		if ($type == 0)
			$url = self::ROOT;
		if ($type == 1)
			$url = self::ROOT.$this->way[0].'/';
		if ($type == 2)
			$url = self::ROOT.$this->way[0].'/'.$this->way[1].'/';

		$this->html = file_get_contents($url);
		preg_match_all('#<a href="(.*)">(.*)</a>#', $this->html, $rep);
		$this->possibilities = $rep[1];
		unset($this->possibilities[0]);
		$this->possibilities = array_values($this->possibilities);
		return ($this->possibilities[$integer]);
	}

	public function run() {

		$i = 0;
		while ($i <= self::NB_PAR_PAGE) {
			$this->way[0] = $this->get_way(0, $i);
			$j = 0;
			while ($j < self::NB_PAR_PAGE) {
				$this->way[1] = $this->get_way(1, $j);
				$k = 0;
				while ($k < self::NB_PAR_PAGE) {
					$this->way[2] = $this->get_way(2, $k);
					if (is_numeric(file_get_contents(self::ROOT.implode("", $this->way).'README')[0])) {
						echo "flag : ".file_get_contents(self::ROOT.implode("", $this->way).'README'). "in dir ".$i." in file ".$j."in flie".$k;
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
