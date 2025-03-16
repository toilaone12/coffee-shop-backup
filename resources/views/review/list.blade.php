@extends('dashboard')
@section('content')
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content" class="mx-5">
        <div class="row">
            <div class="col-xl-12 col-lg-6 col-sm-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Danh sách đánh giá</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="myTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Chọn</th>
                                    <th>STT</th>
                                    <th>Sản phẩm</th>
                                    <th>Tên người đánh giá</th>
                                    <th>Nội dung đánh giá</th>
                                    <th>Số sao đánh giá</th>
                                    <th>Chức năng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($list as $key => $one)
                                @if($one->id_reply == 0)
                                <tr>
                                    <td></td>
                                    <td><input type="checkbox" value="{{$one->id_review}}" id=""></td>
                                    <td>{{$key + 1}}</td>
                                    @foreach($listProduct as $product)
                                    @if($product->id_product == $one->id_product)
                                    <td class="id-product-{{$one->id_review}}" data-id="{{$product->id_product}}">
                                        {{$product->name_product}}
                                    </td>
                                    @endif
                                    @endforeach
                                    <td class="name-{{$one->id_review}}">{{$one->name_review}}</td>
                                    <td class="content-{{$one->id_review}}">
                                        {{$one->content_review}}
                                        @foreach($list as $reply)
                                        @if($reply->id_reply == $one->id_review)
                                        <ul class="list-group">
                                            <li class="list-group-item">
                                                <span class="text-danger">Quản trị viên: </span>
                                                <span class="reply-admin-{{$one->id_review}}">
                                                    {{$reply->content_review}}
                                                </span>
                                                <button class="btn btn-success choose-review" style="width: 40px; height: 40px;" data-id="{{$one->id_review}}" data-reply="{{$reply->id_review}}" data-toggle="modal" data-target="#updateReplyModal">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                            </li>
                                        </ul>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td class="rating-{{$one->id_review}}">{{$one->rating_review}}</td>
                                    <td>
                                        <button class="btn btn-success reply-review" style="width: 40px; height: 40px;" data-id="{{$one->id_review}}" data-toggle="modal" data-target="#replyModal" {{$one->is_update == 1 ? 'disabled' : ''}}>
                                            <i class="fa-solid fa-reply"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Reply -->
    <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Phản hồi đánh giá</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('review.reply')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id_reply" class="id-reply">
                        <div class="form-group">
                            <label for="reply">Phản hồi khách hàng (<span class="name-review"></span>) (<span title="Bắt buộc phải nhập" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                            <input type="text" name="title_reply" id="reply" class="form-control reply">
                            @error('title_reply')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        <div class="container text-center form-reply">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Trả lời</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Reply -->

    <!-- Modal Update Reply -->
    <div class="modal fade" id="updateReplyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Sửa phản hồi</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="update-review">
                    <div class="modal-body">
                        <input type="hidden" name="id_review" class="id-reply">
                        <div class="form-group">
                            <label for="reply-update">Phản hồi khách hàng (<span class="name-review"></span>) (<span title="Bắt buộc phải nhập" class="text-danger mx-auto cursor-pointer">*</span>)</label>
                            <input type="text" name="title_reply" id="reply-update" class="form-control review-update reply">
                            <span class="text-danger error-reply"></span>
                        </div>
                        <div class="container text-center form-reply">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary">Sửa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Modal Update Reply -->

    <!-- End of Main Content -->

</div>
@endsection