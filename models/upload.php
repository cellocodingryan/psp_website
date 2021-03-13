<?php

require_once 'config/passwords.php';
require_once 'flash.php';
class upload
{
    public static function uploadftp($local_file, $remote_file) {
        $server = getenv('serverip');
        $connection = ftp_connect($server);
        $password = getenv("ftppassword");
        $username = getenv('ftpusername');
        // login
        if (@ftp_login($connection, $username, $password)){
            // successfully connected
        } else {
            error_log("Not logged in :(");
            return false;
        }

        if (!ftp_put($connection, getenv("uploadlocation_prefix").$remote_file,

            $local_file, FTP_BINARY)) {
            return false;
        }
        if (!file_exists(getenv("filelocation_prefix").$remote_file)) {
            return false;
        }
        ftp_close($connection);
        return true;
    }

    public static function uploadhttp($tmpfile,$filePath,$start,$complete) {
        $filePath = $_SERVER['DOCUMENT_ROOT']."/".$filePath;
        $flash = new flash();
        $flash->add_danger("test123");
        if (empty($_FILES) || $tmpfile['error']) {
            $flash->add_danger("Failed to move uploaded file.");
            return false;
        }
        $tmpfile = $tmpfile['tmp_name'];
        // Open temp file
        $out = fopen("{$filePath}.part", $start==1 ? "wb" : "ab");
        if ($out) {
            // Read binary input stream and append it to temp file
            $in = fopen($tmpfile, "rb");

            if ($in) {
                while ($buff = fread($in, 4096))
                    fwrite($out, $buff);
            } else {
                $flash->add_danger("Failed to open input stream");
                return false;
            }

            @fclose($in);
            @fclose($out);

            @unlink($tmpfile);
        } else {

            $flash->add_danger("Failed to open output stream");
            return false;
        }

        @fclose("{$filePath}.part");
        // Check if file has been uploaded
        if ($complete == 1) {
            // Strip the temp .part suffix off
            rename("{$filePath}.part", $filePath);
            error_log("SEARCH FOR THIS");
            $flash->add_success("File uploaded");

        }
        return true;
    }
}