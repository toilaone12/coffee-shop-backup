<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SlideController extends Controller
{
    function list(){
        $title = 'Danh sách quảng cáo';
        $list = Slide::all();
        $notifications = Notification::where('id_account',request()->cookie('id_account'))->orderBy('id_notification','desc')->limit(7)->get();
        $all = Notification::where('id_account',request()->cookie('id_account'))->get();
        $dot = false;
        foreach($all as $noti){
            if($noti->is_read == 0){
                $dot = true;
            }else{
                $dot = false;
            }
        }
        return view('slide.list',compact('title','list','notifications','dot'));
    }

    function insert(Request $request){
        $data = $request->all();
        $image = $request->file('image_slide');
        $fileName = rand(0,999) . '-' . strtotime(now()) . '.jpg';
        Validator::make($data,[
            'image_slide' => ['required','image','mimes:jpeg,png,jpg,gif,webp'],
        ],[
            'image_slide.required' => 'Vui lòng chọn một tệp ảnh.',
            'image_slide.image' => 'Tệp phải là hình ảnh.',
            'image_slide.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
            'name_slide.required' => 'Tên của ảnh bắt buộc phải có',
            'slug_slide.required' => 'Địa chỉ sau URL bắt buộc phải có'
        ])->validate();
        $image->storeAs('public/slide', $fileName); // se luu vao storage/app
        $db = [
            'image_slide' => 'storage/slide/'.$fileName,
        ];
        $insert = Slide::create($db);
        if($insert){
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã thêm quảng cáo',
                'link' => redirect()->route('slide.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return redirect()->route('slide.list')->with('message','<span class="mx-3 text-success">Thêm thành công</span>');
        }else{
            return redirect()->route('slide.list')->with('message','<span class="mx-3 text-success">Lỗi truy vấn!</span>');
        }
    }

    function update(Request $request){
        $data = $request->all();
        $image = $request->file('image_slide');
        $errors = [];
        $validator = Validator::make($data,[
            'image_slide' => ['image','mimes:jpeg,png,jpg,gif,webp'],
            'name_slide' => ['required'],
            'slug_slide' => ['required']
        ],[
            'image_slide.image' => 'Tệp phải là hình ảnh.',
            'image_slide.mimes' => 'Định dạng tệp không hợp lệ. Chấp nhận định dạng jpeg, png, jpg, gif.',
            'name_slide.required' => 'Tên của ảnh bắt buộc phải có',
            'slug_slide.required' => 'Địa chỉ sau URL bắt buộc phải có'
        ]);
        if(!$validator->fails()){
            $slug = Str::slug($data['slug_slide'], '-');
            $fileName = $slug . '-' . strtotime(now()) . '.jpg';
            if($image){
                $checkImageOriginal = Storage::disk('public')->exists($data['image_original_slide']);
                $image->storeAs('public/slide', $fileName); // se luu vao storage/app
                // $data['image_slide']->storeAs('public', $fileName);
                if($checkImageOriginal){
                    Storage::disk('public')->delete('slide/'.$data['image_original_slide']);
                }
            }
            $slide = Slide::find($data['id_slide']);
            $slide->image_slide = $image ? 'storage/slide/'.$fileName : 'storage/slide/'.$data['image_original_slide'];
            $slide->name_slide = $data['name_slide'];
            $slide->slug_slide = $data['slug_slide'];
            $update = $slide->save();
            if($update){
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã cập nhật lại quảng cáo "'.$data['name_slide'].'"',
                    'link' => redirect()->route('slide.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                return response()->json(['res' => 'success', 'title' => 'Sửa quảng cáo', 'icon' => 'success', 'status' => 'Thay đổi dữ liệu thành quảng cáo về '.$data['name_slide'].' thành công']);
            }else{
                return response()->json(['res' => 'fail', 'title' => 'Sửa quảng cáo', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
            }
        }else{
            return response()->json(['res' => 'warning', 'status' => $validator->errors()]);
        }
    }

    function delete(Request $request){
        $data = $request->all();
        $slide = Slide::find($data['id']);
        if($slide){
            $name = $slide->name_slide;
            $slide->delete();
            $noti = [
                'id_account' => request()->cookie('id_account'),
                'id_customer' => 0,
                'content' => 'Bạn đã xóa quảng cáo "'.$name.'"',
                'link' => redirect()->route('slide.list')->getTargetUrl(),
                'is_read' => 0,
            ];
            Notification::create($noti);
            return response()->json(['res' => 'success', 'title' => 'Xóa quảng cáo', 'icon' => 'success', 'status' => 'Xóa thành công'],200);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Sửa quảng cáo', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }

    function deleteAll(Request $request){
        $data = $request->all();
        $noti = [];
        foreach($data['arrId'] as $key => $id){
            $slide = Slide::where('id_slide',$id)->first();
            if($slide){
                $name = $slide->name_slide;
                $slide->delete();
                $noti = [
                    'id_account' => request()->cookie('id_account'),
                    'id_customer' => 0,
                    'content' => 'Bạn đã xóa quảng cáo "'.$name.'"',
                    'link' => redirect()->route('slide.list')->getTargetUrl(),
                    'is_read' => 0,
                ];
                Notification::create($noti);
                $noti += ['res' => 'success'];
            }else{
                $noti += ['res' => 'fail'];
            }
        }
        if($noti['res'] == 'success'){
            return response()->json(['res' => 'success', 'title' => 'Xóa quảng cáo', 'icon' => 'success', 'status' => 'Xóa thành công'],200);
        }else{
            return response()->json(['res' => 'fail', 'title' => 'Sửa quảng cáo', 'icon' => 'error', 'status' => 'Lỗi truy vấn dữ liệu']);
        }
    }
}
