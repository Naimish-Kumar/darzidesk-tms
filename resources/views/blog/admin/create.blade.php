{{ Form::open(['route' => 'blog.store', 'method' => 'post', 'enctype' => 'multipart/form-data']) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-12 mb-3">
            {{ Form::label('title', __('Title'), ['class' => 'form-label']) }}
            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => __('Enter a catchy blog title'), 'required' => 'required']) }}
        </div>
        <div class="form-group col-12 mb-3">
            {{ Form::label('image', __('Featured Image'), ['class' => 'form-label']) }}
            {{ Form::file('image', ['class' => 'form-control', 'accept' => 'image/*']) }}
            <small class="text-muted">{{ __('Recommended size: 1200x800px. Max 2MB.') }}</small>
        </div>
        <div class="form-group col-12 mb-3">
            {{ Form::label('short_description', __('Short Description'), ['class' => 'form-label']) }}
            {{ Form::textarea('short_description', null, ['class' => 'form-control', 'rows' => 3, 'placeholder' => __('A brief summary for the blog list page...')]) }}
        </div>
        <div class="form-group col-12 mb-3">
            {{ Form::label('content', __('Detailed Content'), ['class' => 'form-label']) }}
            {{ Form::textarea('content', null, ['class' => 'form-control pc-tinymce-2', 'id' => 'classic-editor', 'rows' => 10]) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    {{ Form::submit(__('Create Blog'), ['class' => 'btn btn-primary']) }}
</div>
{{ Form::close() }}
