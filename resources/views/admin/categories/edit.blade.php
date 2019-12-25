@extends('admin.app')

@section('page_title','Edit')

@section('extra_css')

@endsection

@section('main-content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Edit Category
        <a href="{{ route('categories.index') }}" class="btn btn-success pull-right ">List</a>
        <a href="{{ route('categories.create') }}" class="btn btn-success pull-right ">Add</a>


    </h1>
    {{-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
    </ol> --}}
</section>

<!-- Main content -->
<section class="content">
    @include('includes.messages')

    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit category</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form role="form" method="POST" action="{{ route('categories.update',$category->id) }}">

            @csrf
            @method('PATCH')
            <div class="box-body">
                <div class="form-group">
                    <label for="name">Category Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter categroy name"
                        value="{{ $category->name }}" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="slug">Category Slug</label>
                    <input type="text" class="form-control" value="{{ $category->slug }}" name="slug" id="slug"
                        placeholder="Enter categroy slug">
                </div>

                <div class="form-group">
                    <label>Parent category</label>
                    <select class="form-control" name="parent_category">
                        <option value="">Select one</option>
                        @foreach ($categories as $cat)
                        <option value={{ $cat->id }} {{ ($cat->id == $category->parent_category) ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>

                    </select>
                </div>



            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <button type="submit" class="btn btn-primary"
                    onClick="this.form.submit(); this.disabled=true; this.innerText='Submitting....'; ">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.box -->



</section>
<!-- /.content -->

@endsection

@section('extra_js')




<script>
    let parent = document.getElementById('name')

    parent.addEventListener('keyup',makeslug)

    function makeslug(){
        let slugField = document.getElementById('slug')

        let slug = convertToSlug(parent.value);

        slugField.value = slug;
        console.log();
    }

    function convertToSlug(Text)
    {
        return Text
            .toLowerCase()
            .replace(/[^\w ]+/g,'')
            .replace(/ +/g,'-')
            ;
    }


</script>


@endsection