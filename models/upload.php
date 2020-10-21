<?php

require_once 'config/passwords.php';
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
}