<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CouponCodes\Repositories\CouponCodeRepositoryInterface;
use App\Services\Products\Repositories\ProductRepositoryInterface;
use App\Services\CouponCodes\Requests\addCouponCodeRequest;
use App\Services\CouponCodes\Requests\updateCouponCodeRequest;

class CouponCodeController extends Controller
{
    //
    function __construct(CouponCodeRepositoryInterface $couponCodeRepository,
                        ProductRepositoryInterface $productRepository
    )
    {
        $this->couponCodeRepository = $couponCodeRepository;
        $this->productRepository = $productRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Read Coupon Code')) {
            abort('401', '401');
        }

        $data = $this->couponCodeRepository->all();
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        if ($request->ajax()) {
            return datatables()->of($data)
                ->addColumn('coupon_period', function ($row) {
                    return date('F d, Y', strtotime($row->date_start)) . ' - ' .  date('F d, Y', strtotime($row->date_end));
                })
                ->addColumn('type', function ($row) {
                    return ($row->type == '1' ? 'Amount' : 'Percentage');
                })
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Coupon Code')) {
                        $html = '<a href="' . route('admin.coupon_codes.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Coupon Code')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                return $html;
            })->toJson();
        }

        return view('admin.pages.coupon_codes.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Coupon Code')) {
            abort('401', '401');
        }

        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        $products = $this->productRepository->all();

        return view('admin.pages.coupon_codes.create', compact('permissions', 'products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addCouponCodeRequest $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Coupon Code')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['once_per_customer'] = isset($input['once_per_customer']) ? 1 : 0;
        $input['is_no_time_limit'] = isset($input['is_no_time_limit']) ? 1 : 0;
        $input['apply_category'] = (json_encode($request->apply_category) == 'null' ? '' : json_encode($request->apply_category));
        $input['apply_product'] = (json_encode($request->apply_product) == 'null' ? '' : json_encode($request->apply_product));
        $input['user_id'] = auth()->user()->id;
        $input['date_start'] = date('Y-m-d', strtotime($input['date_start']));
        $input['date_end'] = date('Y-m-d', strtotime($input['date_end']));
        $this->couponCodeRepository->addData($input);

        return redirect()->route('admin.coupon_codes.index')->with('success','Coupon Code created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermissionTo('Update Coupon Code')) {
            abort('401', '401');
        }

        $coupon = $this->couponCodeRepository->get($id);
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        $products = $this->productRepository->all();

        return view('admin.pages.coupon_codes.edit', compact('coupon', 'permissions', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(updateCouponCodeRequest $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Coupon Code')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['once_per_customer'] = isset($input['once_per_customer']) ? 1 : 0;
        $input['is_no_time_limit'] = isset($input['is_no_time_limit']) ? 1 : 0;
        $input['apply_category'] = (json_encode($request->apply_category) == 'null' ? '' : json_encode($request->apply_category));
        $input['apply_product'] = (json_encode($request->apply_product) == 'null' ? '' : json_encode($request->apply_product));
        $input['user_id'] = auth()->user()->id;
        $input['date_start'] = date('Y-m-d', strtotime($input['date_start']));
        $input['date_end'] = date('Y-m-d', strtotime($input['date_end']));
        $coupon = $this->couponCodeRepository->updateData($id, $input);
        
        return redirect()->route('admin.coupon_codes.index')->with('success','Coupon Code updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete Coupon Code')) {
            abort('401', '401');
        }

        return $this->couponCodeRepository->delete($id);
    }
    
    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore Coupon Code')) {
            abort('401', '401');
        }

        return $this->couponCodeRepository->restore($id);
    }

    public function validateCouponCode(Request $request)
    {
        $response = [
            'title' => '',
            'message' => 'Coupon is invalid.',
            'type' => 'error'
        ];

        $input = $request->all();
        $carts = $this->cart_repository->getAll();

        if (!(!empty($carts) && count($carts))) {
            $response['message'] = 'Cart empty.';
        }
        
        if (isset($input['coupon_code']) && !empty($carts)) {
            $coupon_code = $this->coupon_code_model->where('code', $input['coupon_code'])->first();

            if (!empty($coupon_code)) {
                if ($coupon_code->is_no_time_limit == 1) {
                    //nothing to do (no filtering of date)
                } else { 
                    if ($coupon_code->date_end < Carbon::now()) {
                        $coupon_code = null;
                        $response['message'] = 'Coupon is already expired.';
                        $response['type'] = 'error';
                    }
                }
            }

            if (!empty($coupon_code)) {
                if ($coupon_code->times_of_use == 0) {
                    session()->put('coupon_code', $coupon_code->code);
                    $response['message'] = 'Your coupon has been applied.';
                    $response['type'] = 'success';
                } else {
                    if ($coupon_code->times_of_use <= $coupon_code->used) {
                        session()->forget('coupon_code');
                        session()->forget('coupon_products');
                    } else  {
                        session()->put('coupon_code', $coupon_code->code);
                        $response['message'] = 'Your coupon has been applied.';
                        $response['type'] = 'success';
                    }
                }

                if ($coupon_code->once_per_customer == 1) {
                    if(auth()->user() == null) {
                        return redirect()->to('customer-login?redi=true&c=true');
                    } else {
                        $user_id = auth()->user();
                        $checker = 0;
                        if (isset($user_id->orders)) {
                            foreach ($user_id->orders as $order) {
                                if ($order->coupon_details != null) {
                                    if ($order->coupon_details->coupon_code == $input['coupon_code']) {
                                        $checker = 1;
                                    }
                                }
                            }
                        }

                        if ($checker == 1) {
                            session()->forget('coupon_code');
                            session()->forget('coupon_products');
                            $response['message'] = 'You already used this coupon.';
                            $response['type'] = 'error';
                        }
                    }
                }

                if ($coupon_code->apply_product != '' ) {
                    $array_prods = [];
                    $check_if_product_is_good = 0;
                    $prods = json_decode($coupon_code->apply_product);
                    if ($prods != null) {
                        $array_prods = $prods;
                    }

                    foreach( $carts as $cart) {
                        if (in_array($cart->product_id,$array_prods)) {
                            $check_if_product_is_good = 1;
                        }
                    }

                    if ($check_if_product_is_good == 0) {
                        session()->forget('coupon_code');
                        session()->forget('coupon_products');
                        $response['message'] = 'This coupon is only applicable on certain products. Please try again.';
                        $response['type'] = 'error';
                    } else {
                        session()->put('coupon_products', $array_prods);
                    }
                }

            } else {
                session()->forget('coupon_code');
                session()->forget('coupon_products');
            }


        } else {
            session()->forget('coupon_code');
            session()->forget('coupon_products');
        }
     
        return redirect()->back()->with('flash_message', $response);
    }
}
