<?php

class EditPhotoManager extends PhotoManager
{
    private $code;

    public function __construct($session, $code)
    {
        parent::__construct($session);
        $this->code = $code;
    }

    public function new_session($prefix = 'edit')
    {
        $name = parent::new_session($prefix);
        $res = database::query( "SELECT * from photos where code = '{$this->code}' ");
        if (mysqli_num_rows($res) > 0) {
            while ($photo = mysqli_fetch_assoc($res)){
                $this->files[] = [
                    'name' => $photo['image'],
                    'file' => $photo['image'],
                    'status' => 'saved',
                ];
            }
        }
        $this->save_session();
        return $name;
    }
}