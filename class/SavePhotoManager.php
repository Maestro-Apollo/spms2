<?php

class SavePhotoManager extends PhotoManager
{
    private $code;

    public function __construct($session, $code)
    {
        parent::__construct($session);
        $this->code = $code;
//        echo "<pre>";
        $files = [];
        $filesRes = database::query("select * from photos where code = '{$code}'");
        while ($dbFile = mysqli_fetch_assoc($filesRes)){
            $files[$dbFile['image']] = $dbFile;
        }
        foreach ($this->files as &$file){
            if (!empty($files[$file['file']])){
                $file['record'] = $files[$file['file']];
            }
        }
    }

    public function save(){
        database::query("delete from `photos` where code ='{$this->code}'");
        foreach ($this->files as $file){
            $name = $file['file'];
            if ($file['status'] == 'new'){
                @mkdir(static::images_root().$this->code);
                $name = $this->code.'/'.$file['name'];
                rename($file['file'], static::images_root().$name);
            }
            if (!empty($file['record'])){
                database::query("INSERT INTO `photos` (`image_id`, `image`, `code`, `image_created_at`, `room_number`, `image_watermark`) 
                VALUES (NULL, '{$file['record']['image']}', '{$this->code}', '{$file['record']['image_creted_at']}', 
                        '{$file['record']['room_number']}', '{$file['record']['image_watermark']}')");
            } else {
                database::query("INSERT INTO `photos` (`image_id`, `image`, `code`, `image_created_at`) 
                VALUES (NULL, '$name', '{$this->code}', current_timestamp())");
            }

        }
        $this->deleteDirectory($this->getSessionDir());
    }

    public function deleteDirectory($dir) {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }

            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }

        }

        return rmdir($dir);
    }

}