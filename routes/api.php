<?php

use App\Http\classes\G;
use App\Http\Controllers\Authentication;
use App\Http\Controllers\Category;
use App\Http\Controllers\FileManager;
use App\Http\Controllers\IndexPage;
use App\Http\Controllers\KeyValue;
use App\Http\Controllers\Person;
use App\Http\Controllers\Post;
use App\Http\Middleware\CheckHeaders;
use App\Http\Middleware\CheckToken;
use App\Http\Controllers\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('admin')->middleware([CheckHeaders::class])->group(function () {

    Route::post('/logIn', [Authentication::class, 'logIn'])->name('logIn');
    Route::post('/logOut', [Authentication::class, 'logOut'])->name('logOut');


    Route::post('/contactUs', [Person::class, 'contactUs'])->name('contactUs');


    Route::middleware([CheckToken::class])->group(function () {
        Route::post('/checkToken', [Authentication::class, 'checkToken'])->name('checkToken');
        Route::post('/personProfile', [Person::class, 'personProfile'])->name('personProfile');
        Route::post('/admins', [Person::class, 'admins'])->name('admins');
        Route::post('/adminRoles', [Person::class, 'adminRoles'])->name('adminRoles');
        Route::post('/createPerson', [Person::class, 'createPerson'])->name('createPerson');
        Route::post('/editPerson', [Person::class, 'editPerson'])->name('editPerson');
        Route::post('/roles', [Person::class, 'roles'])->name('roles');
        Route::post('/rolePermissions', [Person::class, 'rolePermissions'])->name('rolePermissions');
        Route::post('/addPermission', [Person::class, 'addPermission'])->name('addPermission');
        Route::post('/missingPermissions', [Person::class, 'missingPermissions'])->name('missingPermissions');
        Route::post('/addRole', [Person::class, 'addRole'])->name('addRole');
        Route::post('/deleteRole', [Person::class, 'deleteRole'])->name('deleteRole');
        Route::post('/editRole', [Person::class, 'editRole'])->name('editRole');
        Route::post('/deletePermission', [Person::class, 'deletePermission'])->name('deletePermission');


        Route::post('/savePublicFile', [FileManager::class, 'savePublicFile'])->name('savePublicFile');
        Route::post('/savePrivateFile', [FileManager::class, 'savePrivateFile'])->name('savePrivateFile');

        Route::post('/savePublicFiles', [FileManager::class, 'savePublicFiles'])->name('savePublicFiles');
        Route::post('/savePrivateFiles', [FileManager::class, 'savePrivateFiles'])->name('savePrivateFiles');

        Route::post('/deletePublicFile', [FileManager::class, 'deletePublicFile'])->name('deletePublicFile');
        Route::post('/deletePrivateFile', [FileManager::class, 'deletePrivateFile'])->name('deletePrivateFile');

        Route::post('/deletePublicFiles', [FileManager::class, 'deletePublicFiles'])->name('deletePublicFiles');
        Route::post('/deletePrivateFiles', [FileManager::class, 'deletePrivateFiles'])->name('deletePrivateFiles');

        Route::post('/deletePublicFolder', [FileManager::class, 'deletePublicFolder'])->name('deletePublicFolder');
        Route::post('/deletePrivateFolder', [FileManager::class, 'deletePrivateFolder'])->name('deletePrivateFolder');

        Route::post('/assignFileToUser', [FileManager::class, 'assignFileToUser'])->name('assignFileToUser');
        Route::post('/unAssignFileFromUser', [FileManager::class, 'unAssignFileFromUser'])->name('unAssignFileFromUser');

        Route::post('/renamePublicFolder', [FileManager::class, 'renamePublicFolder'])->name('renamePublicFolder');
        Route::post('/renamePrivateFolder', [FileManager::class, 'renamePrivateFolder'])->name('renamePrivateFolder');

        Route::post('/renamePublicFile', [FileManager::class, 'renamePublicFile'])->name('renamePublicFile');
        Route::post('/renamePrivateFile', [FileManager::class, 'renamePrivateFile'])->name('renamePrivateFile');

        Route::post('/movePublicFileAndFolder', [FileManager::class, 'movePublicFileAndFolder'])->name('movePublicFileAndFolder');
        Route::post('/movePrivateFileAndFolder', [FileManager::class, 'movePrivateFileAndFolder'])->name('movePrivateFileAndFolder');

        Route::post('/renamePublicFileAndFolder', [FileManager::class, 'renamePublicFileAndFolder'])->name('renamePublicFileAndFolder');
        Route::post('/renamePrivateFileAndFolder', [FileManager::class, 'renamePrivateFileAndFolder'])->name('renamePrivateFileAndFolder');

        Route::post('/publicFolderFiles', [FileManager::class, 'publicFolderFiles'])->name('publicFolderFiles');
        Route::post('/privateFolderFiles', [FileManager::class, 'privateFolderFiles'])->name('privateFolderFiles');

        Route::post('/publicFolderFilesLinks', [FileManager::class, 'publicFolderFilesLinks'])->name('publicFolderFilesLinks');
        Route::post('/privateFolderFilesLinks', [FileManager::class, 'privateFolderFilesLinks'])->name('privateFolderFilesLinks');

        Route::post('/deletePublicFolderOrFile', [FileManager::class, 'deletePublicFolderOrFile'])->name('deletePublicFolderOrFile');
        Route::post('/deletePrivateFolderOrFile', [FileManager::class, 'deletePrivateFolderOrFile'])->name('deletePrivateFolderOrFile');

        Route::post('/createPublicFolder', [FileManager::class, 'createPublicFolder'])->name('createPublicFolder');
        Route::post('/createPrivateFolder', [FileManager::class, 'createPrivateFolder'])->name('createPrivateFolder');

        Route::post('/publicFileInformation', [FileManager::class, 'publicFileInformation'])->name('publicFileInformation');
        Route::post('/privateFileInformation', [FileManager::class, 'privateFileInformation'])->name('privateFileInformation');


        Route::any('/file/{hash}', function ($hash, Request $request) {
            $person = G::getPersonFromToken($request->bearerToken());
            $file = $person->files()->where('hash', '=', $hash)->get();
            if ($file->count() == 1) {
                return response()->file($file[0]->location . $file[0]->new_name);
            } else {
                return response(['statusText' => 'fail', 'message' => "درخواست شما مجاز نیست"], 200);
            }
        })->name('privateFile');

        Route::post('/categoryListPyramid', [Category::class, 'categoryListPyramid'])->name('categoryListPyramid');
        Route::post('/categoryListPure', [Category::class, 'categoryListPure'])->name('categoryListPure');
        Route::post('/addCategory', [Category::class, 'addCategory'])->name('addCategory');
        Route::post('/deleteCategory', [Category::class, 'deleteCategory'])->name('deleteCategory');


        Route::post('/createPost', [Post::class, 'createPost'])->name('createPost');
        Route::post('/postList', [Post::class, 'postList'])->name('postList');
        Route::post('/deletePost', [Post::class, 'deletePost'])->name('deletePost');
        Route::post('/changePostStatus', [Post::class, 'changePostStatus'])->name('changePostStatus');
        Route::post('/updatePost', [Post::class, 'updatePost'])->name('updatePost');

        Route::post('/addKey', [KeyValue::class, 'addKey'])->name('addKey');
        Route::post('/deleteKey', [KeyValue::class, 'deleteKey'])->name('deleteKey');

        Route::post('/sliderImages', [IndexPage::class, 'sliderImages'])->name('sliderImages');
        Route::post('/popularPosts', [IndexPage::class, 'popularPosts'])->name('popularPosts');
        Route::post('/lastVideo', [IndexPage::class, 'lastVideo'])->name('lastVideo');
        Route::post('/top3Recent', [IndexPage::class, 'top3Recent'])->name('top3Recent');
        Route::post('/latestScreenshots', [IndexPage::class, 'latestScreenshots'])->name('latestScreenshots');
        Route::post('/latestPictures', [IndexPage::class, 'latestPictures'])->name('latestPictures');

        Route::post('/createProduct', [Product::class, 'createProduct'])->name('createProduct');
        Route::post('/productList', [Product::class, 'productList'])->name('productList');
        Route::post('/deleteProduct', [Product::class, 'deleteProduct'])->name('deleteProduct');
    });
});
Route::prefix('user')->middleware([CheckHeaders::class])->group(function () {

    Route::post('/logIn', [Authentication::class, 'logIn'])->name('logIn');
    Route::post('/logOut', [Authentication::class, 'logOut'])->name('logOut');
    Route::post('/indexPageView', [IndexPage::class, 'indexPageView'])->name('indexPageView');
    Route::post('/register', [Authentication::class, 'register'])->name('register');
    Route::post('/productData', [Product::class, 'productData'])->name('productData');
    Route::post('/categoryListPyramid', [Category::class, 'categoryListPyramid'])->name('categoryListPyramid');
    Route::post('/categoryProducts', [Product::class, 'categoryProducts'])->name('categoryProducts');
    Route::post('/post', [Post::class, 'post'])->name('post');
    Route::post('/lastPosts', [Post::class, 'lastPosts'])->name('lastPosts');
    Route::post('/posts', [Post::class, 'posts'])->name('posts');

    Route::middleware([CheckToken::class])->group(function () {
        Route::post('/addAddress', [Person::class, 'addAddress'])->name('addAddress');
        Route::post('/listAddress', [Person::class, 'listAddress'])->name('listAddress');
        Route::post('/deleteAddress', [Person::class, 'deleteAddress'])->name('deleteAddress');
        Route::post('/personProfile', [Person::class, 'personProfile'])->name('personProfile');
        Route::post('/addFavorite', [Person::class, 'addFavorite'])->name('addFavorite');
        Route::post('/deleteFavorite', [Person::class, 'deleteFavorite'])->name('deleteFavorite');
        Route::post('/favoriteList', [Person::class, 'favoriteList'])->name('favoriteList');
        Route::post('/checkToken', [Authentication::class, 'checkToken'])->name('checkToken');
        Route::post('/addCart', [Product::class, 'addCart'])->name('addCart');
        Route::post('/deleteCart', [Product::class, 'deleteCart'])->name('deleteCart');
        Route::post('/cartChangeNumber', [Product::class, 'cartChangeNumber'])->name('cartChangeNumber');
        Route::post('/listCart', [Product::class, 'listCart'])->name('listCart');
        Route::post('/editPerson', [Person::class, 'editPerson'])->name('editPerson');
        Route::post('/purchase', [Person::class, 'purchase'])->name('purchase');
        Route::post('/userFactors', [Person::class, 'userFactors'])->name('userFactors');
    });
});
