<form action="{{ $__currentUrl }}" method="post" accept-charset="utf-8">
    {!! csrf_field() !!}
<div class="row gutters">
    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
        <div class="card h-100">
            <div class="card-header">
                <div class="card-title">Cấu hình chung</div>
            </div>
            <div class="card-body">
                <div class="row gutters">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="form-group">
                            <label for="name">Tên website</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Tên website" value="{{getConfig('name')}}">
                            <small class="form-text text-muted">{!! show_error('name') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo Website</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="logo" name="logo" placeholder="Logo Website" readonly="readonly" value="{{getConfig('logo')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="loadMedia('logo')"><i class="icon-image"></i> Chọn logo</button>
                                </div>
                            </div>
                            <small class="form-text text-muted">{!! show_error('logo') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="logo_dark">Logo Website (dark)</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="logo_dark" name="logo_dark" placeholder="Logo Website" readonly="readonly" value="{{getConfig('logo_dark')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="loadMedia('logo_dark')"><i class="icon-image"></i> Chọn logo</button>
                                </div>
                            </div>
                            <small class="form-text text-muted">{!! show_error('logo_dark') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="photo">Biểu tượng Favicon</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="favicon" name="favicon" placeholder="Biểu tượng favicon" readonly="readonly" value="{{getConfig('favicon')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="loadMedia('favicon')"><i class="icon-image"></i> Chọn favicon</button>
                                </div>
                            </div>
                            <small class="form-text text-muted">{!! show_error('favicon') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email Website" value="{{getConfig('email')}}">
                            <small class="form-text text-muted">{!! show_error('email') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Website" value="{{getConfig('phone')}}">
                            <small class="form-text text-muted">{!! show_error('phone') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" id="author" name="author" placeholder="Author Metadata" value="{{getConfig('author')}}">
                            <small class="form-text text-muted">{!! show_error('author') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="author_url">Author URL</label>
                            <input type="text" class="form-control" id="author_url" name="author_url" placeholder="Author Metadata URL" value="{{getConfig('author_url')}}">
                            <small class="form-text text-muted">{!! show_error('author_url') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="copyright">Copyright</label>
                            <input type="text" class="form-control" id="copyright" name="copyright" placeholder="Copyright Info" value="{{getConfig('copyright')}}">
                            <small class="form-text text-muted">{!! show_error('copyright') !!}</small>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <button type="submit" class="btn btn-success btn-lg"><i class="fa fa-save"></i> Cập nhật</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
        <div class="card h-100">
            <div class="card-header">
                <div class="card-title">Cấu hình SEO</div>
            </div>
            <div class="card-body">
                <div class="row gutters">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="title">Tiêu đề trang chủ</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Tiêu đề trang chủ" value="{{getConfig('title')}}">
                            <small class="form-text text-muted">{!! show_error('title') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả website</label>
                            <textarea class="form-control" id="description" name="description" rows="2" style="resize:none" placeholder="Nội dung mô tả website">{!! getConfig('description') !!}</textarea>
                            <small class="form-text text-muted">{!! show_error('description') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="keywords">Từ khoá</label>
                            <input class="form-control" id="keywords" name="keywords" placeholder="Đặt từ khoá tìm kiếm" data-role="tagsinput" value="{{getConfig('keywords')}}" >
                            <small class="form-text text-muted">{!! show_error('keywords') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="photo">Ảnh mặc định</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="photo" name="photo" placeholder="Ảnh mặc định của Website" readonly="readonly" value="{{getConfig('photo')}}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" onclick="loadMedia('photo')"><i class="icon-image"></i> Chọn ảnh</button>
                                </div>
                            </div>
                            <small class="form-text text-muted">{!! show_error('photo') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="addresss">Địa chỉ</label>
                            <textarea class="form-control" id="address" name="address" rows="2" style="resize:none" placeholder="Địa chỉ công ty">{!! getConfig('address') !!}</textarea>
                            <small class="form-text text-muted">{!! show_error('address') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="about_us">Nói về website</label>
                            <textarea class="form-control" id="about_us" name="about_us" rows="5" style="resize:none" placeholder="Nội dung giới thiệu">{!! getConfig('about_us') !!}</textarea>
                            <small class="form-text text-muted">{!! show_error('about_us') !!}</small>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="facebook">Link Facebook</label>
                            <input type="text" class="form-control" id="facebook" name="facebook" placeholder="Link Facebook" value="{{getConfig('facebook')}}">
                            <small class="form-text text-muted">{!! show_error('facebook') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="twitter">Link Twitter</label>
                            <input type="text" class="form-control" id="twitter" name="twitter" placeholder="Link Twitter" value="{{getConfig('twitter')}}">
                            <small class="form-text text-muted">{!! show_error('twitter') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="youtube">Link Youtube</label>
                            <input type="text" class="form-control" id="youtube" name="youtube" placeholder="Link Youtube" value="{{getConfig('youtube')}}">
                            <small class="form-text text-muted">{!! show_error('youtube') !!}</small>
                        </div>
                        <div class="form-group">
                            <label for="intagram">Link Intagram</label>
                            <input type="text" class="form-control" id="intagram" name="intagram" placeholder="Link Intagram" value="{{getConfig('intagram')}}">
                            <small class="form-text text-muted">{!! show_error('intagram') !!}</small>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <label for="privacy">Nội dung điều khoản đăng nhập</label>
                            <textarea class="form-control js-summernote" id="privacy" name="privacy" rows="10" style="resize:none" placeholder="Nội dung điều khoản">{!! getConfig('privacy') !!}</textarea>
                            <small class="form-text text-muted">{!! show_error('privacy') !!}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
