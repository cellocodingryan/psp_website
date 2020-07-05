<?php


class upload
{
    public static function uploadftp($local_file, $remote_file) {
        $connection = ftp_connect($server);
        $server = getenv('serverip');
        $username = getenv('ftpusername');
        // login
        if (@ftp_login($connection, $username, $password)){
            // successfully connected
        } else {
            return false;
        }

        if (!ftp_put($connection, $remote_file, $local_file, FTP_BINARY)) {
            return false;
        }
        ftp_close($connection);
        return true;
    }
}