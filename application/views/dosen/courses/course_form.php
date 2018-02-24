<div class="container section">
    <div class="columns">
        <div class="column is-8 is-offset-2">
            <h1 class="is-size-3"><?= $form_title ?></h1>
            <div class="box">
                <?php $this->load->view('error_msg/index') ?>                
                <form method="post" action="<?=base_url($form_action)?>" enctype="multipart/form-data" accept-charset="utf-8">
                    <div class="field">
                        <label class="label">Nama</label>
                        <div class="control">
                            <input class="input" type="text" name="title" placeholder="Nama" value="<?= $is_edit ? $course->title : '' ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Durasi (Jam)</label>
                        <div class="control">
                            <input class="input" type="number" name="duration" placeholder="Durasi" value="<?= $is_edit ? $course->duration : '' ?>">
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Deskripsi Singkat</label>
                        <div class="control">
                            <textarea class="textarea" name="description" placeholder="Deskripsi Singkat"><?= $is_edit ? $course->description : '' ?></textarea>                                                        
                        </div>
                    </div>
                    <?php if ($is_edit) { ?>
                    <div class="field">
                        <label class="label">Lampiran Sebelumnya</label>
                        <div class="control">
                            <p class="help"><?= $is_edit ? $course->attachment : '' ?></p>
                        </div>
                    </div>
                    <?php } ?>
                    <div class="field">
                        <label class="label"><?= $is_edit ? 'Ganti' : '' ?> Lampiran (Opsional)</label>
                        <div class="control">
                            <input type="file" class="form-control" name="attachment" onchange="checkFile(this,event)">
                            <p class="help">Ekstensi file yang diperbolehkan (.docx, .pdf, .xlsx, .pptx, .jpg, .jpeg, .png, .mp4). Dengan ukuran maksimal 50 MB.</p>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Konten</label>
                        <div class="control">
                            <textarea class="textarea" name="content" placeholder="Kontent" id="content" rows="10"><?= $is_edit ? $course->content : '' ?></textarea>                                                                                    
                        </div>
                    </div>
                    <div class="field is-grouped is-grouped-right">
                        <div class="control">
                            <input type="submit" value="Simpan" class="is-pulled-right button is-primary">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.ck-editor__editable {
    min-height: 400px;
}
</style>

<script>
$(() => {
    initCkeditor();
});

function initCkeditor() {
    ClassicEditor
        .create( document.querySelector( '#content' ) )
        .catch( error => {
            console.error( error );
        } );    
}
</script>