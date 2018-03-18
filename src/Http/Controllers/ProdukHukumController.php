<?php

namespace Bantenprov\ProdukHukum\Http\Controllers;

/* Require */
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bantenprov\BudgetAbsorption\Facades\ProdukHukumFacade;

/* Models */
use Bantenprov\ProdukHukum\Models\Bantenprov\ProdukHukum\ProdukHukum;
use Bantenprov\GroupEgovernment\Models\Bantenprov\GroupEgovernment\GroupEgovernment;
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
    protected $produk-hukum;
    protected $user;

    public function __construct(ProdukHukum $produk-hukum, GroupEgovernment $group_egovernment, User $user)
    {
        $this->produk-hukum      = $produk-hukum;
        $this->group_egovernmentModel    = $group_egovernment;
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

            $query = $this->produk-hukum->orderBy($sortCol, $sortDir);
        } else {
            $query = $this->produk-hukum->orderBy('id', 'asc');
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
        $users = $this->user->all();

        foreach($users as $user){
            array_set($user, 'label', $user->name);
        }

        $response['group_egovernment'] = $group_egovernment;
        $response['user'] = $users;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProdukHukum  $produk-hukum
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produk-hukum = $this->produk-hukum;

        $validator = Validator::make($request->all(), [
            'group_egovernment_id' => 'required',
            'user_id' => 'required',
            'label' => 'required|max:16|unique:produk-hukums,label',
            'description' => 'max:255',
        ]);

        if($validator->fails()){
            $check = $produk-hukum->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, label ' . $request->label . ' already exists';
            } else {
                $produk-hukum->group_egovernment_id = $request->input('group_egovernment_id');
                $produk-hukum->user_id = $request->input('user_id');
                $produk-hukum->label = $request->input('label');
                $produk-hukum->description = $request->input('description');
                $produk-hukum->save();

                $response['message'] = 'success';
            }
        } else {
            $produk-hukum->group_egovernment_id = $request->input('group_egovernment_id');
            $produk-hukum->user_id = $request->input('user_id');
            $produk-hukum->label = $request->input('label');
            $produk-hukum->description = $request->input('description');
            $produk-hukum->save();
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
        $produk-hukum = $this->produk-hukum->findOrFail($id);

        $response['produk-hukum'] = $produk-hukum;
        $response['group_egovernment'] = $produk-hukum->group_egovernment;
        $response['user'] = $produk-hukum->user;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProdukHukum  $produk-hukum
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk-hukum = $this->produk-hukum->findOrFail($id);

        array_set($produk-hukum->user, 'label', $produk-hukum->user->name);

        $response['produk-hukum'] = $produk-hukum;
        $response['group_egovernment'] = $produk-hukum->group_egovernment;
        $response['user'] = $produk-hukum->user;
        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProdukHukum  $produk-hukum
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produk-hukum = $this->produk-hukum->findOrFail($id);

        if ($request->input('old_label') == $request->input('label'))
        {
            $validator = Validator::make($request->all(), [
                'label' => 'required|max:16',
                'description' => 'max:255',
                'group_egovernment_id' => 'required',
                'user_id' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'label' => 'required|max:16|unique:produk-hukums,label',
                'description' => 'max:255',
                'group_egovernment_id' => 'required',
                'user_id' => 'required',
            ]);
        }

        if ($validator->fails()) {
            $check = $produk-hukum->where('label',$request->label)->whereNull('deleted_at')->count();

            if ($check > 0) {
                $response['message'] = 'Failed, label ' . $request->label . ' already exists';
            } else {
                $produk-hukum->label = $request->input('label');
                $produk-hukum->description = $request->input('description');
                $produk-hukum->group_egovernment_id = $request->input('group_egovernment_id');
                $produk-hukum->user_id = $request->input('user_id');
                $produk-hukum->save();

                $response['message'] = 'success';
            }
        } else {
            $produk-hukum->label = $request->input('label');
            $produk-hukum->description = $request->input('description');
            $produk-hukum->group_egovernment_id = $request->input('group_egovernment_id');
            $produk-hukum->user_id = $request->input('user_id');
            $produk-hukum->save();

            $response['message'] = 'success';
        }

        $response['status'] = true;

        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProdukHukum  $produk-hukum
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk-hukum = $this->produk-hukum->findOrFail($id);

        if ($produk-hukum->delete()) {
            $response['status'] = true;
        } else {
            $response['status'] = false;
        }

        return json_encode($response);
    }
}
