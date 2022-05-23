<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class SettingConfigurations extends Model
{
    use HasFactory;
    protected $table = 'setting_configuration';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    public static function saveSC($obj)
    {

        if (isset($_FILES['photo']) && $_FILES['photo']['size'] > 0) {
            $obj['photo'] = SettingConfigurations::upload_photo($obj);
            DB::table('company')->update(array('img' => $obj['photo']));
        } else {
            unset($obj['photo']);
        }

        $result = DB::table('setting_configuration')->get();
        if (count($result) > 0) {
            DB::table('setting_configuration')->update($obj);
        } else {
            DB::table('setting_configuration')->insertGetId($obj);
        }

        return true;
    }

    public static function upload_photo($photo)
    {
        $uploadsDirectory = ($_SERVER['DOCUMENT_ROOT'] . '/farooqsteel/assets/img/company/');
        $errors = array(
            1 => 'php.ini max file size exceeded',
            2 => 'html form max file size exceeded',
            3 => 'file upload was only partial',
            4 => 'no file was attached'
        );
        ($_FILES['photo']['error'] == 0)
            or die($errors[$_FILES['photo']['error']]);

        @is_uploaded_file($_FILES['photo']['tmp_name'])
            or die('Not an HTTP upload');

        @getimagesize($_FILES['photo']['tmp_name'])
            or die('Only image uploads are allowed');

        $now = time();
        while (file_exists($uploadFilename = $uploadsDirectory . $now . '-' . $_FILES['photo']['name'])) {
            $now++;
        }

        // now let's move the file to its final location and allocate the new filename to it
        move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFilename) or die('Error uploading file');
        $path_parts = explode('/', $uploadFilename);
        $uploadFilename = $path_parts[count($path_parts) - 1];
        return $uploadFilename;
    }
    public static function fetch()
    {
        $result = DB::table('setting_configuration')->get();
        if (count($result) > 0) {
            return CommonFunctions::convertObjectToArray($result);
        } else {
            return false;
        }
    }
    public static function fetchColumn($column)
    {
        $result = DB::select("SELECT {$column} from setting_configuration");
        return CommonFunctions::convertObjectToArray($result);
    }
}
