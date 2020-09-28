<?php if($customFields): ?>
    <h5 class="col-12 pb-4"><?php echo trans('lang.main_fields'); ?></h5>
<?php endif; ?>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- Name Field -->
    <div class="form-group row ">
        <?php echo Form::label('name', trans("lang.user_name"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.user_name_placeholder")]); ?>

            <div class="form-text text-muted">
                <?php echo e(trans("lang.user_name_help")); ?>

            </div>
        </div>
    </div>

    <!-- Email Field -->
    <div class="form-group row ">
        <?php echo Form::label('email', trans("lang.user_email"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::text('email', null,  ['class' => 'form-control','placeholder'=>  trans("lang.user_email_placeholder")]); ?>

            <div class="form-text text-muted">
                <?php echo e(trans("lang.user_email_help")); ?>

            </div>
        </div>
    </div>
    <!-- Phone Field -->
    <div class="form-group row">
    <?php echo Form::label('phone', trans("lang.user_phone"), ['class' => 'col-3 control-label text-right']); ?>

    <div class="col9">
        <?php echo Form::text('phone', null, ['class' => 'form-control', 'placeholder'=> '08098123']); ?>

        <div class="form-text text-muted">
        Fill Number Phone
        </div>
    </div>
    </div>
    <!-- Password Field -->
    <div class="form-group row ">
        <?php echo Form::label('password', trans("lang.user_password"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::password('password', ['class' => 'form-control','placeholder'=>  trans("lang.user_password_placeholder")]); ?>

            <div class="form-text text-muted">
                <?php echo e(trans("lang.user_password_help")); ?>

            </div>
        </div>
    </div>

</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
    <!-- $FIELD_NAME_TITLE$ Field -->
    <div class="form-group row">
        <?php echo Form::label('avatar', trans("lang.user_avatar"), ['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <div style="width: 100%" class="dropzone avatar" id="avatar" data-field="avatar">
                <input type="hidden" name="avatar">
            </div>
            <a href="#loadMediaModal" data-dropzone="avatar" data-toggle="modal" data-target="#mediaModal" class="btn btn-outline-<?php echo e(setting('theme_color','primary')); ?> btn-sm float-right mt-1"><?php echo e(trans('lang.media_select')); ?></a>
            <div class="form-text text-muted w-50">
                <?php echo e(trans("lang.user_avatar_help")); ?>

            </div>
        </div>
    </div>
    <?php $__env->startPrepend('scripts'); ?>
    <script type="text/javascript">
        var user_avatar = '';
        <?php if(isset($user) && $user->hasMedia('avatar')): ?>
            user_avatar = {
            name: "<?php echo $user->getFirstMedia('avatar')->name; ?>",
            size: "<?php echo $user->getFirstMedia('avatar')->size; ?>",
            type: "<?php echo $user->getFirstMedia('avatar')->mime_type; ?>",
            collection_name: "<?php echo $user->getFirstMedia('avatar')->collection_name; ?>"
        };
                <?php endif; ?>
        var dz_user_avatar = $(".dropzone.avatar").dropzone({
                url: "<?php echo url('uploads/store'); ?>",
                addRemoveLinks: true,
                maxFiles: 1,
                init: function () {
                    <?php if(isset($user) && $user->hasMedia('avatar')): ?>
                    dzInit(this, user_avatar, '<?php echo url($user->getFirstMediaUrl('avatar','thumb')); ?>')
                    <?php endif; ?>
                },
                accept: function (file, done) {
                    dzAccept(file, done, this.element, "<?php echo config('medialibrary.icons_folder'); ?>");
                },
                sending: function (file, xhr, formData) {
                    dzSending(this, file, formData, '<?php echo csrf_token(); ?>');
                },
                maxfilesexceeded: function (file) {
                    dz_user_avatar[0].mockFile = '';
                    dzMaxfile(this, file);
                },
                complete: function (file) {
                    dzComplete(this, file, user_avatar, dz_user_avatar[0].mockFile);
                    dz_user_avatar[0].mockFile = file;
                },
                removedfile: function (file) {
                    dzRemoveFile(
                        file, user_avatar, '<?php echo url("settings/users/remove-media"); ?>',
                        'avatar', '<?php echo isset($user) ? $user->id : 0; ?>', '<?php echo url("uplaods/clear"); ?>', '<?php echo csrf_token(); ?>'
                    );
                }
            });
        dz_user_avatar[0].mockFile = user_avatar;
        dropzoneFields['avatar'] = dz_user_avatar;
    </script>
<?php $__env->stopPrepend(); ?>
<!-- Roles Field -->

    <div class="form-group row ">
        <?php echo Form::label('roles[]', trans("lang.user_role_id"),['class' => 'col-3 control-label text-right']); ?>

        <div class="col-9">
            <?php echo Form::select('roles[]', $role, $rolesSelected, ['class' => 'select2 form-control' , 'multiple'=>'multiple']); ?>

            <div class="form-text text-muted"><?php echo e(trans("lang.user_role_id_help")); ?></div>
        </div>
    </div>

</div>
<?php if($customFields): ?>
    
    <div class="clearfix"></div>
    <div class="col-12 custom-field-container">
        <h5 class="col-12 pb-4"><?php echo trans('lang.custom_field_plural'); ?></h5>
        <?php echo $customFields; ?>

    </div>
<?php endif; ?>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
    <button type="submit" class="btn btn-<?php echo e(setting('theme_color')); ?>"><i class="fa fa-save"></i> <?php echo e(trans('lang.save')); ?> <?php echo e(trans('lang.user')); ?></button>
    <a href="<?php echo route('users.index'); ?>" class="btn btn-default"><i class="fa fa-undo"></i> <?php echo e(trans('lang.cancel')); ?></a>
</div>
<?php /**PATH /home/admin/dev.tajeer.id/devtajeer/resources/views/settings/users/fields.blade.php ENDPATH**/ ?>