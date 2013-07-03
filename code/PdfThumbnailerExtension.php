<?php

class PdfThumbnailerExtension extends DataObjectDecorator {

    public static $convert_path = '/usr/bin/convert';

    public function Thumbnail($page=1) {
        // Only thumbnail PDF files

        if ( strtolower($this->owner->getExtension()) != 'pdf' ) {
            return false;
        }
        $file_filename  = Director::baseFolder().'/'.$this->owner->getFilename();
        if ( ! file_exists($file_filename) ) return false;
        $cache_filename = $this->owner->getFilename().'.page-'.(int)$page.'.jpg';
        // Check for existing cached thumbnail
        if ( file_exists(Director::baseFolder().'/'.$cache_filename) && filemtime(Director::baseFolder().'/'.$cache_filename) > filemtime($file_filename) ) {
            $img = DataObject::get_one('Image', "Filename = '".$cache_filename."'");
            if ( $img ) return $img;
        }
        // Create and cache the thumbnail
        $command = self::$convert_path.' '.escapeshellarg($file_filename.'['.((int)$page-1).']').' -quality 90 '.escapeshellarg(Director::baseFolder().'/'.$cache_filename);
        $out = shell_exec($command);
var_dump( $command );
        if ( ! file_exists(Director::baseFolder().'/'.$cache_filename) ) return false;
        $img = new Image();
        $img->setFilename($cache_filename);
        $img->write();
        $img = DataObject::get_one('Image', "Filename = '".$cache_filename."'");
        return $img;
    }

}

