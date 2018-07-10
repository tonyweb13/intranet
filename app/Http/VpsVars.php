<?php
declare(strict_types=1);

namespace App\Http;

use App\Models\ {
    User,
    AclRules
};

use App\Models\Vps\ {
    Rules,
    Portfolio
};

use App\Models\loanApproval\ {
    states
};

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;


use File, Storage;

class VpsVars
{
    public static function getVpsJSON(): string
    {
//        dd(Storage::url('vps/images/profile/thumbnail/UyhB10A8urIInZIe.jpg'));

//        Storage::putFileAs('/vps/images/profile/', new File('/vps/images/profile/'), 'photo.jpg');
//        Storage::putFile('photos', new File('/path/to/photo'));
//        Storage::download('file.jpg');
        $settings = [];
        $login_user = User::where('id', Auth::id());
        $acl_rules = Rules::where('user_id', Auth::id())->first();

        $settings['settings'] = 'test';
        $settings['auth_user'] = $login_user->with(['department', 'designation', 'employment_type', 'address','government_credential','groupPortfolio'])->first();
        $settings['acl_rules'] = $acl_rules;
        $settings['portfolios'] = self::getPortfolios();
        $settings['states']= States::all();

        $encoded = json_encode($settings);

        // we need to escape the quotes and backslashes otherwise Javascript won't be able to
        // read the variable when it is inserted into JS code by Blade.
        $encoded = addslashes($encoded);


        try {
            $check_path = public_path().'/storage/profile/'.$settings['auth_user']->profile_pic;
            $check_thumbnail = public_path().'/storage/profile/thumbnail/'.$settings['auth_user']->profile_pic;

            if (!file_exists($check_path) && !file_exists($check_thumbnail)) {
                    if (Storage::exists('/vps/images/profile/thumbnail/'.$settings['auth_user']->profile_pic)) {
                        Storage::disk('public')->put('profile/thumbnail/'.$settings['auth_user']->profile_pic, Storage::get('/vps/images/profile/thumbnail/'.$settings['auth_user']->profile_pic));
                        Storage::disk('public')->put('profile/'.$settings['auth_user']->profile_pic, Storage::get('/vps/images/profile/'.$settings['auth_user']->profile_pic));
                    }
            }

        } catch (Exception $e) {

        }

        return $encoded;
    }

    private static function getPortfolios()
    {

        $new_portfolio = [];
        $is_integer = false;
        $associated_portfolio = new User;
        $associated = (object) $associated_portfolio->associatedAclPortfolio();


        if (isset($associated->errors)) {
            $is_integer = true;
            $default_portfolio_in_groups = (object) $associated_portfolio::with('groupPortfolio')->where('id',Auth::id())->first()->toArray();

//            dd($default_portfolio_in_groups->group_portfolio['portfolio_id']);
            if(!empty($default_portfolio_in_groups->group_portfolio['portfolio_id'])) {
                array_push($new_portfolio , $default_portfolio_in_groups->group_portfolio['portfolio_id']);
            }
        } else {
            foreach ($associated as $items) {
                array_push($new_portfolio, $items);
            }
        }

//        dd($new_portfolio , $is_integer);
        if(empty($new_portfolio)) {
            $new_portfolio = '';
        }

        if($is_integer) {
            /* Get portfolio using id integer */
            $portfolios = Portfolio::whereIN('id', array($new_portfolio));
//            dd( $portfolios->get()->toArray());
        } else {
            /* Get portfolio using name string */
            $portfolios = Portfolio::whereIN('name', $new_portfolio);
        }


        return $portfolios->get()->toArray();

    }


}
