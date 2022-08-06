<?php

namespace App\Http\Controllers;

use App\Http\Resources\EAdsResource;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\RAdsResource;
use App\Http\Resources\RoleResource;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\UserResource;
use App\Models\Ads;
use App\Models\Permission;
use App\Models\Product;
use App\Models\RejectedAd;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends ApiController
{

    public function adminAds()
    {
        $ads = Ads::all();
        return $this->successResponse([
            'ads' => EAdsResource::collection($ads->load('personal')->load('jobCategory')->load('experiences')->load('langExperts')->load('softExperts'))
        ], 200);
    }

    public function adminUsers()
    {
        $users = User::all();
        return $this->successResponse([
            'users' => UserResource::collection($users)
        ], 200);
    }

    public function adminPayments()
    {
        $transactions = Transaction::all();
        return $this->successResponse([
            'transactions' => TransactionResource::collection($transactions->load('user'))
        ], 200);
    }
    public function adminProducts()
    {
        $products = Product::all();
        return $this->successResponse([
            'products' => ProductResource::collection($products)
        ], 200);
    }
    public function adminRoles()
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return $this->successResponse([
            'roles' => RoleResource::collection($roles),
            'permissions' => PermissionResource::collection($permissions)
        ], 200);
    }
  
    public function  adminChangeStatus(Request $request)
    {
        $ad = Ads::find($request->id);
        $ad->update([
            'status' => $request->status
        ]);
        $ad->save();
        return response()->json(['message' => 'وضعیت با موفقیت تغییر کرد'], 200);
    }
    public function  adminRejectAd(Request $request)
    {
        $ad = Ads::find($request->id);
        $ad->update([
            'status' => 'rejected'
        ]);
        $ad->save();

        $reject = RejectedAd::create([
            'ads_id' => $request->id,
            'reason' => $request->reason
        ]);

        return response()->json(['message' => 'status successfully changed'], 200);
    }
}
