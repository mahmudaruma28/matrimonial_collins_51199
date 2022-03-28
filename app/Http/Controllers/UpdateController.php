<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Upload;
use Illuminate\Http\Request;
use DB;
use Artisan;
use Schema;
use Spatie\Permission\Models\Permission;
use ZipArchive;

class UpdateController extends Controller
{
    public function step0(Request $request) {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('This action is disabled in demo mode'))->error();
            return back();
        }
        if ($request->has('update_zip')) {
            if (class_exists('ZipArchive')) {
                // Create update directory.
                $dir = 'updates';
                if (!is_dir($dir))
                    mkdir($dir, 0777, true);

                $path = Upload::findOrFail($request->update_zip)->file_name;

                //Unzip uploaded update file and remove zip file.
                $zip = new ZipArchive;
                $res = $zip->open(base_path('public/' . $path));

                if ($res === true) {
                    $res = $zip->extractTo(base_path());
                    $zip->close();
                } else {
                    flash(translate('Could not open the updates zip file.'))->error();
                    return back();
                }

                return redirect()->route('update.step1');
            }
            else {
                flash(translate('Please enable ZipArchive extension.'))->error();
            }
        }
        else {
            return view('update.step0');
        }
    }

    public function step1() {
        if(get_setting('current_version') == '3.4'){
            $sql_path = base_path('sqlupdates/v35.sql');
            DB::unprepared(file_get_contents($sql_path));
        }
        if(get_setting('current_version') == '3.3'){
            $sql_path = base_path('sqlupdates/v34.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v35.sql');
            DB::unprepared(file_get_contents($sql_path));
        }
        elseif(get_setting('current_version') == '3.2'){
            $sql_path = base_path('sqlupdates/v33.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v34.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v35.sql');
            DB::unprepared(file_get_contents($sql_path));
        }
        elseif(get_setting('current_version') == '3.1'){
            $sql_path = base_path('sqlupdates/v32.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v33.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v34.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v35.sql');
            DB::unprepared(file_get_contents($sql_path));
        }
        elseif(get_setting('current_version') == '3.0'){
            $sql_path = base_path('sqlupdates/v31.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v32.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v33.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v34.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v35.sql');
            DB::unprepared(file_get_contents($sql_path));
        }

        return redirect()->route('update.step2');
    }

    public function step2() {
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);
        $this->permissions_33();
        $this->permissions_34();
        $this->permissions_35();

        return view('update.done');
    }

    public function convertTrasnalations(){
        foreach(Translation::all() as $translation){
            $lang_key = preg_replace('/[^A-Za-z0-9\_]/', '', str_replace(' ', '_', strtolower($translation->lang_key)));
            $translation->lang_key = $lang_key;
            $translation->save();
        }
    }

    public function permissions_33()
    {
      try {
          Permission::create(['name' => 'wallet_transaction_history','parent'=>'wallet', 'guard_name' => 'web']);
          Permission::create(['name' => 'offline_wallet_recharge_requests','parent'=>'wallet', 'guard_name' => 'web']);
          Permission::create(['name' => 'set_referral_commission','parent'=>'referral_system', 'guard_name' => 'web']);
          Permission::create(['name' => 'view_refferal_users','parent'=>'referral_system', 'guard_name' => 'web']);
          Permission::create(['name' => 'view_refferal_earnings','parent'=>'referral_system', 'guard_name' => 'web']);
          Permission::create(['name' => 'manage_wallet_withdraw_requests','parent'=>'referral_system', 'guard_name' => 'web']);
      } catch (\Exception $e) {

      }
     return;
    }

    public function permissions_34()
    {
      try {
          Permission::create(['name' => 'show_blog_categories','parent'=>'blog', 'guard_name' => 'web']);
          Permission::create(['name' => 'add_blog_category','parent'=>'blog', 'guard_name' => 'web']);
          Permission::create(['name' => 'edit_blog_category','parent'=>'blog', 'guard_name' => 'web']);
          Permission::create(['name' => 'delete_blog_category','parent'=>'blog', 'guard_name' => 'web']);
          Permission::create(['name' => 'show_blogs','parent'=>'blog', 'guard_name' => 'web']);
          Permission::create(['name' => 'add_blog','parent'=>'blog', 'guard_name' => 'web']);
          Permission::create(['name' => 'edit_blog','parent'=>'blog', 'guard_name' => 'web']);
          Permission::create(['name' => 'delete_blog','parent'=>'blog', 'guard_name' => 'web']);
      }
      catch (\Exception $e) { }
     return;
    }

    public function permissions_35()
    {
      try {
          Permission::create(['name' => 'show_unapproved_profile_picrures','parent'=>'member', 'guard_name' => 'web']);
          Permission::create(['name' => 'approve_profile_picrures','parent'=>'member', 'guard_name' => 'web']);
      }
      catch (\Exception $e) { }
     return;
    }
}
