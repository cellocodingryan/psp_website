<?php
// pages start from 0
class pagesearch {
    public function __construct($array,$num_page_options = 5,$amount_per_page = 10)
    {
        $this->array = $array;
        $this->num_page_options = $num_page_options;
        $this->amount_per_page = $amount_per_page;
    }

    /**
     * Modifies array to only contain items that contain the given string
     * @param $val
     */
    public function search($val) {
        if ($val == "") {
            return;
        }
        $new_array = array();
        foreach($this->array as $i) {
            $current_val = $i;
            if (is_array($i)) {
                $current_val = json_encode($i);
            }
            if (!strpos(strtolower($current_val),strtolower($val))) {

                continue;
            }
            $new_array[] = $i;
        }
        $this->array = $new_array;
    }
    public function num_page_options($n) {
        $this->num_page_options = $n;
    }
    public function set_page($page) {
        $this->page = intval($page);
    }
    public function get_page_options($pageoptions = array()) {
        if (count($pageoptions) >= $this->num_page_options) {
            return $pageoptions;
        }
        if (count($pageoptions) == 0) {
            $pageoptions[] = $this->page;
        }
        $start_size = count($pageoptions);
        $next_up = $pageoptions[count($pageoptions)-1] + 1;
        $next_down = $pageoptions[0] - 1;

        if ($next_up*$this->amount_per_page < count($this->array)) {
            $pageoptions[] = $next_up;
        }
        if ($next_down >= 0) {
            array_splice($pageoptions,0,0,$next_down);
        }
        if ($start_size >= count($pageoptions)) {
            return $pageoptions;
        }

        return $this->get_page_options($pageoptions);


    }
    public function get_array() {
        return array_slice($this->array,$this->page*$this->amount_per_page,intval($this->amount_per_page));
    }
    private $amount_per_page;
    private $num_page_options;
    private $page =0;
    private $array;
}