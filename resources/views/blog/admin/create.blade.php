{{ Form::open(['url' => 'blog/store', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12">
            {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter Blog Title'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('image', __('Image'), ['class' => 'form-label']) }}
            {{ Form::file('image', ['class' => 'form-control']) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('short_description', __('Short Description'), ['class' => 'form-label']) }}
            {{ Form::textarea('short_description', null, ['class' => 'form-control', 'rows' => 2, 'placeholder' => __('Enter Short Description')]) }}
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('content', __('Content'), ['class' => 'form-label']) }}
            {{ Form::textarea('content', null, ['class' => 'form-control pc-tinymce-2', 'id' => 'classic-editor', 'rows' => 5]) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    {{ Form::submit(__('Create'), ['class' => 'btn btn-secondary btn-rounded']) }}
</div>
{{ Form::close() }}
