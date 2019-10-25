<?php
class modul {
    
    public function koneksi() {
        $host = "localhost";
        $user = "root";
        $password = "";
        $database = "unars_learning";
        $koneksi = mysqli_connect($host, $user, $password, $database);
        return $koneksi;
    }
    
    public function pesan_halaman($pesan, $halaman){
        $string_pesan = "<script type='text/javascript'> alert('".$pesan."');";
        $string_pesan .= "window.location = '".base_url().$halaman."';</script>";
        echo $string_pesan;
    }
    
    public function pesan($pesan){
        $string_pesan = "<script type='text/javascript'> alert('".$pesan."');";
        echo $string_pesan;
    }
    
    public function halaman($halaman){
        $string_pesan = "<script type='text/javascript'> ";
        $string_pesan .= "window.location = '".base_url().$halaman."';</script>";
        echo $string_pesan;
    }
    
    public function WaktuSekarang() {
        date_default_timezone_set("Asia/Bangkok");
        return date("H:i:s");
    }

    public function TangalSekarang() {
        date_default_timezone_set("Asia/Bangkok");
        return date("Y-m-d");
    }

    public function TanggalWaktu() {
        date_default_timezone_set("Asia/Bangkok");
        return date("Y-m-d H:i:s");
    }
    
    public function getCurTime() {
        date_default_timezone_set("Asia/Bangkok");
        return date("YmdHis");
    }
    
    public function resetAI(){
        $stringreset = "ALTER TABLE dosen AUTO_INCREMENT = 1;";
        return $stringreset;
    }
    
    public function autokode($depan, $kolom, $table) {
        $hasil = $depan;
        $q_data = mysql_query("select ifnull(MAX(substr(".$kolom.",2,9)),0) + 1 as jml from ".$table.";");
        $data_query = mysql_fetch_array($q_data);

        $panjang = 9 - strlen($data_query['jml']);
        for($i = 0; $i<$panjang; $i++){
            $hasil = $hasil."0";
        }
        $hasil = $hasil.$data_query['jml'];
        return $hasil;
    }
    
    public function autokodetrans1($depan, $kolom, $table) {
        $hasil = "";
        $q_data = mysqli_query($this->koneksi(),"select ifnull(MAX(substr(".$kolom.",3,10)),0) + 1 as jml from ".$table.";");
        $data_query = mysqli_fetch_array($q_data);
        if(strlen($data_query['jml']) == 1){
            $hasil = $depan. "0000" .$data_query['jml'];
        }else if(strlen($data_query['jml']) == 2){
            $hasil = $depan ."000". $data_query['jml'];
        }else if(strlen($data_query['jml']) == 3){
            $hasil = $depan. "00".$data_query['jml'];
        }else if(strlen($data_query['jml']) == 4){
            $hasil = $depan. "0".$data_query['jml'];
        }
        return $hasil;
    }
    
    public function autokodetrans2($depan, $kolom, $table) {
        $hasil = "";
        $q_data = mysqli_query($this->koneksi(),"select ifnull(MAX(substr(".$kolom.",4,10)),0) + 1 as jml from ".$table.";");
        $data_query = mysqli_fetch_array($q_data);
        if(strlen($data_query['jml']) == 1){
            $hasil = $depan. "0000" .$data_query['jml'];
        }else if(strlen($data_query['jml']) == 2){
            $hasil = $depan ."000". $data_query['jml'];
        }else if(strlen($data_query['jml']) == 3){
            $hasil = $depan. "00".$data_query['jml'];
        }else if(strlen($data_query['jml']) == 4){
            $hasil = $depan. "0".$data_query['jml'];
        }
        return $hasil;
    }
    
    public function autokodemax($kolom, $table) {
        $q_data = mysqli_query($this->koneksi(),"SELECT ifnull(max(".$kolom."),0) + 1 as hasil FROM ".$table.";");
        $data_query = mysqli_fetch_array($q_data);
        $hasil = $data_query['hasil'];
        return $hasil;
    }
    
    
    public function kodecalon($depan, $kolom, $table) {
        $hasil = "";
        $q_data = mysqli_query($this->koneksi(),"select ifnull(MAX(substr(".$kolom.",2,11)),0) + 1 as jml from ".$table.";");
        $data_query = mysqli_fetch_array($q_data);
        
        $panjang = strlen($data_query['jml']);
        $panjang_loop = 11 - $panjang;
        $nol = "";
        for($i=0; $i<$panjang_loop; $i++){
            $nol .= "0";
        }
        $hasil = $depan. $nol .$data_query['jml'];
        return $hasil;
    }
    
    public function TambahTanggal($tgl, $tambah) {
        return date('Y-m-d', strtotime('+'.$tambah.' days', strtotime($tgl)));
    }
    
    public function TambahMenit($waktu_awal,$menit) {
        date_default_timezone_set("Asia/Jakarta");
        $date = date_create($waktu_awal);
        date_add($date, date_interval_create_from_date_string($menit.' minutes'));
        return date_format($date, 'H:i:s');
    }
    
    public function KurangMenit($waktu_awal,$menit) {
        date_default_timezone_set("Asia/Jakarta");
        $date = date_create($waktu_awal);
        date_add($date, date_interval_create_from_date_string('-'.$menit.' minutes'));
        return date_format($date, 'H:i:s');
    }
    
    public function getUsia($tglLahir) {
	$biday = new DateTime($tglLahir);
	$today = new DateTime();
	$diff = $today->diff($biday);
        return $diff->y;
    }
    
    function getWeeks($date, $rollover){
        $cut        = substr($date, 0, 8);
        $daylen     = 86400;
        $timestamp  = strtotime($date);
        $first      = strtotime($cut . "01");   
        $elapsed    = (($timestamp - $first) / $daylen)+1;
        $i          = 1;
        $weeks      = 0;
        for($i==1; $i<=$elapsed; $i++){
            $dayfind        = $cut . (strlen($i) < 2 ? '0' . $i : $i);
            $daytimestamp   = strtotime($dayfind);
            $day            = strtolower(date("l", $daytimestamp));
            if($day == strtolower($rollover)){
                $weeks++;  
            }
        } 
        if($weeks==0){
            $weeks++; 
        }
        return $weeks;  
    }
    
    function weeks_in_month($year, $month, $start_day_of_week){ // Minggu pada bulan ini
        // Total number of days in the given month.
        $num_of_days = date("t", mktime(0,0,0,$month,1,$year));
 
        // Count the number of times it hits $start_day_of_week.
        $num_of_weeks = 0;
        for($i=1; $i<=$num_of_days; $i++){
            $day_of_week = date('w', mktime(0,0,0,$month,$i,$year));
            if($day_of_week==$start_day_of_week){
                $num_of_weeks++;
            }
        }
        return $num_of_weeks;
    }
    
    function HariIni() {
        date_default_timezone_set("Asia/Bangkok");
        $tanggal = date("Y-m-d");
        $day = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        return $dayList[$day];
    }
    
    function namaHariTglTertentu($tanggal) {
        $day = date('D', strtotime($tanggal));
        $dayList = array(
            'Sun' => 'Minggu',
            'Mon' => 'Senin',
            'Tue' => 'Selasa',
            'Wed' => 'Rabu',
            'Thu' => 'Kamis',
            'Fri' => 'Jumat',
            'Sat' => 'Sabtu'
        );
        return $dayList[$day];
    }

    function weeks($month, $year){
        $lastday = date("t", mktime(0, 0, 0, $month, 1, $year)); 
        $no_of_weeks = 0; 
        $count_weeks = 0; 
        while($no_of_weeks < $lastday){ 
            $no_of_weeks += 7; 
            $count_weeks++; 
        } 
        return $count_weeks;
    }
    
    public function jmlharibulanini() {
        date_default_timezone_set("Asia/Jakarta");
        $calendar = CAL_GREGORIAN;
        $month = date('m');
        $year = date('Y');
        $hari = cal_days_in_month($calendar, $month, $year);
        return $hari;
    }
    
    public function jmlharibulan($bulan, $tahun) {
        date_default_timezone_set("Asia/Jakarta");
        $calendar = CAL_GREGORIAN;
        $hari = cal_days_in_month($calendar, $bulan, $tahun);
        return $hari;
    }
    
    public function TimeToLong($input){
        $long = strtotime($input);
	return $long;
    }
    
    public function LongToTime($input){
	return date('H:i:s',$input);
    }
    
    public function enkrip_pass($string_normal) {
        require_once("chiper.php");
        $cipher = new chiper(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $kunci = "%^=%^&%!*OccOXfw'FH$3A4+U(XC$3X45w09C'3E45s0E4*jhEyXyESwhExs'94*�yEyF'E"; 
        $en = $cipher->encrypt($string_normal, $kunci);
        return $en;
    }
    
    public function dekrip_pass($string_terenkrip) {
        require_once("chiper.php");
        $cipher = new chiper(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
        $kunci = "%^=%^&%!*OccOXfw'FH$3A4+U(XC$3X45w09C'3E45s0E4*jhEyXyESwhExs'94*�yEyF'E";
        $de = $cipher->decrypt($string_terenkrip, $kunci);
        return $de;
    }
    
    public function image_text($path) {
        $imgbinary = fread(fopen($path, "r"), filesize($path));
        $img_str = base64_encode($imgbinary);
        return $img_str;
    }
    
    public function img_resize($target, $newcopy, $w, $h, $ext, $scala) {
        list($w_orig, $h_orig) = getimagesize($target);
        
        // menggunakan scala
        if($scala == TRUE){
            $scale_ratio = $w_orig / $h_orig;
            if (($w / $h) > $scale_ratio) {
                $w = $h * $scale_ratio;
            } else {
                $h = $w / $scale_ratio;
            }
        }

        $img = "";
        $ext = strtolower($ext);

        if ($ext == "gif"){ 
            $img = imagecreatefromgif($target);
        } else if($ext =="png"){ 
            $img = imagecreatefrompng($target);
        } else { 
            $img = imagecreatefromjpeg($target);
        }

        $tci = imagecreatetruecolor($w, $h);
        // imagecopyresampled(dst_img, src_img, dst_x, dst_y, src_x, src_y, dst_w, dst_h, src_w, src_h)

        imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orig, $h_orig);    
        imagejpeg($tci, $newcopy, 80);
    }
    
    public function terbilang($x){
        $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        if ($x < 12){
            return " " . $abil[$x];
        }else if ($x < 20){
            return terbilang($x - 10) . "belas";
        }else if ($x < 100){
            return terbilang($x / 10) . " puluh" . terbilang($x % 10);
        }elseif ($x < 200){
            return " seratus" . terbilang($x - 100);
        }elseif ($x < 1000){
            return terbilang($x / 100) . " ratus" . terbilang($x % 100);
        }elseif ($x < 2000){
            return " seribu" . terbilang($x - 1000);
        }elseif ($x < 1000000){
            return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
        }elseif ($x < 1000000000){
            return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
        }
    }
    
    public function hijau($pesan) {
        return '<span class="label label-success">'.$pesan.'</span>';
    }
    
    public function kuning($pesan) {
        return '<span class="label label-warning">'.$pesan.'</span>';
    }
    
    public function merah($pesan) {
        return '<span class="label label-danger">'.$pesan.'</span>';
    }
    
    public function get_ws_data($url, $post_paramtrs = false) {
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        if ($post_paramtrs) {
            curl_setopt($c, CURLOPT_POST, TRUE);
            curl_setopt($c, CURLOPT_POSTFIELDS, "var1=bla&" . $post_paramtrs);
        } 
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; rv:33.0) Gecko/20100101 Firefox/33.0");
        curl_setopt($c, CURLOPT_COOKIE, 'CookieName1=Value;');
        curl_setopt($c, CURLOPT_MAXREDIRS, 10);
        $follow_allowed = ( ini_get('open_basedir') || ini_get('safe_mode')) ? false : true;
        if ($follow_allowed) {
            curl_setopt($c, CURLOPT_FOLLOWLOCATION, 1);
        }
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 9);
        curl_setopt($c, CURLOPT_REFERER, $url);
        curl_setopt($c, CURLOPT_TIMEOUT, 60);
        curl_setopt($c, CURLOPT_AUTOREFERER, true);
        curl_setopt($c, CURLOPT_ENCODING, 'gzip,deflate');
        $data = curl_exec($c);
        $status = curl_getinfo($c);
        curl_close($c);
        preg_match('/(http(|s)):\/\/(.*?)\/(.*\/|)/si', $status['url'], $link);
        $data = preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/|\/)).*?)(\'|\")/si', '$1=$2' . $link[0] . '$3$4$5', $data);
        $data = preg_replace('/(src|href|action)=(\'|\")((?!(http|https|javascript:|\/\/)).*?)(\'|\")/si', '$1=$2' . $link[1] . '://' . $link[3] . '$3$4$5', $data);
        if ($status['http_code'] == 200) {
            return $data;
        } elseif ($status['http_code'] == 301 || $status['http_code'] == 302) {
            if (!$follow_allowed) {
                if (empty($redirURL)) {
                    if (!empty($status['redirect_url'])) {
                        $redirURL = $status['redirect_url'];
                    }
                } 
                if (empty($redirURL)) {
                    preg_match('/(Location:|URI:)(.*?)(\r|\n)/si', $data, $m);
                    if (!empty($m[2])) {
                        $redirURL = $m[2];
                    }
                }
                
                if (empty($redirURL)) {
                    preg_match('/href\=\"(.*?)\"(.*?)here\<\/a\>/si', $data, $m);
                    if (!empty($m[1])) {
                        $redirURL = $m[1];
                    }
                } 
                if (!empty($redirURL)) {
                    $t = debug_backtrace();
                    return call_user_func($t[0]["function"], trim($redirURL), $post_paramtrs);
                }
            }
        } 
        return "ERRORCODE22 with $url!!<br/>Last status codes<b/>:" . json_encode($status) . "<br/><br/>Last data got<br/>:$data";
    }
    
    public function session_aktif() {
        error_reporting(0);
        session_start();
    }
    
    public function tampilGambar($gambar) {
        $gambar = '<img src="data:image/jpg;base64,'.$gambar.'" class="img-thumbnail" alt="IMG">';
        return $gambar;
    }
}
