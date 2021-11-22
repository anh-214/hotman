<?php

namespace App\Http\Controllers\Web;

use App\Events\MessageNotification;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VNPayController extends Controller
{
    public function create(Request $request){   
        
        if ($request->ajax()){
            $cart =json_decode($request->input('cart'));
            $type_cart = $request->input('type_cart');
            $ward = $request->input('ward');
            $detailsAddress = $request->input('detailsAddress');
            $array = array();
            foreach ($cart as $key => $value){
                array_push($array,$value->cart_id.'-'.$value->quantity);
            }
            $string = implode(',',$array);
            $result = Order::create([
                'type'=> $string,
                'payment_type' => $type_cart,
                'checkout_status' => 0,
                'user_id' => Auth::guard('web')->user()->id,
                'ward_id' => $ward,
                'details_address' => $detailsAddress,
                'is_read' => 'false',
                'created_at' => now(),
            ]);
            $order = Order::where('id',$result->id)->first();
            event(new MessageNotification($order,'Đơn hàng từ khách hàng: '.Auth::guard('web')->user()->name));
            $total = 0;
            foreach ($array as $one){
                $all = explode('-',$one);
                $type_id = $all[0];
                $type_info = Type::where('id',$type_id)->with('images')->first();
                $type_info->quantity = intval($all[2]);
                $total += intval($all[2])*$type_info->price;
            }
            if ($total < 500000 && $total>0){
                $total += 30000;
            }
            // return response()->json(['price'=>$total]);
            
            $vnp_TmnCode = "IY96RSTL"; //Mã website tại VNPAY 
            $vnp_HashSecret = "TZWTZGJYKEUCCKCXXJKIAWRFMAJMWVUF"; //Chuỗi bí mật
            $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_Returnurl = "https://hotman.vn/cart/return-vnpay";
            $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
            $vnp_TxnRef = $result->id;
            $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ. Số tiền ".number_format($total).' đ';
            $vnp_OrderType = 'billpayment';
            $vnp_Amount = $total * 100;
            $vnp_Locale = 'vn';
            $vnp_IpAddr = request()->ip();

            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $startTime = date("YmdHis");
            $vnp_ExpireDate = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));

            $inputData = array(
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => date('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $vnp_IpAddr,
                "vnp_Locale" => $vnp_Locale,
                "vnp_OrderInfo" => $vnp_OrderInfo,
                "vnp_OrderType" => $vnp_OrderType,
                "vnp_ReturnUrl" => $vnp_Returnurl,
                "vnp_TxnRef" => $vnp_TxnRef,
                "vnp_ExpireDate"=>$vnp_ExpireDate,
            );
    
            if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                $inputData['vnp_BankCode'] = $vnp_BankCode;
            }
            ksort($inputData);
            $query = "";
            $i = 0;
            $hashdata = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashdata .= urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
                $query .= urlencode($key) . "=" . urlencode($value) . '&';
            }

            $vnp_Url = $vnp_Url . "?" . $query;
            if (isset($vnp_HashSecret)) {
                $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
                $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
            }
            // return redirect($vnp_Url);
            return response()->json(['link'=>$vnp_Url]);
        }
    }
    public function return(Request $request){
        // dd($request->input());
        $vnp_HashSecret = "TZWTZGJYKEUCCKCXXJKIAWRFMAJMWVUF"; //Chuỗi bí mật
        $inputData = array();
        // $returnData = array();
        foreach ($request->input() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_BankCode = $inputData['vnp_BankCode']; //Ngân hàng thanh toán
        $vnp_Amount = $inputData['vnp_Amount']/100; // Số tiền thanh toán VNPAY phản hồi

        $Status = 0; // Là trạng thái thanh toán của giao dịch chưa có IPN lưu tại hệ thống của merchant chiều khởi tạo URL thanh toán.
        $orderId = $inputData['vnp_TxnRef'];
        try {
            //Check Orderid    
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId            
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);   
                $order = Order::where('id',$orderId)->first();
                if ($order != NULL) {
                    $total = 0;
                    $all_order = explode(',',$order->type);
                    foreach ($all_order as $one){
                        $all = explode('-',$one);
                        $type_id = $all[0];
                        $type_info = Type::where('id',$type_id)->with('images')->first();
                        $type_info->quantity = intval($all[2]);
                        $total += intval($all[2])*$type_info->price;
                    }
                    if ($total < 500000 && $total>0){
                        $total += 30000;
                    }
                    if($total == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
                    {   
                        if ($order->checkout_status == 0) {
                            
                            if ($inputData['vnp_ResponseCode'] == '00' || $inputData['vnp_TransactionStatus'] == '00') {
                                session()->flash('success', 'Xác nhận thanh toán thành công');
                                $Status = 1; // Trạng thái thanh toán thành công
                            } else {
                                session()->flash('error', 'Xác nhận thanh toán thất bại');
                                $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                            }
                            //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
                            Order::where('id',$orderId)->update([
                                'checkout_status' => $Status,
                            ]);
                            //
                            //
                            //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công                
                            // $returnData['RspCode'] = '00';
                            return redirect('/');
                            // $returnData['Message'] = 'Xác nhận thành công';
                        } else {
                            // $returnData['RspCode'] = '02';
                            session()->flash('error', 'Đơn hàng đã được xác nhận');
                            // $returnData['Message'] = 'Đơn hàng đã được xác nhận';
                        }
                    }
                    else {
                        // $returnData['RspCode'] = '04';
                        session()->flash('error', 'Lỗi giá trị đơn hàng');
                        // $returnData['Message'] = 'Lỗi giá trị đơn hàng';
                    }
                } else {
                    // $returnData['RspCode'] = '01';
                    session()->flash('error', 'Đơn hàng không tồn tại');
                    // $returnData['Message'] = 'Đơn hàng không tồn tại';
                }
            } else {
                // $returnData['RspCode'] = '97';
                session()->flash('error', 'Lỗi chữ ký');
                // $returnData['Message'] = 'Lỗi chữ ký';
            }
        } catch (Exception $e) {
            // $returnData['RspCode'] = '99';
                session()->flash('error', 'Lỗi không xác định');
            // $returnData['Message'] = 'Lỗi không xác định';
        }
        //Trả lại VNPAY theo định dạng JSON
        // echo json_encode($returnData);

        return redirect('cart/checkout');

    }
}
