<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;


class PagesController extends AdminBaseController
{
    public function login(){
        return view('admin.login');
    }

    public function home(Request $request){
        $admins = DB::table('admins')->get();
        return view('/admin.home')->with('admins', json_encode($admins));
    }

    public function mediaLibrary(Request $request){
        if ($request->input("folder") == null){
            $father = "0";
        } else {
            $father = $request->input("folder");
            if (empty(DB::table('media_library')->where("father", $father)->get())) {
                $father = "0";
            }
        }
        
        if ($father !== "0") {
            $uplevel = DB::table('media_library')->where("id", $father)->get();
            $upFatherId = $uplevel[0]->father;
        } else {
            $upFatherId = "";
        }
        
        $folder = DB::table('media_library')->where("father", $father)->where("category", "folder")->get();
        $media = DB::table('media_library')->where("father", $father)->where("category", "!=", "folder")->get();
        return view('/admin.mediaLibrary')
                ->with('folder', $folder)
                ->with('media', json_encode($media))
                ->with('father', $father)
                ->with('upper', $upFatherId);
    }
    
    public function mediaLibraryNewFolder(Request $request){
        $father = $request->input("father");
        $name = $request->input("name");
        DB::insert('insert into media_library (id, src, src_thumb, category, father, name) values (?, ?, ?, ?, ?, ?)', [null, "", "", "folder", $father, $name]);
        return response()->json(array('status' => 1,'msg' => 'ok'));
    }
    
    public function mediaLibraryDelFolder(Request $request){
        $id = $request->input("id");
        $fatherArr = DB::table("media_library")->where("id", $id)->get();
        $fatherId = $fatherArr[0]->father;
        DB::update("UPDATE media_library SET father = ? WHERE father = ?", array($fatherId, $id));
        DB::table("media_library")->where("id", $id)->delete();
        return response()->json(array('status' => 1,'msg' => 'ok'));
    }
    
    public function mediaLibraryMove(Request $request){
        $imgid = $request->input("imgid");
        $folderid = $request->input("folderid");
        foreach ($imgid as $id){
            DB::update("UPDATE media_library SET father = ? WHERE id = ?", array($folderid, $id));
        }
        return response()->json(array('status' => 1,'msg' => 'ok'));
    }
    
    public function portfolio(Request $request){
        $portfolios = DB::table('portfolios')->get();
        $category = DB::table('category')->get();
        $cate = array();
        foreach($category as $c){
            $cate[$c->id] = $c->name;
        }
        foreach($portfolios as $k => $p){
            $portfolios[$k]->category = $cate[$p->category];
        }
        return view('/admin.portfolio')->with('portfolios', json_encode($portfolios));
    }

    public function partner(Request $request){
        $portfolios = DB::table('partner')->get();
        return view('/admin.partner')->with('portfolios', json_encode($portfolios));
    }

    public function portfolioSort(Request $request){
        $portfolios = DB::table('portfolios')->where('client','=', 1)->orderBy('sort')->get();
        return view('/admin.portfolioSort')->with('portfolios', json_encode($portfolios));
    }

    public function document(Request $request){
        $documents = DB::table('documents')->get();
        return view('/admin.document')->with('documents', json_encode($documents));
    }

    public function member(Request $request){
        $member = DB::table('membership')->get();
        return view('/admin.member')->with('member', json_encode($member));
    }

    public function refund(Request $request){
        $date_start = ($request->input('start'))?strtotime($request->input('start')):strtotime("-1 month");
        $date_end = ($request->input('end'))?strtotime($request->input('end')):time();
        $refund = DB::table('refund')->whereBetween('create_time', [$date_start, $date_end])->get();
        foreach ($refund as $key => $value) {
            $order = DB::table('orders')->where('id', $value->order_id)->get();
            $refund[$key]->user = DB::table('membership')->where('id', $value->user_id)->value("username");
            $refund[$key]->recipient = $order[0]->recipient;
            $refund[$key]->address = $order[0]->address;
            $refund[$key]->orderDetail = json_decode($order[0]->detail);
            $refund[$key]->total_price = $order[0]->total_price;
            $refund[$key]->status_name = $this->order_status($order[0]->status);
            $refund[$key]->delivery_status_name = $this->delivery_status($order[0]->delivery_status);
            $refund[$key]->payment_status_name = $this->payment_status($order[0]->payment_status);
            $refund[$key]->date = date("Y-m-d H:i:s", $value->create_time);
        }
        return view('/admin.refund')->with('refund', json_encode($refund))
        ->with('start', date("d-m-Y", $date_start))->with('end', date("d-m-Y", $date_end));
    }

    public function order(Request $request){
        $date_start = ($request->input('start'))?strtotime($request->input('start')):strtotime("-1 month");
        $date_end = ($request->input('end'))?strtotime($request->input('end')):time();
        $orders = DB::table('orders')->whereBetween('create_time', [$date_start, $date_end])->get();
        foreach ($orders as $key => $value) {
            $orders[$key]->user_id = DB::table('membership')->where('id', $value->user_id)->value("firstname");
            $orders[$key]->status_name = $this->order_status($value->status);
            $orders[$key]->delivery_status_name = $this->delivery_status($value->delivery_status);
            $orders[$key]->payment_status_name = $this->payment_status($value->payment_status);
            $orders[$key]->orderDetail = json_decode($value->detail);
            $orders[$key]->date = date("Y-m-d H:i:s", $value->create_time);
        }
        return view('/admin.order')->with('orders', json_encode($orders))
        ->with('start', date("d-m-Y", $date_start))->with('end', date("d-m-Y", $date_end));
    }

    private function fefund_status($status){
        if($status == '0') {
            return "Waiting to be processed";
        } else if($status == '1') {
            return "Refund Success";
        } else if($status == '-1') {
            return "Canceled";
        }
        return 'error';
    }

    private function order_status($status){
        if($status == '0') {
            return "Pending";
        } else if($status == '1') {
            return "Success";
        } else if($status == '-1') {
            return "Canceled By Buyer";
        } else if($status == '-2') {
            return "Canceled By Seller";
        } else if($status == '-3') {
            return "Return";
        }
        return 'error';
    }

    private function payment_status($status){
        if($status == '0') {
            return "Pending";
        } else if($status == '1') {
            return "Shipped";
        } else if($status == '-1') {
            return "Refund";
        }
        return 'error';
    }

    private function delivery_status($status){
        if($status == '0') {
            return "Pending";
        } else if($status == '1') {
            return "Paid";
        } else if($status == '-1') {
            return "Return";
        }
        return 'error';
    }

    public function finance(Request $request, $region){
        $export = $request->input('export');

        $date_start = ($request->input('start'))?strtotime($request->input('start')):strtotime("-6 month");
        $date_end = ($request->input('end'))?strtotime($request->input('end')):strtotime(date("d-m-Y",time()));
        $date_end = $date_end + 3600 * 24 - 1;
        $orders = DB::table('orders')->where('region',$region)->whereBetween('create_time', [$date_start, $date_end])->get();

        $report = array();
        $report_month = array();
        $time = $date_start;
        while($time < $date_end) {
            $date = date("Y-m-d", $time);
            $report[$date]['date'] = $date;
            $report[$date]['total_order'] = 0;
            $report[$date]['success'] = 0;
            $report[$date]['processing'] = 0;
            $report[$date]['cancel-buyer'] = 0;
            $report[$date]['cancel-seller'] = 0;
            $report[$date]['return'] = 0;
            $report[$date]['payment-no'] = 0;
            $report[$date]['payment-yes'] = 0;
            $report[$date]['delivery-no'] = 0;
            $report[$date]['delivery-yes'] = 0;
            $report[$date]['sales'] = 0;

            $date = date("Y-m", $time);
            $report_month[$date]['date'] = $date;
            $report_month[$date]['total_order'] = 0;
            $report_month[$date]['success'] = 0;
            $report_month[$date]['processing'] = 0;
            $report_month[$date]['cancel-buyer'] = 0;
            $report_month[$date]['cancel-seller'] = 0;
            $report_month[$date]['return'] = 0;
            $report_month[$date]['payment-no'] = 0;
            $report_month[$date]['payment-yes'] = 0;
            $report_month[$date]['delivery-no'] = 0;
            $report_month[$date]['delivery-yes'] = 0;
            $report_month[$date]['sales'] = 0;

            $time += 3600 * 24;
        }

        foreach ($orders as $key => $value) {
            $date = date("Y-m-d", $value->create_time);
            $month = date("Y-m", $value->create_time);
            $report[$date]['total_order']++;
            $report_month[$month]['total_order']++;
            if($value->status == '0') {
                $report[$date]['processing']++;
                $report_month[$month]['processing']++;
            } else if($value->status == '1') {
                $report[$date]['success']++;
                $report[$date]['sales'] += $value->total_price;
                $report_month[$month]['success']++;
                $report_month[$month]['sales'] += $value->total_price;
            } else if($value->status == '-1') {
                $report[$date]['cancel-buyer']++;
                $report_month[$month]['cancel-buyer']++;
            } else if($value->status == '-2') {
                $report[$date]['cancel-seller']++;
                $report_month[$month]['cancel-seller']++;
            } else if($value->status == '-3') {
                $report[$date]['return']++;
                $report_month[$month]['return']++;
            }
            if($value->delivery_status == '1') {
                $report[$date]['payment-yes']++;
                $report_month[$month]['payment-yes']++;
            } else {
                $report[$date]['payment-no']++;
                $report_month[$month]['payment-no']++;
            }
            if($value->payment_status == '1') {
                $report[$date]['delivery-yes']++;
                $report_month[$month]['delivery-yes']++;
            } else {
                $report[$date]['delivery-no']++;
                $report_month[$month]['delivery-no']++;
            }
        }

        if ($region == 'en') {
            $currency = "AUD";
        }else {
            $currency = "CNY";
        }

        $view = $request->input('view');
        if($view && $view == "day") {
            $result = $report;
        } else {
            $result = $report_month;
        }

        if ($export == "1") {
            $headlist = array("Date","Total","Success","Processing","Cancel By Buyer","Cancel By Seller","Return","Unpaid","Paid","Not Shipped","Shipped","Sales");
            $filename = "Findfood_Report_".$currency."_".date("Y-m-d", $date_start)."_".date("Y-m-d", $date_end);
            $this->create_csv($result, $headlist, $filename);
        } else {
            return view('/admin.finance')
                    ->with('report', json_encode($result))
                    ->with('start', date("d-m-Y", $date_start))->with('end', date("d-m-Y", $date_end))
                    ->with("currency", $currency)
                    ->with("region", $region)
                    ->with("view", $view);
        }
    }

    function create_csv($data,$header=null,$filename='simple.csv'){
        // 如果手动设置表头；则放在第一行
        if (!is_null($header)) {
            array_unshift($data, $header);
        }
        // 防止没有添加文件后缀
        $filename=str_replace('.csv', '', $filename).'.csv';
        ob_clean();
        Header( "Content-type:  application/octet-stream ");
        Header( "Accept-Ranges:  bytes ");
        Header( "Content-Disposition:  attachment;  filename=".$filename);
        foreach( $data as $k => $v){
            // 如果是二维数组；转成一维
            if (is_array($v)) {
                $v=implode(',', $v);
            }
            // 替换掉换行
            $v=preg_replace('/\s*/', '', $v);
            // 解决导出的数字会显示成科学计数法的问题
            $v=str_replace(',', "\t,", $v);
            // 转成gbk以兼容office乱码的问题
            echo iconv('UTF-8','GBK',$v)."\t\r\n";
        }
    }

    public function category(Request $request){
        $tree = array();
        $this->getTree('0', $tree);
        // $category = DB::table('category')->get();
        return view('/admin.category')->with('category', json_encode($tree))->with('tree', $tree);
    }

    private function getTree($father, &$tree){
        $category = DB::table('category')->where("father", $father)->get();
        if (!empty($category)) {
            foreach ($category as $c) {
                $tree[] = $c;
                $this->getTree($c->id, $tree);
            }
        } 
        return true;
    }

    public function tag(Request $request){
        $tag = DB::table('tag')->get();
        return view('/admin.tag')->with('tag', json_encode($tag));
    }

    public function portfolioNew(Request $request){
        $media = DB::table('media_library')->where("category", "!=", "folder")->get();
        foreach ($media as $value) {
            $value->featured = 0;
            $value->narrow = 0;
            if ($value->father != 0) {
                $data = DB::table('media_library')->where("id", $value->father)->get();
                $folderName = $data[0]->name;
            } else {
                $folderName = "";
            }
            $value->foldername = $folderName;
        }
        $folder = DB::table('media_library')->where("father", "0")->where("category", "folder")->get();

        $tree = array();
        $this->getTree('0', $tree);
        
        $tag = DB::table('tag')->get();

        return view("/admin.portfolioNew")
            ->with('folder', $folder)
            ->with('media', json_encode($media))
            ->with("tree", $tree)
            ->with("tag", json_encode($tag));
    }

    public function portfolioEdit(Request $request, $id){
        $portfolio = DB::table('portfolios')
                    ->where('id', '=', $id)
                    ->get();

        $medias = DB::table('media_library')->where("category", "!=", "folder")->get();
        $mediaList = DB::table('media_portfolio')
                ->where('portfolio_id', '=' ,$id)
                ->get();

        foreach ($medias as $media) {
            $media->featured = 0;
            $media->narrow = 0;
            $media->tickClass = "";
            if ($media->father != 0) {
                $data = DB::table('media_library')->where("id", $media->father)->get(["name"]);
                $folderName = $data[0]->name;
            } else {
                $folderName = "";
            }
            $media->foldername = $folderName;
            foreach ($mediaList as $mediaPhoto) {
                if($id == $mediaPhoto->portfolio_id && $media->id == $mediaPhoto->media_id){
                    $media->featured = $mediaPhoto->featured;
                    $media->narrow = $mediaPhoto->narrow;
                    $media->tickClass = "mediaTick";
                    $media->sortID = $mediaPhoto->id;
                }
            }
        }

        $date = date_create($portfolio[0]->date);
        $portfolio[0]->date = date_format($date,"d-m-Y");

        $folder = DB::table('media_library')->where("father", "0")->where("category", "folder")->get();

        $tree = array();
        $this->getTree('0', $tree);
        
        $tag = DB::table('tag')->get();

        return view("/admin.portfolioEdit")
            ->with('folder', $folder)
            ->with("media", json_encode($medias))
            ->with("portfolio", json_encode($portfolio))
            ->with("tree", $tree)
            ->with("tag", json_encode($tag));
    }

    public function partnerNew(Request $request){
        $media = DB::table('media_library')->where("category", "!=", "folder")->get();
        foreach ($media as $value) {
            $value->featured = 0;
            $value->narrow = 0;
            if ($value->father != 0) {
                $data = DB::table('media_library')->where("id", $value->father)->get();
                $folderName = $data[0]->name;
            } else {
                $folderName = "";
            }
            $value->foldername = $folderName;
        }

        $folder = DB::table('media_library')->where("father", "0")->where("category", "folder")->get();
        return view("/admin.partnerNew")->with('media', json_encode($media))->with('folder', $folder);
    }

    public function partnerEdit(Request $request, $id){
        $portfolio = DB::table('partner')
                    ->where('id', '=', $id)
                    ->get();

        $medias = DB::table('media_library')->where("category", "!=", "folder")->get();

        foreach ($medias as $media) {
            $media->featured = 0;
            $media->narrow = 0;
            $media->tickClass = "";
            if ($media->father != 0) {
                $data = DB::table('media_library')->where("id", $media->father)->get(["name"]);
                $folderName = $data[0]->name;
            } else {
                $folderName = "";
            }
            $media->foldername = $folderName;
            if($media->id == $portfolio[0]->image_id){
                $media->tickClass = "mediaTick";
            }
        }

        $date = date_create($portfolio[0]->date);
        $portfolio[0]->date = date_format($date,"d-m-Y");
        
        $folder = DB::table('media_library')->where("father", "0")->where("category", "folder")->get();
        
        return view("/admin.partnerEdit")
            ->with("media", json_encode($medias))
            ->with("portfolio", json_encode($portfolio))
            ->with('folder', $folder);
    }

}
