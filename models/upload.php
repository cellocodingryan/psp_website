<?php


class upload
{
    public static function uploadftp($local_file, $remote_file) {
        $server = getenv('serverip');
        $connection = ftp_connect($server);
        error_log(getenv("ftpusername"));
        $password = getenv("ftppassword");
        $username = getenv('ftpusername');
        // login
        if (@ftp_login($connection, $username, $password)){
            // successfully connected
        } else {
            error_log("Not logged in :(");
            return false;
        }

        if (!ftp_put($connection, $remote_file, $local_file, FTP_BINARY)) {
            return false;
        }
        ftp_close($connection);
        return true;
    }
}