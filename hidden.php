<?php

print("SALUT");
//$search = new search();
//$search->run();

Class search {

	const ROOT = "http://192.168.1.16/.hidden/";
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
						echo "flag : ".file_get_contents(self::ROOT.implode("", $this->way).'README');
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
