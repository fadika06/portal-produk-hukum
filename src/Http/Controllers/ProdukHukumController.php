<?php

namespace Bantenprov\ProdukHukum\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\BudgetAbsorption\Facades\ProdukHukumFacade;

/* Models */
use Bantenprov\ProdukHukum\Models\Bantenprov\ProdukHukum\ProdukHukum;
use Bantenprov\GroupEgovernment\Models\Bantenprov\GroupEgovernment\GroupEgovernment;
use Bantenprov\SectorEgovernment\Models\Bantenprov\SectorEgovernment\SectorEgovernment;
use App\User;

/* Etc */
use Validator;

/**
 * The ProdukHukumController class.
 *
 * @package Bantenprov\ProdukHukum
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class ProdukHukumController extends Controller
{  
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $group_egovernmentModel;
    protected $sector_egovernment;
    protected $produk_hukum;
    protected $user;

    public function __construct(ProdukHukum $produk_hukum, GroupEgovernment $group_egovernment, SectorEgovernment $sector_egovernment, User $user)
    {
        $this->produk_hukum      = $produk_hukum;
        $this->group_egovernmentModel    = $group_egovernment;
        $this->sector_egovernment    = $sector_egovernment;
        $this->user             = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->has('sort')) {
            list($sortCol, $sortDir) = explode('|', request()->sort);

            $query = $this->produk_hukum->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->produk_hukum->orderBy('id', 'asc');
        }

        if ($request->exists('filter')) {
            $query->where(function($q) use($request) {
                $value = "%{$request->filter}%";
                $q->where('label', 'like', $value)
                    ->orWhere('description', 'like', $value);
            });
        }

        $perPage = request()->has('per_page') ? (int) request()->per_page : null;
        $response = $query->paginate($perPage);

        foreach($response as $group_egovernment){
            array_set($response->data, 'group_egovernment', $group_egovernment->group_egovernment->label);
        }

        foreach($response as $sector_egovernment){
            array_set($response->data, 'sector_egovernment', $sector_egovernment->sector_egovernment->label);
        }

        foreach($response as $user){
            array_set($response->data, 'user', $user->user->name);
        }

        return response()->json($response)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'GET');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $group_egovernment = $this->group_egovernmentModel->all();
        $sector_egovernment = $this->sector_egovernment->all();
        $users = $this->user->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }

        $response['group_egovernment'] = $group_egovernment;
        $response['sector_egovernment'] = $sector_egovernment;
        $response['user'] = $users;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProdukHukum  $produk_hukum
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produk_hukum = $this->produk_hukum;

        $validator = Validator::make($request->all(), [
            'group_egovernment_id' => 'required',
            'sector_egovernment_id' => 'required',
            'user_id' => 'required',
            'label' => 'required|max:255|unique:produk_hukums,label',
            'description' => 'max:255',
        ]);

        if($validator->fails()){
            $check = $produk_hukum->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, label ' . $request->label . ' already exists';
            } else {
                $produk_hukum->group_egovernment_id = $request->input('group_egovernment_id');
                $produk_hukum->sector_egovernment_id = $request->input('sector_egovernment_id');
                $produk_hukum->user_id = $request->input('user_id');
                $produk_hukum->label = $request->input('label');
                $produk_hukum->description = $request->input('description');
                $produk_hukum->save();

                $response['message'] = 'success';
            }
        } else {
            $produk_hukum->group_egovernment_id = $request->input('group_egovernment_id');
            $produk_hukum->sector_egovernment_id = $request->input('sector_egovernment_id');
            $produk_hukum->user_id = $request->input('user_id');
            $produk_hukum->label = $request->input('label');
            $produk_hukum->description = $request->input('description');
            $produk_hukum->save();
            $response['message'] = 'success';
        }

        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk_hukum = $this->produk_hukum->findOrFail($id);

        $response['produk_hukum'] = $produk_hukum;
        $response['group_egovernment'] = $produk_hukum->group_egovernment;
        $response['sector_egovernment'] = $produk_hukum->sector_egovernment;
        $response['user'] = $produk_hukum->user;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProdukHukum  $produk_hukum
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk_hukum = $this->produk_hukum->findOrFail($id);

        array_set($produk_hukum->user, 'label', $produk_hukum->user->name);

        $response['produk_hukum'] = $produk_hukum;
        $response['group_egovernment'] = $produk_hukum->group_egovernment;
        $response['sector_egovernment'] = $produk_hukum->sector_egovernment;
        $response['user'] = $produk_hukum->user;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProdukHukum  $produk_hukum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produk_hukum = $this->produk_hukum->findOrFail($id);

        if ($request->input('old_label') == $request->input('label'))
        {
            $validator = Validator::make($request->all(), [
                'label' => 'required|max:255',
                'description' => 'max:255',
                'group_egovernment_id' => 'required',
                'sector_egovernment_id' => 'required',
                'user_id' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'label' => 'required|max:255|unique:produk_hukums,label',
                'description' => 'max:255',
                'group_egovernment_id' => 'required',
                'sector_egovernment_id' => 'required',
                'user_id' => 'required',
            ]);
        }

        if ($validator->fails()) {
            $check = $produk_hukum->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, label ' . $request->label . ' already exists';
            } else {
                $produk_hukum->label = $request->input('label');
                $produk_hukum->description = $request->input('description');
                $produk_hukum->group_egovernment_id = $request->input('group_egovernment_id');
                $produk_hukum->sector_egovernment_id = $request->input('sector_egovernment_id');
                $produk_hukum->user_id = $request->input('user_id');
                $produk_hukum->save();

                $response['message'] = 'success';
            }
        } else {
            $produk_hukum->label = $request->input('label');
            $produk_hukum->description = $request->input('description');
            $produk_hukum->group_egovernment_id = $request->input('group_egovernment_id');
            $produk_hukum->sector_egovernment_id = $request->input('sector_egovernment_id');
            $produk_hukum->user_id = $request->input('user_id');
            $produk_hukum->save();

            $response['message'] = 'success';
        }

        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProdukHukum  $produk_hukum
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk_hukum = $this->produk_hukum->findOrFail($id);

        if ($produk_hukum->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }
}
