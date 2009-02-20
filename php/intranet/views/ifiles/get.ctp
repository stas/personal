<?php
    $mimetype = mime_content_type(WWW_ROOT."/".$filename);
    if (file_exists($filename))
    {
        header('Content-Description: File Transfer');
        header('Content-Type: '.$mimetype );
        header('Content-Disposition: attachment; filename='.basename($filename));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        header('X-Sendfile: '.$filename);
        ob_clean();
        flush();
        readfile($filename);
        exit;
    }
    else
        echo "Fișierul nu a fost găsit!";

?>