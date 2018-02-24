<div class="container section">
    <div class="columns">
        <div class="column is-12">
            <?php $this->load->view('error_msg/index') ?>
        </div>
    </div>
    <div class="columns">
        <div class="column is-12">
            <nav class="panel">
                <p class="panel-heading"> Detail Materi </p>
                <div class="panel-block">
                    <div class="tile is-ancestor">
                        <div class="tile is-parent is-12">
                            <article class="tile is-child box">
                                <p class="title is-6"><a href="#"><?= $course->title ?></a></p>
                                <?php if (($course->attachment != null || $course->attachment != '') && $this->session->userdata('sevima-elearning')) { ?>
                                    <p class="title is-6"><a href="<?= base_url('courses/download/' . $course->attachment) ?>">Unduh Lampiran</a></p>                                        
                                <?php } ?>
                                <p class="subtitle is-6">Oleh: <?= $course->name ?> Pada: <?= $course->created_at ?></p>
                                <div class="content">
                                   <?= $course->content ?>
                                </div>
                            </article>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <?php if ($this->session->userdata('sevima-elearning')) { ?>
    <div class="columns">
        <div class="column is-12">
            <form method="post" action="<?=base_url('comments/create')?>">
                <div class="field">
                    <label class="label">Tulis Komentar Disini</label>
                    <input type="hidden" value="<?= $course->id ?>" name="course_id">
                    <div class="control">
                        <textarea class="textarea" name="comment_content" placeholder="Komentar"></textarea>                                                        
                    </div>
                </div>
                <div class="field is-grouped is-grouped-right">
                    <div class="control">
                        <input type="submit" value="Beri Komentar" class="is-pulled-right button is-primary">
                    </div>
                </div>
            </form> 
        </div>
    </div>
    <?php } ?>
    <div class="columns">
        <div class="column is-12">
            <h1 class="is-size-3">Daftar Komentar</h1>            
        </div>
    </div>
    
    <?php foreach($comments as $key => $comment)  { ?>
        <div class="columns">
            <div class="column is-12">
                <div class="tile is-ancestor">
                    <div class="tile is-parent is-12">
                        <article class="tile is-child box">
                            <p class="title is-6">
                                <a href="#"><?= $comment->name ?></a>
                            </p>
                            <p class="subtitle is-6">Pada: <?= $comment->created_at ?></p>

                            <div class="content">
                                <p><?= $comment->comment_content ?></p>
                            </div>
                            <nav class="level">
                                <div class="level-left"></div>
                                <div class="level-right">
                                    <div class="level-item">
                                        <a class="button is-danger">Hapus</a>
                                    </div>
                                </div>
                            </nav>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

