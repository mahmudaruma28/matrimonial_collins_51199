<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\Paginator;
use Session;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
      Schema::defaultStringLength(191);
      Paginator::useBootstrap();
      $this->change_language();
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  public function change_language(){
      $country_code = $this->app->request->headers->all()['cf-ipcountry'][0];
      if($country_code == 'CN'){
          $lang_code = 'zh';
      }
      elseif($country_code == 'JP'){
          $lang_code = 'ja';
      }
      elseif($country_code == 'VN'){
          $lang_code = 'vi';
      }
      elseif($country_code == 'KH'){
          $lang_code = 'km';
      }
      elseif($country_code == 'TH'){
          $lang_code = 'th';
      }
      elseif($country_code == 'MY'){
          $lang_code = 'ms';
      }
      else{
          $lang_code = 'en';
      }
      Session::put('locale', $lang_code);
  }

}
