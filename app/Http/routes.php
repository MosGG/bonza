<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/animation', function () {
    return view('pages.animation');
});

/*
|--------------------------------------------------------------------------
| Front-end Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for front-end application.
|
*/

/*
|--------------------------------------------------------------------------
| App Testing
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for admin application.
|
*/

Route::post('/app-login-action', [
        'as' => 'app-login-action',
        'uses' => 'admin\AdminActionController@appLoginTest'
]);

Route::post('/dataCollection', [
        'as' => 'dataCollection',
        'uses' => 'AppTestingController@dataCollection'
]);

Route::get('/dotaProfileTestingData', [
        'as' => 'dotaProfileTestingData',
        'uses' => 'AppTestingController@dotaProfileTestingData'
]);

Route::get('/dotaAPITesting', [
        'as' => 'dotaAPITesting',
        'uses' => 'dotaAPIController@executeProgram'
]);



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for admin application.
|
*/


Route::get('/admin-login', [
        'as' => 'admin-login',
        'uses' => 'admin\PagesController@login'
]);

Route::post('/login-action', [
        'as' => 'login-action',
        'uses' => 'admin\AdminActionController@login'
]);

Route::group(['middleware' => 'admin'], function () {

    Route::group(['middleware' => 'rootPermission'], function () {
        Route::get('/admin-home', [
            'as' => 'admin-home',
            'uses' => 'admin\PagesController@home'
        ]);
        Route::any('/admin-finance/{region}', [
            'as' => 'admin-finance',
            'uses' => 'admin\PagesController@finance'
        ]);
    });

    Route::get('/admin-document', [
        'as' => 'admin-document',
        'uses' => 'admin\PagesController@document'
    ]);

    Route::get('/admin-category', [
        'as' => 'admin-category',
        'uses' => 'admin\PagesController@category'
    ]);

    Route::get('/admin-order/{region}', [
        'as' => 'admin-order',
        'uses' => 'admin\PagesController@order'
    ]);

    Route::get('/admin-member', [
        'as' => 'admin-member',
        'uses' => 'admin\PagesController@member'
    ]);

    Route::get('/admin-refund', [
        'as' => 'admin-refund',
        'uses' => 'admin\PagesController@refund'
    ]);

    Route::get('/admin-tag', [
        'as' => 'admin-tag',
        'uses' => 'admin\PagesController@tag'
    ]);

    Route::get('/media-library', [
        'as' => 'media-library',
        'uses' => 'admin\PagesController@mediaLibrary'
    ]);
    
    Route::post('/media-library-new-folder', 'admin\PagesController@mediaLibraryNewFolder');
    Route::post('/media-library-delete-folder', 'admin\PagesController@mediaLibraryDelFolder');
    Route::post('/media-modal-sub-folder', 'admin\MediaLibraryController@mediaModalGetFolder');
    Route::post('/media-library-move', 'admin\PagesController@mediaLibraryMove');
    
    Route::get('/logout-action', [
        'as' => 'logout-action',
        'uses' => 'admin\AdminActionController@logout'
    ]);

    Route::get('/admin-portfolio', [
        'as' => 'admin-portfolio',
        'uses' => 'admin\PagesController@portfolio'
    ]);

    Route::get('/portfolio-sort', [
        'as' => 'portfolio-sort',
        'uses' => 'admin\PagesController@portfolioSort'
    ]);

    Route::get('/portfolio-new', [
        'as' => 'portfolio-new',
        'uses' => 'admin\PagesController@portfolioNew'
    ]);

    Route::get('/portfolio-edit/{id}', [
        'as' => 'portfolio-edit',
        'uses' => 'admin\PagesController@portfolioEdit'
    ]);

    Route::get('/admin-partner', [
        'as' => 'admin-portfolio',
        'uses' => 'admin\PagesController@partner'
    ]);

    Route::get('/partner-new', [
        'as' => 'partner-new',
        'uses' => 'admin\PagesController@partnerNew'
    ]);

    Route::get('/partner-edit/{id}', [
        'as' => 'partner-edit',
        'uses' => 'admin\PagesController@partnerEdit'
    ]);

    /*
     Admin Ajax Call From View
    */

    Route::post('/admin-add-action', 'admin\AdminActionController@adminAdd');
    Route::post('/admin-edit-action', 'admin\AdminActionController@adminEdit');
    Route::post('/admin-delete-action', 'admin\AdminActionController@adminDelete');

    Route::post('/admin-add-member', 'admin\AdminActionController@memberAdd');
    Route::post('/admin-edit-member', 'admin\AdminActionController@memberEdit');
    Route::post('/admin-delete-member', 'admin\AdminActionController@memberDelete');

    Route::post('/admin-add-category', 'admin\PortfolioActionController@categoryAdd');
    Route::post('/admin-edit-category', 'admin\PortfolioActionController@categoryEdit');
    Route::post('/admin-delete-category', 'admin\PortfolioActionController@categoryDelete');

    Route::post('/admin-add-tag', 'admin\PortfolioActionController@tagAdd');
    Route::post('/admin-edit-tag', 'admin\PortfolioActionController@tagEdit');
    Route::post('/admin-delete-tag', 'admin\PortfolioActionController@tagDelete');

    Route::post('/admin-get-product-by-id', 'admin\PortfolioActionController@getProductById');

    Route::post('/admin-update-order', 'admin\PortfolioActionController@orderUpdate');

    Route::post('/media-upload', 'admin\MediaLibraryController@mediaUpload');
    
    Route::post('/media-upload-to-folder', 'admin\MediaLibraryController@mediaUploadToFolder');
    
    Route::post('/delete-media-file', 'admin\MediaLibraryController@deleteMediaFile');

    Route::post('/file-upload', 'admin\MediaLibraryController@fileUpload');
    Route::post('/document-delete-action', 'admin\MediaLibraryController@deleteFile');

   
    Route::post('/refund-status-change', 'admin\PortfolioActionController@refundStatusChange');

    Route::post('/portfolio-add-action', 'admin\PortfolioActionController@portfolioNew');
    Route::post('/portfolio-edit-action', 'admin\PortfolioActionController@portfolioEdit');

    Route::post('/partner-add-action', 'admin\PortfolioActionController@partnerNew');
    Route::post('/partner-edit-action', 'admin\PortfolioActionController@partnerEdit');
    Route::post('/partner-feature-action', 'admin\PortfolioActionController@partnerFeature');
    Route::post('/partner-delete-action', 'admin\PortfolioActionController@partnerDelete');

    Route::post('/portfolio-feature-action', 'admin\PortfolioActionController@portfolioFeature');
    Route::post('/portfolio-client-action', 'admin\PortfolioActionController@portfolioClient');
    Route::post('/portfolio-delete-action', 'admin\PortfolioActionController@portfolioDelete');
    Route::post('/portfolio-ban-action', 'admin\PortfolioActionController@portfolioBan');
    Route::post('/portfolio-active-action', 'admin\PortfolioActionController@portfolioActive');
    Route::post('/client-sort-action', 'admin\PortfolioActionController@clientSort');

    Route::post('/get-lat-lng/{address}', 'admin\PortfolioActionController@getlatlng');
});


/*
 * Front-end pages
 */
Route::group(['middleware' => 'web'], function () {
    
    //membership
    Route::group(['middleware' => 'member'], function () {
        Route::get('/logout', [
            'as' => 'logout',
            'uses' => 'MembershipController@logout'
        ]);

        Route::get('/myaccount', [
            'as' => 'myaccount',
            'uses' => 'MembershipController@myaccount'
        ]);

        Route::get('/wishlist', [
            'as' => 'wishlist',
            'uses' => 'PagesController@wishlist'
        ]);

        Route::post('/add-to-wishlist', 'MembershipController@addtowishlist');
        Route::post('/remove-from-wishlist', 'MembershipController@removeFromWishlist');

        Route::get('/shoppingbag', [
            'as' => 'shoppingbag',
            'uses' => 'PagesController@shoppingbag'
        ]);
        // Route::post('/add-to-wishlist', 'MembershipController@addtowishlist');
        // Route::post('/remove-from-wishlist', 'MembershipController@removeFromWishlist');
    });

     Route::get('/', [
        'as' => '',
        'uses' => 'PagesController@home'
    ]);

    Route::get('/index', [
        'as' => 'index',
        'uses' => 'PagesController@home'
    ]);

    Route::get('/login', [
        'as' => 'login',
        'uses' => 'PagesController@login'
    ]);

    Route::Post('/login', [
        'as' => 'login',
        'uses' => 'MembershipController@login'
    ]);

    Route::get('/register', [
        'as' => 'register',
        'uses' => 'PagesController@register'
    ]);

    Route::Post('/register', [
        'as' => 'register',
        'uses' => 'MembershipController@register'
    ]);

    Route::get('/register/active', [
        'as' => 'active',
        'uses' => 'MembershipController@active'
    ]);
    Route::get('/register/reset', [
        'as' => 'reset',
        'uses' => 'MembershipController@reset'
    ]);
    Route::Post('/register/reset', [
        'as' => 'reset',
        'uses' => 'MembershipController@resetPassword'
    ]);

    Route::Get('/forget-password', function(){
        return view('pages.forget'); 
    });
    Route::Post('/forget-password', [
        'as' => 'forget',
        'uses' => 'MembershipController@forget'
    ]);

    Route::get('/process', [
        'as' => 'process',
        'uses' => 'PagesController@process'
    ]);

    Route::get('/process-company', [
        'as' => 'process',
        'uses' => 'PagesController@processCompany'
    ]);

     Route::get('/terms&condition', [
        'as' => 'process',
        'uses' => 'PagesController@termsCondition'
    ]);

    Route::get('/product', [
        'as' => 'product',
        'uses' => 'PagesController@product'
    ]);

    Route::get('/newarrival', [
        'as' => 'newarrival',
        'uses' => 'PagesController@newarrival'
    ]);

    Route::get('/project/{category}', [
        'as' => 'portfolio',
        'uses' => 'PagesController@portfolioCategory'
    ]);

    Route::get('/contact', [
        'as' => 'contact',
        'uses' => 'PagesController@contact'
    ]);

    Route::get('/about', [
        'as' => 'about',
        'uses' => 'PagesController@about'
    ]);

    Route::get('/partner/{category}', [
        'as' => 'partner',
        'uses' => 'PagesController@partner'
    ]);

    Route::get('/service', [
        'as' => 'service',
        'uses' => 'PagesController@service'
    ]);

    /*
    *  Portfolio Pages (urls for all the portfolio parts)
    */
    Route::get('/product/{id}', [
        'as' => 'product',
        'uses' => 'PagesController@productsingle'
    ]);
    /*
    *  FrontEnd Ajax Call
    */
    Route::post('/email-sending', 'EmailController@messageSend');
    Route::post('/get-portfolio-data', 'PortfolioController@getPortfolioData');
    Route::get('/search-ajax', 'PortfolioController@searchAjax');
});
