<?php
namespace App\Helper;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use DateTime;
use Carbon\Carbon;
/**
 * Description of Helper
 *
 * @author huydk
 */
class Helper {

    public function __construct()
    {
        $this->carbon = new \Carbon\Carbon();
    }

    public function get_frist_day_of_month($date){
        $date = $this->carbon->createFromFormat('Y-m-d', $date); // 2015-07-02
        return $date->startOfMonth()->toDateString();
    }

    public function get_end_day_of_month($date){
        $date = $this->carbon->createFromFormat('Y-m-d', $date); // 2015-07-02
        return $date->endOfMonth()->toDateString();
    }

    public function get_frist_day_of_week($date){
        $date = $this->carbon->createFromFormat('Y-m-d', $date); // 2015-07-02
        return $date->startOfWeek()->toDateString();
    }

    public function get_end_day_of_week($date){
        $date = $this->carbon->createFromFormat('Y-m-d', $date); // 2015-07-02
        return $date->endOfWeek()->toDateString();
    }
    // To get the first week of the day we can do this
    // format Y-m-d <=> MONDAY
    public function get_frist_day_of_week_now(){
        return $this->carbon->now()->startOfWeek()->toDateString();
    }

    // To get the last week of the day we can do this format Y-m-d  <=> SUNDAY
    public function get_end_day_of_week_now(){
        return $this->carbon->now()->endOfWeek()->toDateString();
    }

    // To get the first month of the day we can do this
    public function get_frist_day_of_month_now(){
        return $this->carbon->now()->startOfMonth()->toDateString();
    }

    /**
     * To get the end month of the day we can do this
     */
    public function get_last_day_of_month_now(){
        return $this->carbon->now()->endOfMonth()->toDateString();
    }

    /**
     * Hàm đọc dữ liệu từ file
     * @param $file
     * @param bool $convert_to_array
     * @return bool|mixed|string
     */
    public function get_file_data($file, $convert_to_array = true)
    {
        $file = @file_get_contents($file);
        if (!empty($file)) {
            if ($convert_to_array) {
                return json_decode($file, true);
            }
            return $file;
        }
        return false;
    }
    /**
     * Hàm này sẽ hỗ trợ chuyển đổi dữ liệu khi dùng json encode sang dạng dễ đọc.
     * Mặc định json_encode thì sẽ ra string dính liền với nhau, khi chúng ta ghi ra file nhìn sẽ rất khó.
     * Dùng hàm này thì lúc ghi dữ liệu ra file, nó sẽ ở dạng json giúp dễ đọc hơn.
     * @param $data
     * @return string
     */
    public function json_encode_prettify($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }

    /**
     * hàm ghi dữ liệu
     * @param $path
     * @param $data
     * @param $json
     * @return bool|mixed
     * @author Huydk
     */
    function save_file_data($path, $data, $json = true)
    {
        try {
            if ($json) {
                $data = json_encode_prettify($data);
            }
            @file_put_contents($path, $data);
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Hàm lấy tất cả tập tin và thư mục con của một thư mục
     * @param $path
     * @param array $ignore_files
     * @return array
     */
    function scan_folder($path, $ignore_files = [])
    {
        try {
            if (is_dir($path)) {
                $data = array_diff(scandir($path), array_merge(['.', '..'], $ignore_files));
                natsort($data);
                return $data;
            }
            return [];
        } catch (Exception $ex) {
            return [];
        }
    }

    public function removeAndGetOneElementOfArray($array = array()){
        return array_pop($array);
    }

    public function getTimeNow(){
        return \Carbon\Carbon::now();
    }

    public function get_date_now(){
        return $this->carbon->now()->toDateString();
    }

    public function getWeekNow(){

    }

    /*
 * Get difference between two times
 */
    function _dateDiff($date1, $date2) {
        $datetime1 = new DateTime($date1);
        $datetime2 = new DateTime($date2);
        $interval = $datetime1->diff($datetime2);
        return $interval->format('%H:%I');
    }

}
