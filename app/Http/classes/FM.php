<?php

namespace App\Http\classes;

use App\Models\File;
use App\Models\File_Person;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class FM
{
    private const FILE_MANAGER_BASE_PUBLIC_Directory = 'E:/dev/web/shopv2-backend/public/files';
    private const FILE_MANAGER_BASE_PRIVATE_Directory = 'E:/dev/web/shopv2-backend/files';
    private const APP_URL = 'http://localhost/shop/';
    private const PUBLIC_FOLDER_NAME = 'public';


    public static function location($key, $type)
    {
        $baseDir = "";
        if ($type == "public") {
            $baseDir = self::FILE_MANAGER_BASE_PUBLIC_Directory;
        } else if ($type == "private") {
            $baseDir =  self::FILE_MANAGER_BASE_PRIVATE_Directory;
        }
        $location  =   $baseDir . $key;
        return $location;
    }

    public static function saveFile($file, $type, $location, $uploader)
    {
        if (!file_exists($location) && !is_dir($location)) {
            mkdir($location,  0755, true);
        }
        $result = DB::transaction(function () use ($file, $type, $location, $uploader) {
            $newName =  Str::uuid() . "." .  $file->getClientOriginalExtension();
            $hash = G::getHash($newName);
            $result = File::create([
                "orginal_name" => $file->getClientOriginalName(),
                "new_name" => $newName,
                "hash" => $hash,
                "location" => $location,
                "person_id" => $uploader,
                "type" => $type,
            ]);
            $file->move($location, $newName);
            return $result['file_id'];
        });
        return $result;
    }
    public static function deleteFile(File $file)
    {
        $result = DB::transaction(function () use ($file) {
            $path = null;
            $path =  $file['location'] . $file['new_name'];
            if (file_exists($path)) {
                $result = $file->delete();
                if ($result) {
                    unlink($path);
                    return true;
                } else {
                    return false;
                }
            }
            return false;
        });
        return $result;
    }
    public static function deleteFolder($location)
    {
        $result = DB::transaction(function () use ($location) {
            $files = self::files($location);
            foreach ($files as $key => $value) {
                if (is_dir($location . $value)) {
                    $result =  self::deleteFolder($location . $value);
                    if ($result == false) {
                        return false;
                    }
                } else {
                    $result = File::where('new_name', '=', $value)->get();
                    if ($result->count() == 1) {
                        $result = self::deleteFile($result[0]);
                        if ($result == false) {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
            }
            rmdir($location);
            return true;
        });
        return $result;
    }
    public static function files($location)
    {
        if (file_exists($location)) {
            $files = scandir($location);
            unset($files[0]);
            unset($files[1]);
            return $files;
        }
        return false;
    }
    public static function folderFilesLinks($location, $token = null)
    {
        $files = self::files($location);
        if (count($files) == 0) {
            return 'location is empty';
        }
        $outfiles = [];
        foreach ($files as $key => $value) {
            $file = File::where('new_name', '=', $value)->get();
            if ($file->count() == 1) {
                $file = $file[0];
                if ($file->type == "public") {
                    $outfiles[] = ['name' => $file->new_name, 'link' => self::APP_URL . substr($location, strpos($location, 'files/')) . $value];
                } else if ($file->type == "private" || $token != null) {
                    $person = G::getPersonFromToken($token);
                    $file = $person->files()->where('new_name', '=', $value)->get();
                    if ($file->count() == 1) {
                        $outfiles[] = route('privateFile', ['hash' => $file[0]->hash]);
                    }
                }
            } else {
                $outfiles[] = ['name' => $value, 'link' => ""];
            }
        }
        return $outfiles;
    }
    public static function getPublicFile($name, $items)
    {
        $file = File::where('new_name', '=', $name)->where('type', '=', 'public')->get($items);
        if ($file->count() == 1) {
            return $file[0];
        }
        return false;
    }
    public static function getPrivateFile($hash, $token, $items)
    {
        $person = G::getPersonFromToken($token);
        $file = $person->files()->where('hash', '=', $hash)->where('type', '=', 'private')->get($items);
        if ($file->count() == 1) {
            return $file[0];
        }
        return false;
    }
    public  static function assignFileToUser($file_id, $person_id)
    {
        $result = File_Person::create([
            'file_id' => $file_id,
            'person_id' => $person_id,
        ]);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public  static function unAssignFileFromUser($file_id, $person_id)
    {
        $result = File_Person::where('file_id', '=', $file_id)->where('person_id', '=', $person_id)->delete();
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public static function renameDirectory($old_name, $new_name, $old_path, $new_path)
    {
        $result = DB::transaction(function () use ($old_name, $new_name, $old_path, $new_path) {
            $temp = $old_path . $old_name;
            $files =  File::where('location', 'LIKE', "%$temp%")->get();
            if (count($files) > 0) {
                for ($i = 0; $i < count($files); $i++) {
                    $full_old_location = $files[$i]->location;
                    $full_new_location = str_replace(($old_path . $old_name), ($new_path . $new_name), $full_old_location);
                    File::where('file_id', '=', $files[$i]->file_id)->update([
                        'location' => $full_new_location,
                    ]);
                }
            }
            if (!file_exists($new_path) && !is_dir($new_path)) {
                mkdir($new_path,  0755, true);
            }
            rename($old_path . $old_name, $new_path . $new_name);
            return true;
        });
        return $result;
    }
    public static function renameFile($old_name, $new_name, $old_path, $new_path)
    {
        $result = DB::transaction(function () use ($old_name, $new_name, $old_path, $new_path) {
            $files =  File::where('new_name', '=', $old_name)->get();
            if (count($files) > 0) {
                for ($i = 0; $i < count($files); $i++) {
                    $full_old_location = $files[$i]->location;
                    $full_new_location = str_replace($old_path, $new_path, $full_old_location);
                    File::where('file_id', '=', $files[$i]->file_id)->update([
                        'location' => $full_new_location,
                        'new_name' => $new_name,
                    ]);
                }
            }
            if (!file_exists($new_path) && !is_dir($new_path)) {
                mkdir($new_path,  0755, true);
            }
            rename($old_path . $old_name, $new_path . $new_name);
            return true;
        });
        return $result;
    }
    public static function createFolder($location)
    {
        if (file_exists($location)) {
            return "file exist";
        }
        return mkdir($location,  0755, true);
    }
    public static function getPublicFileLink($file)
    {
        $base = self::APP_URL;
        $public_folder = self::PUBLIC_FOLDER_NAME;
        $continue = substr($file->location, strpos($file->location, $public_folder) + strlen($public_folder) + 1) . $file->new_name;
        return $base . $continue;
    }
}
