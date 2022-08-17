<?php
require_once __DIR__.'/../main_config.php';
class PhotoManager
{
    public $session = null;
    public $files = [];

    public function __construct($session = null){
        $this->session = $session;
        if (!empty($session) && file_exists($this->getSessionFile())){
            $this->files = json_decode(file_get_contents($this->getSessionFile()), true);
//            PhotoManager::log($_REQUEST);

            if (!empty($_REQUEST['filepond']) && !(count($_REQUEST['filepond']) == 1 && $_REQUEST['filepond'][0][0] == '{')){
                $map = [];
                foreach ($this->files as $f){
                    $map[$this->getFileName($f['file'])] = $f;
                }
                $newFiles = [];
                PhotoManager::log('Update sorting...');
                PhotoManager::log($_REQUEST['filepond']);
                foreach ($_REQUEST['filepond'] as $i => $fn){
                    $fn = $this->getFileName($fn);
                    if (empty($map[$fn])){
                        PhotoManager::log("Empty order file $fn");
                    } else {
                        $newFiles[$i] = $map[$fn];
                        unset($map[$fn]);
                    }
                }
                foreach ($map as $f){
                    PhotoManager::log('Warning! Adding missed file.');
                    $newFiles[] = $f;
                }
                $this->files = $newFiles;
            }

        }
    }

    public static function process(){
        PhotoManager::log($_REQUEST);
        if (empty($_GET['session'])){
            die('no session');
        }
        $manager = new PhotoManager($_GET['session']);
        if (!empty($_GET['action'])){
            $manager->reponse_headers();
            switch ($_GET['action']){
                case 'process': $manager->process_photo(); break;
                case 'revert': $manager->revert(); break;
                case 'move': $manager->move(); break;
            }
        }
    }

    public function move(){
        $moved = $this->files[$_POST['origin']];
        unset($this->files[$_POST['origin']]);
        $this->files = array_values($this->files);
        array_splice($this->files, $_POST['target'], 0, [$moved]);
        echo json_encode([$this->files]);
        $this->save_session();
    }

    public function revert(){
        $this->files = array_filter($this->files, function ($v){
            return $v['name'] != $_GET['key'];
        });
        $this->save_session();
        echo json_encode(['status' => 'success']);
    }

    public function process_photo(){
        $files = $_FILES["filepond"];
        $imageName = null;
        $id = null;

        $structuredFiles = [];
        if (isset($files)) {
            foreach($files["name"] as $filename) {
                $structuredFiles[] = [
                    "name" => $filename
                ];
            }

            foreach($files["type"] as $index => $filetype) {
                $structuredFiles[$index]["type"] = $filetype;
            }

            foreach($files["tmp_name"] as $index => $file_tmp_name) {
                $structuredFiles[$index]["tmp_name"] = $file_tmp_name;
            }

            foreach($files["error"] as $index => $file_error) {
                $structuredFiles[$index]["error"] = $file_error;
            }

            foreach($files["size"] as $index => $file_size) {
                $structuredFiles[$index]["size"] = $file_size;
            }
        }

        $uniqueImgID = null;
        if (count($structuredFiles)) {
            foreach ($structuredFiles as $uploadedFile) {
                $uniqueImgID = null;

                PhotoManager::log("File error {$uploadedFile['error']} ".json_encode($uploadedFile));
                // check that there were no errors while uploading file
                if (isset($uploadedFile) && $uploadedFile['error'] === UPLOAD_ERR_OK) {

                    $imageName = $this->uploadImage($uploadedFile);

                    if ($imageName) {

                        $uniqueImgID = $imageName;
                        $this->files[] = [
                            'name' => $imageName,
                            'file' => $this->getSessionDir() . $imageName,
                            'status' => 'new',
                        ];
                    }

                }
            }
            $this->save_session();
        }

        $response = [];
        if ($uniqueImgID) {

            $response["status"] = "success";
            $response["key"] = $uniqueImgID;
            $response["msg"] = null;
            $response["files"] = json_encode($structuredFiles);

            http_response_code(200);

        } else {

            $response["status"] = "error";
            $response["key"] = null;
            $response["msg"] = "An error occured while uploading image";
            $response["files"] = json_encode($structuredFiles);

            http_response_code(400);

        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public static function log($log){
        $fp = fopen(ROOT.'/photo.log', 'a+');
        fputs($fp, date('Y-m-d H:i:s') .': '. print_r($log, true));
        fclose($fp);
    }

    public function reponse_headers(){
        // Comment if you don't want to allow posts from other domains
        header('Access-Control-Allow-Origin: *');

        // Allow the following methods to access this file
        header('Access-Control-Allow-Methods: OPTIONS, GET, DELETE, POST, HEAD, PATCH');

        // Allow the following headers in preflight
        header('Access-Control-Allow-Headers: content-type, upload-length, upload-offset, upload-name');

        // Allow the following headers in response
        header('Access-Control-Expose-Headers: upload-offset');
    }

    /**
     * @return string
     */
    protected static function images_root(): string
    {
        return ROOT . '/images/';
    }

    public function getSessionDir(){ return self::images_root().$this->session.'/'; }
    public function getSessionFile(){ return $this->getSessionDir().'session.json'; }

    public function save_session(){
        file_put_contents($this->getSessionFile(), json_encode($this->files));
    }

    public function new_session($prefix = 'new'){
        @mkdir(ROOT.'/images/'.$prefix);
        $name = $prefix.'/'.uniqid().uniqid().uniqid();
        $folder = self::images_root() .$name;
        @mkdir($folder);
        file_put_contents($folder.'/session.json', []);
        $this->session = $name;
        return $name;
    }

    function uploadImage($file) {
        $fileName = $file['name'];
        $fileType = $file['type'];
        $fileTempName = $file['tmp_name'];
        $fileError = $file['error'];
        $fileSize = $file['size'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
//        PhotoManager::log("File $fileExt $fileActualExt $fileName");
        $allowedExts = array('jpg', 'jpeg', 'png', 'svg', 'gif', 'heic');
        if (in_array($fileActualExt, $allowedExts)) {
            if ($fileError === 0) {
                if ($fileSize < 20000000) {
                    $fileNewName = uniqid("", true).".".$fileActualExt;
                    $fileDestination = $this->getSessionDir().$fileNewName;
                    move_uploaded_file($fileTempName, $fileDestination);

                    return $fileNewName;
                } else {
                    return false; // error: file size too big
                }
            } else {
                return false; // error: error uploading file
            }
        } else {
            return false; // error: file ext not allowed
        }
    }

    public function render_input(){
        return '
            <input type="file" id="imagesFilepond" class="filepond" name="filepond[]" multiple data-allow-reorder="true"
                data-max-file-size="1000MB" data-max-files="100" accepted-file-types="image/*"/>
            <input type="hidden" name="photo-session" value="'.$this->session.'"/>
            <input type="hidden" name="photo-files" value=""/>
            ';
    }

    public function render_scripts(){
        $files = [];
        foreach ($this->files as $f){
            $files[] = [
                'source' => $f['file'],
                'options' => ['type' => 'local'],
            ];
        }
        $filesEncoded = json_encode($files);
        return '
            <script>window.photo_manager = {
                files: '.$filesEncoded.',
                process: "photos.php?action=process&session='.$this->session.'",
                load: "photos.php?action=load&session='.$this->session.'",
                revert: "photos.php?action=revert&session='.$this->session.'",
                move: "photos.php?action=move&session='.$this->session.'",
            }</script>
            <script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
            <script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>
            <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
            <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
            <script
                    src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
            <script
                    src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
            <script src="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.js"></script>
            <script
                    src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
            <script src="js/photos/photo-manager.js"></script>';
    }

    public function render_css(){
        return '
            <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
            <link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css">
            <link rel="stylesheet" href="https://unpkg.com/filepond-plugin-image-edit/dist/filepond-plugin-image-edit.css">';
    }

    /**
     * @param $file
     * @return mixed|string
     */
    public function getFileName($file)
    {
        $fa = explode('/', $file);
        $fn = $fa[count($fa) - 1];
        return $fn;
    }
}