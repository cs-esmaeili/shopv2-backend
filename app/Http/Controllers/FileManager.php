<?php

namespace App\Http\Controllers;

use App\Http\classes\FM;
use App\Http\classes\G;
use App\Http\Requests\assignFileToUser;
use App\Http\Requests\deleteFile;
use App\Http\Requests\deleteFiles;
use App\Http\Requests\deleteFolder;
use App\Http\Requests\renameFolder;
use App\Http\Requests\saveFile;
use App\Http\Requests\saveFiles;
use App\Http\Requests\unAssignFileFromUser;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FileManager extends Controller
{
    public function savePublicFile(saveFile $request)
    {
        $location = FM::location($request->path, 'public');
        $person = G::getPersonFromToken($request->bearerToken());
        $result = FM::saveFile($request->file('file'), 'public', $location, $person->person_id);
        if ($result != false) {
            return response(['statusText' => 'ok', 'message' => "فایل ذخیره شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "فایل ذخیره نشد"], 200);
        }
    }
    public function savePrivateFile(saveFile $request)
    {
        $location = FM::location($request->path,  'private');
        $person = G::getPersonFromToken($request->bearerToken());
        $result = FM::saveFile($request->file('file'), 'private', $location, $person->person_id);
        if ($result != false) {
            return response(['statusText' => 'ok', 'message' => "فایل ذخیره شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "فایل ذخیره نشد"], 200);
        }
    }
    public function savePublicFiles(saveFiles $request)
    {
        $location = FM::location($request->path,  'public');
        $person = G::getPersonFromToken($request->bearerToken());
        $files = $request->file('file');

        $output = [];
        for ($i = 0; $i < count($files); $i++) {
            $result = FM::saveFile($files[$i], 'public', $location, $person->person_id);
            $output[] = $result;
        }
        return response(['statusText' => 'ok', 'list' => $output, 'message' => "فایل(ها) ذخیره شد"], 200);
    }
    public function savePrivateFiles(saveFiles $request)
    {
        $location = FM::location($request->path, 'private');
        $person = G::getPersonFromToken($request->bearerToken());
        $files = $request->file('file');

        $output = [];
        for ($i = 0; $i < count($files); $i++) {
            $result = FM::saveFile($files[$i], 'private', $location, $person->person_id);
            $output[] = $result;
        }
        return response(['statusText' => 'ok', 'list' => $output, 'message' => "فایل(ها) ذخیره شد"], 200);
    }
    public function deletePublicFile(deleteFile $request)
    {
        $content =  json_decode($request->getContent());
        $result = File::where('new_name', '=', $content->file_name)->where('type', '=', 'public')->get();
        if ($result->count() == 1) {
            $result = FM::deleteFile($result[0]);
            if ($result) {
                return response(['statusText' => 'ok', 'message' => "فایل حذف شد!"], 200);
            } else {
                return response(['statusText' => 'fail', 'message' => "فایل حذف نشد"], 200);
            }
        } else {
            return response(['statusText' => 'fail', 'message' => "فایل پیدا نشد"], 200);
        }
    }
    public function deletePrivateFile(deleteFile $request)
    {
        $content =  json_decode($request->getContent());
        $result = File::where('new_name', '=', $content->file_name)->where('type', '=', 'private')->get();
        if ($result->count() == 1) {
            $result = FM::deleteFile($result[0]);
            if ($result) {
                return response(['statusText' => 'ok', 'message' => "فایل حذف شد!"], 200);
            } else {
                return response(['statusText' => 'fail', 'message' => "فایل حذف نشد"], 200);
            }
        } else {
            return response(['statusText' => 'fail', 'message' => "فایل پیدا نشد"], 200);
        }
    }
    public function deletePublicFiles(deleteFiles $request)
    {
        $content =  json_decode($request->getContent());
        $content = $content->files;
        for ($i = 0; $i < count($content); $i++) {
            $result = File::where('new_name', '=', $content[$i])->where('type', '=', 'public')->get();
            if ($result->count() == 1) {
                $result = FM::deleteFile($result[0]);
                if ($result == false) {
                    return response(['statusText' => 'fail', 'message' => "فایل(ها) حذف نشد"], 200);
                }
            } else {
                return response(['statusText' => 'fail', 'message' => "فایل(ها) پیدا نشد"], 200);
            }
        }
        return response(['statusText' => 'ok', 'message' => "فایل(ها) حذف شد!"], 200);
    }
    public function deletePrivateFiles(deleteFiles $request)
    {
        $content =  json_decode($request->getContent());
        $content = $content->files;
        for ($i = 0; $i < count($content); $i++) {
            $result = File::where('new_name', '=', $content[$i])->where('type', '=', 'private')->get();
            if ($result->count() == 1) {
                $result = FM::deleteFile($result[0]);
                if ($result == false) {
                    return response(['statusText' => 'fail', 'message' => "فایل(ها) حذف نشد"], 200);
                }
            } else {
                return response(['statusText' => 'fail', 'message' => "فایل(ها) پیدا نشد"], 200);
            }
        }
        return response(['statusText' => 'ok', 'message' => "فایل(ها) حذف شد!"], 200);
    }
    public function deletePublicFolder(deleteFolder $request)
    {
        $content =  json_decode($request->getContent());
        $location = FM::location($content->path, 'public');
        $result = FM::deleteFolder($location);
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "پوشه حذف شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "پوشه حذف نشد"], 200);
        }
    }
    public function deletePrivateFolder(deleteFolder $request)
    {
        $content =  json_decode($request->getContent());
        $location = FM::location($content->path,  'private');
        $result = FM::deleteFolder($location);
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "پوشه حذف شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "پوشه حذف نشد"], 200);
        }
    }
    public function deletePublicFolderOrFile(Request $request)
    {
        $content =  json_decode($request->getContent());
        $list = $content->list;
        $folders = [];
        $files = [];
        for ($i = 0; $i < count($list); $i++) {
            if (str_contains($list[$i], '.')) {
                $files[] = $list[$i];
            } else {
                $folders[] =  $content->path . $list[$i];
            }
        }
        for ($i = 0; $i < count($files); $i++) {
            $result = File::where('new_name', '=', $files[$i])->where('type', '=', 'public')->get();
            if ($result->count() == 1) {
                $result = FM::deleteFile($result[0]);
                if ($result == false) {
                    return response(['statusText' => 'fail', 'message' => "فایل(ها) حذف نشد"], 200);
                }
            } else {
                return response(['statusText' => 'fail', 'message' => "فایل(ها) پیدا نشد"], 200);
            }
        }
        for ($i = 0; $i < count($folders); $i++) {
            $location = FM::location($folders[$i] . '/',  'public');
            $result = FM::deleteFolder($location);
            if ($result === false) {
                return response(['statusText' => 'fail', 'message' => "پوشه حذف نشد"], 200);
            }
        }
        return response(['statusText' => 'ok', 'message' => "فایل/پوشه (ها) حذف شد"], 200);
    }
    public function deletePrivateFolderOrFile(Request $request)
    {
        $content =  json_decode($request->getContent());
        $list = $content->list;
        $folders = [];
        $files = [];
        for ($i = 0; $i < count($list); $i++) {
            if (str_contains($list[$i], '.')) {
                $files[] = $list[$i];
            } else {
                $folders[] =  $content->path . $list[$i];
            }
        }
        for ($i = 0; $i < count($files); $i++) {
            $result = File::where('new_name', '=', $files[$i])->where('type', '=', 'private')->get();
            if ($result->count() == 1) {
                $result = FM::deleteFile($result[0]);
                if ($result == false) {
                    return response(['statusText' => 'fail', 'message' => "فایل(ها) حذف نشد"], 200);
                }
            } else {
                return response(['statusText' => 'fail', 'message' => "فایل(ها) پیدا نشد"], 200);
            }
        }
        for ($i = 0; $i < count($folders); $i++) {
            $location = FM::location($folders[$i],  'private');
            $result = FM::deleteFolder($location);
            if ($result === false) {
                return response(['statusText' => 'fail', 'message' => "پوشه حذف نشد"], 200);
            }
        }
        return response(['statusText' => 'ok', 'message' => "فایل/پوشه (ها) حذف شد"], 200);
    }
    public function assignFileToUser(assignFileToUser $request)
    {
        $content =  json_decode($request->getContent());
        $result = FM::assignFileToUser($content->file_id, $content->person_id);
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "دسترسی فایل به شخص داده شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "دسترسی فایل به شخص داده نشد"], 200);
        }
    }
    public function unAssignFileFromUser(unAssignFileFromUser $request)
    {
        $content =  json_decode($request->getContent());
        $result = FM::unAssignFileFromUser($content->file_id, $content->person_id);
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "دسترسی شخص به فایل حذف شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "دسترسی شخص به فایل حذف نشد"], 200);
        }
    }
    public function renamePublicFolder(renameFolder $request)
    {
        $content =  json_decode($request->getContent());
        $location_old = FM::location($content->old_path,   'public');
        $location_new = FM::location($content->new_path,  'public');
        $result = FM::renameDirectory($content->old_name, $content->new_name, $location_old, $location_new);
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "نام پوشه تغییر کرد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "نام پوشه تغییر نکرد"], 200);
        }
    }
    public function renamePublicFile(renameFolder $request)
    {
        $content =  json_decode($request->getContent());
        $location_old = FM::location($content->old_path,   'public');
        $location_new = FM::location($content->new_path,  'public');
        $result = FM::renameFile($content->old_name, $content->new_name, $location_old, $location_new);
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "نام فایل تغییر کرد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "نام فایل تغییر نکرد"], 200);
        }
    }
    public function renamePrivateFolder(renameFolder $request)
    {
        $content =  json_decode($request->getContent());
        $location_old = FM::location($content->old_path,   'private');
        $location_new = FM::location($content->new_path,  'private');
        $result = FM::renameFile($content->old_name, $content->new_name, $location_old, $location_new);
        if ($result) {
            return response(['statusText' => 'ok', 'message' => "نام پوشه تغییر کرد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "نام پوشه تغییر نکرد"], 200);
        }
    }
    public function publicFolderFilesLinks(Request $request)
    {
        $content =  json_decode($request->getContent());
        $location = FM::location($content->path, 'public');
        $files = FM::folderFilesLinks($location, 'public');
        if ($files == false) {
            return response(['statusText' => 'fail'], 200);
        } else {
            return response(['statusText' => 'ok', "list" => $files], 200);
        }
    }
    public function privateFolderFilesLinks(Request $request)
    {
        $content =  json_decode($request->getContent());
        $location = FM::location($content->path, 'private');
        $files = FM::folderFilesLinks($location, $request->bearerToken());
        return $files;
    }
    public function publicFolderFiles(Request $request)
    {
        $content =  json_decode($request->getContent());
        $location = FM::location($content->path, 'public');
        $files = FM::files($location);
        if ($files === false) {
            return response(['statusText' => 'fail', 'message' => "مسیر وجود ندارد"], 200);
        } else {
            return response(['statusText' => 'ok', "list" => array_values($files)], 200);
        }
    }
    public function privateFolderFiles(Request $request)
    {
        $content =  json_decode($request->getContent());
        $location = FM::location($content->path, 'private');
        $files = FM::files($location);
        if ($files === false) {
            return response(['statusText' => 'fail', 'message' => "مسیر وجود ندارد"], 200);
        } else {
            return response(['statusText' => 'ok', "list" => array_values($files)], 200);
        }
    }
    public function createPublicFolder(Request $request)
    {
        $content =  json_decode($request->getContent());
        $location = FM::location($content->path, 'public');
        $result = FM::createFolder($location);
        if ($result === false) {
            return response(['statusText' => 'fail', 'message' => "پوشه ساخته نشد"], 200);
        } else if ($result === true) {
            return response(['statusText' => 'ok', 'message' => "پوشه ساخته شد"], 200);
        } else {
            return response(['statusText' => 'fail', 'message' => "پوشه ای با این نام وجود دارد"], 200);
        }
    }
    public function createPrivateFolder(Request $request)
    {
        $content =  json_decode($request->getContent());
        $location = FM::location($content->path, 'private');
        $result = FM::createFolder($location);
        if ($result === false) {
            return response(['statusText' => 'fail', 'message' => "پوشه ساخته نشد"], 200);
        } else {
            return response(['statusText' => 'ok', 'message' => "پوشه ساخته شد"], 200);
        }
    }
    public function publicFileInformation(Request $request)
    {
        $content =  json_decode($request->getContent());
        $result = FM::getPublicFile($content->name, ['orginal_name', 'new_name', 'person_id', 'created_at', 'file.file_id', 'location']);
        $file =  $result->toArray();
        $file['link'] = FM::getPublicFileLink($result);
        unset($file['location']);
        $file['uploader'] = $result->uploader->informations();
        if ($result === false) {
            return response(['statusText' => 'fail', 'message' => "اطلاعات فایل پیدا نشد"], 200);
        } else {
            return response(['statusText' => 'ok', "file" => $file], 200);
        }
    }
    public function privateFileInformation(Request $request)
    {
        $content =  json_decode($request->getContent());
        $result = FM::getPrivateFile($content->name,  $request->bearerToken(), ['orginal_name', 'new_name', 'person_id', 'created_at', 'file_id', 'location']);
        $file =  $result->toArray();
        $file['link'] = FM::getPublicFileLink($result); //TODO bayad baraye private ye method to FM neveshte she
        unset($file['location']);
        $file['uploader'] = $result->uploader->informations();
        if ($result === false) {
            return response(['statusText' => 'fail', 'message' => "اطلاعات فایل پیدا نشد"], 200);
        } else {
            return response(['statusText' => 'ok', "file" => $file], 200);
        }
    }

    public function movePublicFileAndFolder(Request $request)
    {
        $content =  json_decode($request->getContent());
        $location_old = FM::location($content->old_path,   'public');
        $location_new = FM::location($content->new_path,  'public');
        $items = $content->items;
        $folders = [];
        $files = [];
        foreach ($items as $key => $value) {
            if (str_contains($value, '.')) {
                $files[] = $value;
            } else {
                $folders[] = $value;
            }
        }
        foreach ($files as $key => $value) {
            $result = FM::renameFile($value, $value, $location_old, $location_new);
            if ($result == false) {
                return response(['statusText' => 'fail', 'message' => "فایل(ها)  منتقل نشد"], 200);
            }
        }
        foreach ($folders as $key => $value) {
            $result = FM::renameDirectory($value, $value, $location_old, $location_new);
            if ($result == false) {
                return response(['statusText' => 'fail', 'message' => "فایل(ها)  منتقل نشد"], 200);
            }
        }
        return response(['statusText' => 'ok', 'message' => "فایل(ها)  منتقل شد"], 200);
    }
    public function renamePublicFileAndFolder(Request $request)
    {
        $content =  json_decode($request->getContent());
        $location = FM::location($content->path, 'public');
        $old_name = $content->old_name;
        $new_name = $content->new_name;

        if (str_contains($old_name, '.')) {
            $result = FM::renameFile($old_name, $new_name, $location, $location);
            if ($result == false) {
                return response(['statusText' => 'fail', 'message' => "فایل تغییر نام پیدا نکرد"], 200);
            }
        } else {
            $result = FM::renameDirectory($old_name, $new_name, $location, $location);
            if ($result == false) {
                return response(['statusText' => 'fail', 'message' => "فایل تغییر نام پیدا نکرد"], 200);
            }
        }
        return response(['statusText' => 'ok', 'message' => "فایل تغییر نام پیدا کرد"], 200);
    }
}
